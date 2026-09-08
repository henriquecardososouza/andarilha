<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\AccountInvitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserInvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_user_only_takes_a_name_and_an_email(): void
    {
        Notification::fake();

        $this->actingAs(User::factory()->create())
            ->postJson(route('admin.users.store'), [
                'name' => 'Pessoa Nova',
                'email' => 'nova@andarilha.test',
            ])->assertOk();

        $invited = User::query()->where('email', 'nova@andarilha.test')->sole();

        $this->assertNull($invited->password);
        $this->assertNull($invited->email_verified_at);
        $this->assertFalse((bool) $invited->has_changed_password);

        Notification::assertSentTo($invited, AccountInvitation::class);
    }

    public function test_the_emailed_link_creates_the_password_and_signs_the_person_in(): void
    {
        Notification::fake();

        $this->actingAs(User::factory()->create())->postJson(route('admin.users.store'), [
            'name' => 'Pessoa Nova',
            'email' => 'nova@andarilha.test',
        ]);

        $invited = User::query()->where('email', 'nova@andarilha.test')->sole();

        $this->post(route('admin.logout'));

        $this->post(route('admin.invitation.store'), [
            'token' => $this->tokenFromInvitation($invited),
            'email' => $invited->email,
            'password' => 'SenhaBemForte9',
            'password_confirmation' => 'SenhaBemForte9',
        ])->assertRedirect(route('admin.quotations.index'));

        $invited->refresh();

        $this->assertNotNull($invited->password);
        $this->assertNotNull($invited->email_verified_at);
        $this->assertTrue((bool) $invited->has_changed_password);
        $this->assertAuthenticatedAs($invited);
        $this->assertSame(0, DB::table('password_reset_tokens')->where('email', $invited->email)->count());
    }

    public function test_a_used_link_cannot_be_replayed(): void
    {
        Notification::fake();

        $invited = User::factory()->create(['password' => null, 'email_verified_at' => null]);
        app(\App\Services\Admin\AccountInvitations::class)->send($invited);
        $token = $this->tokenFromInvitation($invited);

        $this->post(route('admin.invitation.store'), [
            'token' => $token,
            'email' => $invited->email,
            'password' => 'SenhaBemForte9',
            'password_confirmation' => 'SenhaBemForte9',
        ]);

        $this->post(route('admin.logout'));

        $this->from(route('admin.login'))->post(route('admin.invitation.store'), [
            'token' => $token,
            'email' => $invited->email,
            'password' => 'OutraSenhaForte9',
            'password_confirmation' => 'OutraSenhaForte9',
        ])->assertSessionHasErrors('email');

        $this->assertTrue(password_verify('SenhaBemForte9', $invited->fresh()->password));
    }

    public function test_the_invitation_is_only_resent_while_it_is_pending(): void
    {
        Notification::fake();

        $admin = User::factory()->create();
        $pending = User::factory()->create(['password' => null, 'email_verified_at' => null]);

        $this->actingAs($admin)
            ->postJson(route('admin.users.invitation', $pending))
            ->assertOk();

        Notification::assertSentTo($pending, AccountInvitation::class);

        $settled = User::factory()->create();

        $this->actingAs($admin)
            ->postJson(route('admin.users.invitation', $settled))
            ->assertStatus(422);

        Notification::assertNotSentTo($settled, AccountInvitation::class);
    }

    private function tokenFromInvitation(User $user): string
    {
        $token = null;

        Notification::assertSentTo($user, AccountInvitation::class, function (AccountInvitation $notification) use ($user, &$token) {
            $url = $notification->toMail($user)->viewData['action']['url'];
            preg_match('#criar-senha/([^?]+)#', $url, $matches);
            $token = $matches[1] ?? null;

            return true;
        });

        return $token;
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlockedAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_account_blocked_mid_session_is_sent_to_the_blocked_page(): void
    {
        $user = User::factory()->create(['blocked' => true]);

        foreach (['admin.quotations.index', 'admin.destinies.index', 'admin.users.index', 'admin.profile.show'] as $route) {
            $this->actingAs($user)->get(route($route))->assertRedirect(route('admin.blocked'));
        }
    }

    public function test_a_blocked_account_can_still_read_the_notice_and_sign_out(): void
    {
        $user = User::factory()->create(['blocked' => true]);

        $this->actingAs($user)->get(route('admin.blocked'))
            ->assertOk()
            ->assertSee(__('admin.blocked.heading'), false);

        $this->actingAs($user)->post(route('admin.logout'))->assertRedirect(route('landing'));

        $this->assertGuest();
    }

    public function test_a_blocked_account_gets_a_403_on_writes(): void
    {
        $user = User::factory()->create(['blocked' => true]);

        $this->actingAs($user)
            ->patchJson(route('admin.profile.update'), ['name' => 'Nome Novo'])
            ->assertStatus(403);

        $this->assertSame($user->name, $user->fresh()->name);
    }

    public function test_an_active_account_passes_through(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.quotations.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.blocked'))->assertRedirect(route('admin.quotations.index'));
    }
}

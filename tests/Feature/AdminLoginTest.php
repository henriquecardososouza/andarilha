<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_signs_in_and_lands_on_the_quotations_page(): void
    {
        $user = User::factory()->create();

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.quotations.index'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_a_wrong_password_is_refused(): void
    {
        $user = User::factory()->create();

        $this->from(route('admin.login'))->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'nao-e-a-senha',
        ])->assertRedirect(route('admin.login'))->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_a_blocked_account_cannot_sign_in(): void
    {
        $user = User::factory()->create(['blocked' => true]);

        $this->from(route('admin.login'))->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors(['email' => __('admin.login.blocked')]);

        $this->assertGuest();
    }

    public function test_the_panel_is_closed_to_visitors(): void
    {
        $this->get(route('admin.quotations.index'))->assertRedirect(route('admin.login'));
    }
}

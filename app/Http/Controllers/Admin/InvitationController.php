<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvitationRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function create(string $token): View
    {
        return view('admin.auth.invitation', [
            'token' => $token,
            'email' => request()->string('email')->value(),
        ]);
    }

    /**
     * Accepting the invitation proves the address, so the account lands verified.
     *
     * @throws ValidationException
     */
    public function store(InvitationRequest $request): RedirectResponse
    {
        $accepted = null;

        $status = Password::broker('invitations')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) use (&$accepted): void {
                $user->forceFill([
                    'password' => $password,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                    'has_changed_password' => true,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                $accepted = $user;
            },
        );

        if ($status !== Password::PasswordReset) {
            throw ValidationException::withMessages(['email' => __($status)]);
        }

        if ($accepted->blocked) {
            throw ValidationException::withMessages(['email' => __('admin.login.blocked')]);
        }

        Auth::login($accepted);
        $request->session()->regenerate();

        return redirect()
            ->route('admin.quotations.index')
            ->with('toast', ['type' => 'success', 'message' => __('admin.invite.done', ['name' => $accepted->name])]);
    }
}

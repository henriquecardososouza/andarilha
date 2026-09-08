<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Notifications\AccountInvitation;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;

final class AccountInvitations
{
    public function send(User $user): void
    {
        $user->notify(new AccountInvitation($this->broker()->createToken($user)));
    }

    /**
     * An account keeps its invitation open until its owner picks a password.
     */
    public function isPending(User $user): bool
    {
        return $user->password === null;
    }

    private function broker(): PasswordBroker
    {
        return Password::broker('invitations');
    }
}

<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

final class UserRepository
{
    private const PER_PAGE = 15;

    public function __construct(private readonly AccountInvitations $invitations)
    {
    }

    public function paginate(?string $search): LengthAwarePaginator
    {
        return User::query()
            ->when($search, fn (Builder $query, string $term) => $query->where(
                fn (Builder $group) => $group
                    ->where('name', 'like', $this->like($term))
                    ->orWhere('email', 'like', $this->like($term)),
            ))
            ->orderBy('name')
            ->paginate(self::PER_PAGE)
            ->withQueryString()
            ->through(fn (User $user) => $user->setAttribute(
                'invitation_pending',
                $this->invitations->isPending($user),
            ));
    }

    private function like(string $term): string
    {
        return '%'.addcslashes($term, '%_'.chr(92)).'%';
    }
}

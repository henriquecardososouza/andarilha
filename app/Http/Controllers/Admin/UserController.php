<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
use App\Services\Admin\AccountInvitations;
use App\Services\Admin\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request, UserRepository $users): View
    {
        $search = $request->filled('search') ? trim($request->string('search')->value()) : null;
        $results = $users->paginate($search);

        if ($request->header('X-Partial') === 'table') {
            return view('admin.partials.users-results', [
                'users' => $results,
                'currentUser' => $request->user(),
            ]);
        }

        return view('admin.users', [
            'users' => $results,
            'currentUser' => $request->user(),
            'search' => $search,
            'action' => route('admin.users.index'),
            'storeAction' => route('admin.users.store'),
        ]);
    }

    public function store(StoreUserRequest $request, AccountInvitations $invitations): JsonResponse|RedirectResponse
    {
        $user = User::create($request->validated());

        $invitations->send($user);

        return $this->respond($request, __('admin.users.created', ['name' => $user->name]));
    }

    /**
     * Issues a fresh link, which retires the one sent before.
     */
    public function resendInvitation(Request $request, User $user, AccountInvitations $invitations): JsonResponse|RedirectResponse
    {
        if (! $invitations->isPending($user)) {
            return $this->respond($request, __('admin.users.already_accepted', ['name' => $user->name]), 422);
        }

        $invitations->send($user);

        return $this->respond($request, __('admin.users.invitation_resent', ['name' => $user->name]));
    }

    /**
     * Block or release another account. Never the one making the request.
     */
    public function toggleBlock(Request $request, User $user): JsonResponse|RedirectResponse
    {
        if ($request->user()->is($user)) {
            return $this->respond($request, __('admin.users.cannot_block_self'), 422);
        }

        $user->update(['blocked' => ! $user->blocked]);

        return $this->respond($request, __(
            $user->blocked ? 'admin.users.blocked' : 'admin.users.released',
            ['name' => $user->name],
        ));
    }

    private function respond(Request $request, string $message, int $status = 200): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], $status);
        }

        return back()->with('toast', [
            'type' => $status === 200 ? 'success' : 'error',
            'message' => $message,
        ]);
    }
}

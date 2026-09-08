<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        return view('admin.profile', [
            'user' => $request->user(),
            'updateAction' => route('admin.profile.update'),
            'passwordAction' => route('admin.profile.password'),
        ]);
    }

    public function update(UpdateProfileRequest $request): JsonResponse|RedirectResponse
    {
        $request->user()->update($request->validated());

        return $this->respond($request, __('admin.profile.name_saved'));
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse|RedirectResponse
    {
        $request->user()->update([
            'password' => $request->validated('password'),
            'has_changed_password' => true,
        ]);

        return $this->respond($request, __('admin.profile.password_saved'));
    }

    private function respond(Request $request, string $message): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('toast', ['type' => 'success', 'message' => $message]);
    }
}

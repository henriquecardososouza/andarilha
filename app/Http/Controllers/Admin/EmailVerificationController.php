<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function notice(Request $request): View|RedirectResponse
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->route('admin.quotations.index')
            : view('admin.auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()
            ->route('landing')
            ->with('toast', ['type' => 'success', 'message' => __('admin.verify.done')]);
    }

    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('admin.quotations.index');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('admin.verify.sent'),
        ]);
    }
}

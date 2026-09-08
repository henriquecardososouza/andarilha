<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsNotBlocked
{
    /**
     * Keeps an account that was blocked mid session from reaching the panel.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->blocked) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => __('admin.blocked.lead')], 403);
        }

        return redirect()->route('admin.blocked');
    }
}

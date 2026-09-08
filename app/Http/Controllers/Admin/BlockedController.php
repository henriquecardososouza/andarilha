<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlockedController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        return $request->user()->blocked
            ? view('admin.auth.blocked')
            : redirect()->route('admin.quotations.index');
    }
}

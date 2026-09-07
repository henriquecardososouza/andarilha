<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DestinationCatalog;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(DestinationCatalog $destinations): View
    {
        return view('landing.index', [
            'slides' => $destinations->slides(),
            'backdrop' => $destinations->backdrop(),
        ]);
    }
}

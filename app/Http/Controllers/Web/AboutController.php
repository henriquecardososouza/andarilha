<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DestinationCatalog;
use App\Services\SiteContent;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(SiteContent $content, DestinationCatalog $destinations): View
    {
        return view('about.index', [
            'banner' => $destinations->find('paris'),
            'storyImages' => $destinations->pair('tokyo', 'rio'),
            'stats' => $content->stats(),
            'team' => $content->team(),
        ]);
    }
}

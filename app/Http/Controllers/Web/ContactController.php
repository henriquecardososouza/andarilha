<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DestinationCatalog;
use App\Services\SiteContent;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(SiteContent $content, DestinationCatalog $destinations): View
    {
        return view('contact.index', [
            'banner' => $destinations->find('london'),
            'backdrop' => $destinations->backdrop(),
            'channels' => $content->channels(),
            'questions' => $content->faq(),
        ]);
    }
}

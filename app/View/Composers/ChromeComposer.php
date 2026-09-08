<?php

namespace App\View\Composers;

use App\Services\SiteContent;
use App\Services\SiteNavigation;
use Illuminate\View\View;

class ChromeComposer
{
    public function __construct(
        private readonly SiteNavigation $navigation,
        private readonly SiteContent $content,
    ) {}

    /**
     * Feed the header and footer everything they render.
     */
    public function compose(View $view): void
    {
        $view->with([
            'navigation' => $this->navigation->items(),
            'locales' => config('locales.supported'),
            'currentLocale' => app()->getLocale(),
            'channels' => $this->content->channels(),
            'year' => date('Y'),
            'authenticated' => auth()->user(),
        ]);
    }
}

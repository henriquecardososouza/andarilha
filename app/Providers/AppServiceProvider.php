<?php

namespace App\Providers;

use App\View\Composers\AdminChromeComposer;
use App\View\Composers\ChromeComposer;
use App\View\Composers\QuoteFormComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Domains that keep their own anonymous components, exposed as x-{domain}::{name}.
     */
    private const DOMAINS = ['landing', 'about', 'contact', 'admin'];

    public function register(): void
    {
    }

    public function boot(): void
    {
        foreach (self::DOMAINS as $domain) {
            Blade::anonymousComponentPath(resource_path("views/{$domain}/components"), $domain);
        }

        View::composer(['partials.header', 'partials.footer'], ChromeComposer::class);
        View::composer('components.quote-form', QuoteFormComposer::class);
        View::composer('admin.partials.navbar', AdminChromeComposer::class);
    }
}

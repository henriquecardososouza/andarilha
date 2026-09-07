<?php

namespace App\View\Composers;

use Illuminate\View\View;

class QuoteFormComposer
{
    /**
     * Supply the quote form with its endpoints, bounds and feedback strings.
     */
    public function compose(View $view): void
    {
        $view->with([
            'action' => route('quotation.store'),
            'destiniesEndpoint' => route('destinies.index'),
            'earliestDate' => now()->addDay()->toDateString(),
            'feedback' => [
                'success' => __('landing.contact.feedback.success'),
                'invalid' => __('landing.contact.feedback.invalid'),
                'failed' => __('landing.contact.feedback.failed'),
            ],
        ]);
    }
}

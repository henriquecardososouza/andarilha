<?php

namespace App\Notifications;

use App\Enums\QuotationTypesEnum;
use App\Models\Quotation;

class QuotationAnswered extends BrandedMail
{
    public function __construct(private readonly Quotation $quotation)
    {
    }

    /**
     * @return array<string, mixed>
     */
    protected function content(object $notifiable): array
    {
        $priced = $this->quotation->status === QuotationTypesEnum::QUOTE_FINISHED;
        $key = 'admin.quotations.mail.'.($priced ? 'priced' : 'unavailable');

        return [
            'subject' => __($key.'.subject', ['destiny' => $this->destiny()]),
            'preheader' => __($key.'.preheader'),
            'eyebrow' => __('admin.quotations.mail.eyebrow'),
            'heading' => __($key.'.heading', ['name' => $this->firstName()]),
            'paragraphs' => [
                __($key.'.intro', ['destiny' => $this->destiny()]),
                __($key.'.instruction'),
            ],
            'details' => $this->details($priced),
            'action' => [
                'label' => __($key.'.action'),
                'url' => route($priced ? 'contact' : 'landing'),
            ],
            'footnote' => __('admin.quotations.mail.footnote'),
        ];
    }

    /**
     * @return array<int, array{label: string, value: string, strong?: bool}>
     */
    private function details(bool $priced): array
    {
        $details = [
            ['label' => __('admin.quotations.columns.destiny'), 'value' => $this->destiny()],
            ['label' => __('admin.quotations.columns.trip_date'), 'value' => $this->quotation->formattedTripDate()],
        ];

        if ($priced) {
            $details[] = [
                'label' => __('admin.quotations.mail.priced.price'),
                'value' => $this->quotation->formattedPrice(),
                'strong' => true,
            ];
        }

        return $details;
    }

    private function destiny(): string
    {
        return $this->quotation->destiny?->name ?? __('admin.quotations.no_destiny');
    }

    private function firstName(): string
    {
        return explode(' ', trim($this->quotation->user_name))[0];
    }
}

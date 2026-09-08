<?php

namespace App\Http\Controllers\Admin;

use App\Data\Admin\QuotationFilters;
use App\Enums\QuotationTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnswerQuotationRequest;
use App\Models\Destiny;
use App\Models\Quotation;
use App\Notifications\QuotationAnswered;
use App\Services\Admin\QuotationRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class QuotationController extends Controller
{
    public function index(Request $request, QuotationRepository $quotations): View
    {
        $filters = QuotationFilters::fromRequest($request);
        $results = $quotations->paginate($filters);

        if ($request->header('X-Partial') === 'table') {
            return view('admin.partials.quotations-results', ['quotations' => $results]);
        }

        return view('admin.quotations', [
            'quotations' => $results,
            'filters' => $filters,
            'statusOptions' => $this->statusOptions(),
            'statusSelected' => $filters->status
                ? ['value' => (string) $filters->status->value, 'label' => $filters->status->label()]
                : null,
            'destinySelected' => $this->selectedDestiny($filters->destiny),
            'action' => route('admin.quotations.index'),
            'destiniesEndpoint' => route('destinies.index'),
            'answerConfig' => $this->answerConfig(),
        ]);
    }

    public function answer(AnswerQuotationRequest $request, Quotation $quotation): RedirectResponse
    {
        $quotation->update([
            'status' => $request->status(),
            'price' => $request->price(),
            'answered_at' => now(),
        ]);

        Notification::route('mail', $quotation->user_email)
            ->notify(new QuotationAnswered($quotation->fresh()));

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('admin.quotations.answer.saved'),
        ]);
    }

    /**
     * @return array{value: string, label: string, note: string}|null
     */
    private function selectedDestiny(?string $uuid): ?array
    {
        $destiny = $uuid ? Destiny::find($uuid) : null;

        return $destiny ? [
            'value' => $destiny->uuid,
            'label' => $destiny->name,
            'note' => $destiny->country,
        ] : null;
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    private function statusOptions(): array
    {
        return array_map(
            fn (QuotationTypesEnum $status) => [
                'value' => (string) $status->value,
                'label' => $status->label(),
            ],
            QuotationTypesEnum::options(),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function answerConfig(): array
    {
        $placeholder = '__QUOTATION__';

        return [
            'endpoint' => route('admin.quotations.answer', $placeholder),
            'placeholder' => $placeholder,
            'options' => [
                [
                    'value' => AnswerQuotationRequest::UNAVAILABLE,
                    'label' => __('admin.quotations.answer.unavailable.label'),
                    'hint' => __('admin.quotations.answer.unavailable.hint'),
                ],
                [
                    'value' => AnswerQuotationRequest::PRICED,
                    'label' => __('admin.quotations.answer.priced.label'),
                    'hint' => __('admin.quotations.answer.priced.hint'),
                ],
            ],
        ];
    }
}

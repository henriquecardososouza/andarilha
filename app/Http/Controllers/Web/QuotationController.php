<?php

namespace App\Http\Controllers\Web;

use App\Enums\QuotationTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuotationRequest;
use App\Models\Quotation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class QuotationController extends Controller
{
    public function store(StoreQuotationRequest $request): RedirectResponse|JsonResponse
    {
        Quotation::firstOrCreate(
            [
                'user_email' => $request->validated('email'),
                'destiny_uuid' => $request->validated('destiny_uuid'),
                'trip_date' => $request->date('trip_date')->toDateString(),
            ],
            [
                'user_name' => $request->validated('name'),
                'status' => QuotationTypesEnum::PENDING,
            ],
        );

        $message = __('landing.contact.feedback.success');

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()
            ->to(route('landing').'#contato')
            ->with('toast', ['type' => 'success', 'message' => $message]);
    }
}

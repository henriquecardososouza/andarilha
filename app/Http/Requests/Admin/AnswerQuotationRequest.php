<?php

namespace App\Http\Requests\Admin;

use App\Enums\QuotationTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnswerQuotationRequest extends FormRequest
{
    public const UNAVAILABLE = 'unavailable';

    public const PRICED = 'priced';

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'answer' => ['required', Rule::in([self::UNAVAILABLE, self::PRICED])],
            'price' => ['nullable', 'required_if:answer,'.self::PRICED, 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'answer' => __('admin.quotations.answer.label'),
            'price' => __('admin.quotations.answer.price'),
        ];
    }

    public function status(): QuotationTypesEnum
    {
        return $this->validated('answer') === self::PRICED
            ? QuotationTypesEnum::QUOTE_FINISHED
            : QuotationTypesEnum::NOT_AVAILABLE;
    }

    public function price(): ?string
    {
        return $this->validated('answer') === self::PRICED
            ? (string) $this->validated('price')
            : null;
    }
}

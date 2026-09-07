<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuotationRequest extends FormRequest
{
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
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email:rfc', 'max:150'],
            'destiny_uuid' => [
                'required',
                'uuid',
                Rule::exists('destinies', 'uuid')->where('active', true),
            ],
            'trip_date' => ['required', 'date', 'after:today'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'trip_date.after' => __('landing.contact.form.date_after'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('landing.contact.form.name'),
            'email' => __('landing.contact.form.email'),
            'destiny_uuid' => __('landing.contact.form.destination'),
            'trip_date' => __('landing.contact.form.date'),
        ];
    }
}

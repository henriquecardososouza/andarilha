<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DestinyRequest extends FormRequest
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
            'country' => ['required', 'string', 'max:60'],
            'postal_code' => ['nullable', 'string', 'max:50'],
            'active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('admin.destinies.form.name'),
            'country' => __('admin.destinies.form.country'),
            'postal_code' => __('admin.destinies.form.postal_code'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function payload(): array
    {
        return [
            'name' => $this->validated('name'),
            'country' => $this->validated('country'),
            'postal_code' => $this->validated('postal_code'),
            'active' => $this->boolean('active'),
        ];
    }
}

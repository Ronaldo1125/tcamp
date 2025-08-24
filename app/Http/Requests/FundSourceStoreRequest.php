<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FundSourceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fund_source_name' => ['required', Rule::unique('fund_sources', 'fund_source_name')->ignore($this->route('fund_source'))],
            'fund_source_acronym' => ['required', 'max:20', Rule::unique('fund_sources', 'fund_source_acronym')->ignore($this->route('fund_source'))],
        ];
    }
}

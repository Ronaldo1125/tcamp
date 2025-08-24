<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DivisionStoreRequest extends FormRequest
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
            'division_name' => ['required', Rule::unique('divisions', 'division_name')->ignore($this->route('division'))],
            'division_acronym' => ['required', 'max:20', Rule::unique('divisions', 'division_acronym')->ignore($this->route('division'))],
            
        ];
    }
}

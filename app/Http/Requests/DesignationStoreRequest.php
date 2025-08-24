<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DesignationStoreRequest extends FormRequest
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
            'designation_name' => ['required', 'max:100', Rule::unique('designations', 'designation_name')->ignore($this->route('designation'))],
            'designation_acronym' => ['required', 'max:20', Rule::unique('designations', 'designation_acronym')->ignore($this->route('designation'))],
        ];
    }
}

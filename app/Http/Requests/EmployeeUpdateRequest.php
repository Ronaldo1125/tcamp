<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'last_name' => ['required', 'min:2' ,'max:100', Rule::unique('employees', 'last_name')->ignore($this->route('employee'))],
            'first_name' => ['required', 'min:2', 'max:100', Rule::unique('employees', 'first_name')->ignore($this->route('employee'))],
            // 'user_id' => [Rule::when(request()->isMethod('POST'), 'required'), Rule::when(request()->isMethod('PUT'), 'sometimes')],
            'user_id' => ['sometimes'],
            'division_id' => ['required'],
            'designation_id' => ['required'],
            'esignature_filename' => ['required','mimes:jpeg,png,jpg', 'max:1024'],
        ];
    }
}

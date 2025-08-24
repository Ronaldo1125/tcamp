<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => ['required', Rule::unique('users', 'name')->ignore($this->route('user'))],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'password' => ['required', 'min:8', 'max:30', 'same:confirm-password'],
            'role_id' => ['required'],
            'division_id' => ['required'],
            'designation_id' => ['required'],
            'created_by_id' => 'required',
        ];
    }
}

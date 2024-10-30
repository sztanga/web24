<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email',
            'phone_number' => 'nullable|string|max:20',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    /**
     * Validation error messages
     *
     * @return string[]
     */
    public function messages()
    {
        return [
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
            'email.required' => 'The email is required.',
            'email.unique' => 'The provided email is already in use. Please choose a different one.',
            'email.email' => 'The provided email not valid.',
            'company_id.required' => 'The company ID is required.',
            'company_id.exists' => 'The selected company ID is invalid.',
        ];
    }
}

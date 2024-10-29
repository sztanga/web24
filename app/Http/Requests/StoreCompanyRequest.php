<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'NIP' => 'required|string|max:255|unique:companies,NIP',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
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
            'name.required' => 'The company name is required.',
            'NIP.required' => 'The NIP is required.',
            'NIP.unique' => 'The provided NIP is already in use. Please choose a different one.',
            'address.required' => 'The address is required.',
            'city.required' => 'The city is required.',
            'postal_code.required' => 'The postal code is required.',
        ];
    }
}

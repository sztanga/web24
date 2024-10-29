<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
        $companyId = $this->route('id');

        return [
            'name' => 'sometimes|required|string|max:255',
            'NIP' => "sometimes|required|string|max:255|unique:companies,NIP,{$companyId}",
            'address' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'postal_code' => 'sometimes|required|string|max:10',
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

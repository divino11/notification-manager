<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u|min:2|max:32',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u|min:2|max:32',
            'email' => 'required|string|email|max:255|unique:clients',
            'phone_number' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
        ];
    }
}

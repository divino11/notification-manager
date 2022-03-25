<?php

namespace App\Http\Requests\Client;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateRequest
 * @package App\Http\Requests\Client
 *
 * @OA\Schema(
 *     schema="UpdateRequest",
 *     @OA\Property(property="first_name", type="string"),
 *     @OA\Property(property="last_name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="phone_number", type="string"),
 *     required={"first_name", "last_name", "email", "phone_number"}
 * )
 */
class UpdateRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::exists(Client::class, 'email')],
            'phone_number' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
        ];
    }
}

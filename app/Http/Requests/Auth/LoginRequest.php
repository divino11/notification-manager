<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginRequest
 * @package App\Http\Requests\Auth
 *
 * @OA\Schema(
 *     schema="LoginRequest",
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="password", type="string"),
 *     required={"email", "password"}
 * )
 */
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email:rfc,dns',
            ],
            'password' => [
                'required',
                'string',
            ],
        ];
    }
}

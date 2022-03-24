<?php

namespace App\Http\Requests\Notification;

use App\Models\Client;
use App\Models\Notification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'client_id' => ['required', 'int', Rule::exists(Client::class, 'id')],
            'channel' => ['required', 'string', Rule::in([
                Notification::SMS,
                Notification::EMAIL
            ])],
            'content' => ['required', 'string', 'max:140']
        ];
    }
}

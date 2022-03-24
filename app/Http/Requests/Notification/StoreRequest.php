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
            'notifications' => 'required|array',
            'notifications.*.client_id' => ['required', 'int', Rule::exists(Client::class, 'id')],
            'notifications.*.channel' => ['required', 'string', Rule::in([
                Notification::SMS,
                Notification::EMAIL
            ])],
            'notifications.*.content' => ['required', 'string', 'max:140']
        ];
    }
}

<?php

namespace App\Http\Requests\Notification;

use App\Models\Client;
use App\Models\Notification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreRequest
 * @package App\Http\Requests\Client
 *
 * @OA\Schema(
 *     schema="StoreNotificationRequest",
 *     @OA\Property(property="notifications", type="array", @OA\Items(type="integer", example={{"client_id":"", "channel":"", "content":""}})),
 *     required={"notifications"}
 * )
 */
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

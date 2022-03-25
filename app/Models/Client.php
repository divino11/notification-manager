<?php

namespace App\Models;

use App\Notifications\Client\EmailNotification;
use App\Notifications\Client\SmsNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Request;

/**
 * Class Client
 * @package App\Models
 *
 * @OA\Schema(
 *     schema="ClientModel",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="first_name", type="string"),
 *     @OA\Property(property="last_name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="phone_number", type="string"),
 * )
 */
class Client extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
    ];

    /**
     * @return HasOne
     */
    public function notification(): HasOne
    {
        return $this->hasOne(Notification::class);
    }

    /**
     * @param Notification $notification
     * @return void
     */
    public function sendEmailNotification(Notification $notification)
    {
        $this->notify(new EmailNotification($notification));
    }

    /**
     * @param Notification $notification
     * @return void
     */
    public function sendSmsNotification(Notification $notification)
    {
        $this->notify(new SmsNotification($notification));
    }

    /**
     * Route notifications for the Vonage channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForVonage($notification): string
    {
        return $this->phone_number;
    }
}

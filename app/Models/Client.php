<?php

namespace App\Models;

use App\Notifications\Client\EmailNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Request;

class Client extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
    ];

    public function notification(): HasOne
    {
        return $this->hasOne(Notification::class);
    }

    public function sendEmailNotification(Notification $notification)
    {
        $this->notify(new EmailNotification($notification));
    }
}

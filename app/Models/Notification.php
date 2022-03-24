<?php

namespace App\Models;

use App\Notifications\Client\EmailNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory, Notifiable;

    const SMS = 'sms';
    const EMAIL = 'email';

    protected $fillable = [
        'client_id',
        'channel',
        'content',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}

<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Notification $notification
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->notification->channel === Notification::EMAIL) {
            $this->notification->client->sendEmailNotification($this->notification);
        } else if ($this->notification->channel === Notification::SMS) {
            $this->notification->client->sendSmsNotification($this->notification);
        }
    }
}

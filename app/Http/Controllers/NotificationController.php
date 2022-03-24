<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notification\IndexRequest;
use App\Http\Requests\Notification\StoreRequest;
use App\Jobs\ProcessNotification;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Builder;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return Notification
     */
    public function index(IndexRequest $request): Notification
    {
        $data = $request->validated();

        return Notification::when($data['client_id'], function (Builder $builder, int $client_id) {
            $builder->where('client_id', $client_id);
        })
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Notification
     */
    public function store(StoreRequest $request): Notification
    {
        $data = $request->validated();

        $notification = Notification::create([
            'client_id' => $data['client_id'],
            'channel' => $data['channel'],
            'content' => $data['content'],
        ]);

        if ($data['channel'] === Notification::EMAIL) {
            $this->dispatch(new ProcessNotification($notification));
            //$notification->client->sendEmailNotification($notification);
        } else if ($data['channel'] === Notification::SMS) {
            $notification->client->sendSmsNotification($notification);
        }

        return $notification;
    }

    /**
     * Display the specified resource.
     *
     * @param Notification $notification
     * @return Notification
     */
    public function show(Notification $notification): Notification
    {
        return $notification;
    }
}

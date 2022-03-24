<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notification\IndexRequest;
use App\Http\Requests\Notification\StoreRequest;
use App\Jobs\ProcessNotification;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        foreach ($data['notifications'] as $notification) {
            $notificationData = Notification::create([
                'client_id' => $notification['client_id'],
                'channel' => $notification['channel'],
                'content' => $notification['content'],
            ]);

            $this->dispatch(new ProcessNotification($notificationData));
        }

        return response()->json(['success' => true]);
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

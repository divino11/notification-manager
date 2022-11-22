<?php

namespace App\Repositories;

use App\Http\Requests\Notification\IndexRequest;
use App\Http\Requests\Notification\StoreRequest;
use App\Jobs\ProcessNotification;
use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationRepository implements NotificationRepositoryInterface
{

    public function allNotifications(IndexRequest $request): LengthAwarePaginator
    {
        $data = $request->validated();

        return Notification::when($data['client_id'], function (Builder $builder, int $client_id) {
            $builder->where('client_id', $client_id);
        })
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }

    public function saveNotification(StoreRequest $request): JsonResponse
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

    public function getNotification(Notification $notification): Notification
    {
        return $notification;
    }
}

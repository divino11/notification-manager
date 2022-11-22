<?php

namespace App\Repositories;

use App\Jobs\ProcessNotification;
use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function allNotifications(array $data): LengthAwarePaginator
    {
        try {
            return Notification::when($data['client_id'], function (Builder $builder, int $client_id) {
                $builder->where('client_id', $client_id);
            })
                ->orderBy('id', 'DESC')
                ->paginate(20);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    public function saveNotification(array $data): JsonResponse
    {
        DB::beginTransaction();

        try {
            foreach ($data['notifications'] as $notification) {
                $notificationData = Notification::create([
                    'client_id' => $notification['client_id'],
                    'channel' => $notification['channel'],
                    'content' => $notification['content'],
                ]);

                $this->dispatch(new ProcessNotification($notificationData));
            }

            DB::commit();

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    public function getNotification(Notification $notification): Notification
    {
        try {
            return $notification;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }
}

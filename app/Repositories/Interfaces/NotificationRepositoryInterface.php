<?php

namespace App\Repositories\Interfaces;

use App\Models\Notification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

interface NotificationRepositoryInterface
{
    public function allNotifications(array $data): LengthAwarePaginator;

    public function saveNotification(array $data): JsonResponse;

    public function getNotification(Notification $notification): Notification;
}

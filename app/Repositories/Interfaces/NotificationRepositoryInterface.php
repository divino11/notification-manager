<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Notification\IndexRequest;
use App\Models\Notification;
use App\Http\Requests\Notification\StoreRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

interface NotificationRepositoryInterface
{
    public function allNotifications(IndexRequest $request): LengthAwarePaginator;

    public function saveNotification(StoreRequest $request): JsonResponse;

    public function getNotification(Notification $notification): Notification;
}

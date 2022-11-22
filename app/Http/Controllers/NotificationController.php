<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notification\IndexRequest;
use App\Http\Requests\Notification\StoreRequest;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationController extends Controller
{
    public function __construct(
        public NotificationRepository $notificationRepository
    ) {}

    /**
     * Get list of notifications
     *
     * @param IndexRequest $request
     * @return LengthAwarePaginator
     *
     * @OA\Get(
     *     tags={"Private/Manage Notifications"},
     *     path="/notification",
     *     security={{"Bearer"={}}},
     *     description="Get list of notifications",
     *     @OA\Parameter(
     *         description="Search by client",
     *         in="query",
     *         name="client_id",
     *         required=false
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="List of notifications",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/NotificationModel")
     *         ),
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/422")
     * )
     */
    public function index(IndexRequest $request): LengthAwarePaginator
    {
        return $this->notificationRepository->allNotifications($request);
    }

    /**
     * Create a new notification
     *
     * @param StoreRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     tags={"Private/Manage Notifications"},
     *     path="/notification",
     *     security={{"Bearer"={}}},
     *     description="Create a new notification",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreNotificationRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful notification creation",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *         ),
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/422")
     * )
     */
    public function store(StoreRequest $request): JsonResponse
    {
        return $this->notificationRepository->saveNotification($request);
    }

    /**
     * Get notification by ID
     *
     * @param Notification $notification
     * @return Notification
     *
     * @OA\Get(
     *     tags={"Private/Manage Notifications"},
     *     path="/notification/{notification}",
     *     security={{"Bearer"={}}},
     *     description="Get notification by ID",
     *     @OA\Parameter(
     *         description="ID of notification",
     *         in="path",
     *         name="notification_id",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Notification",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/NotificationModel")
     *         ),
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/422")
     * )
     */
    public function show(Notification $notification): Notification
    {
        return $this->notificationRepository->getNotification($notification);
    }
}

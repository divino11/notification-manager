<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notification\IndexRequest;
use App\Http\Requests\Notification\StoreRequest;
use App\Jobs\ProcessNotification;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationController extends Controller
{
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
        $data = $request->validated();

        return Notification::when($data['client_id'], function (Builder $builder, int $client_id) {
            $builder->where('client_id', $client_id);
        })
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }

    /**
     * Create a new client
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
        return $notification;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientController extends Controller
{
    /**
     * Get list of clients
     *
     * @return LengthAwarePaginator
     *
     * @OA\Get(
     *     tags={"Private/Manage Clients"},
     *     path="/client",
     *     security={{"Bearer"={}}},
     *     description="Get list of clients",
     *     @OA\Response(
     *          response=200,
     *          description="List of clients",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ClientModel")
     *         ),
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/422")
     * )
     */
    public function index(): LengthAwarePaginator
    {
        return Client::orderBy('id', 'DESC')->paginate(20);
    }

    /**
     * Create a new client
     *
     * @param StoreRequest $request
     * @return Client
     *
     * @OA\Post(
     *     tags={"Public/Manage Clients"},
     *     path="/client",
     *     description="Create a new client",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful client creation",
     *          @OA\JsonContent(ref="#/components/schemas/ClientModel")
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/422")
     * )
     */
    public function store(StoreRequest $request): Client
    {
        $data = $request->validated();

        return Client::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
        ]);
    }

    /**
     * Get client by ID
     *
     * @param Client $client
     * @return Client
     *
     * @OA\Get(
     *     tags={"Private/Manage Clients"},
     *     path="/client/{client}",
     *     security={{"Bearer"={}}},
     *     description="Get client by ID",
     *     @OA\Parameter(
     *         description="ID of client",
     *         in="path",
     *         name="client_id",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Client",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ClientModel")
     *         ),
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/422")
     * )
     */
    public function show(Client $client): Client
    {
        return $client;
    }

    /**
     * Update client by ID
     *
     * @param Client $client
     * @param UpdateRequest $request
     * @return Client
     *
     * @OA\Put(
     *     tags={"Public/Manage Clients"},
     *     path="/client/{client}",
     *     description="Update client by ID",
     *     @OA\Parameter(
     *         description="ID of client",
     *         in="path",
     *         name="client_id",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer"
     *         )
     *     ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateRequest")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful client update",
     *          @OA\JsonContent(ref="#/components/schemas/ClientModel")
     *     ),
     *     @OA\Response(response=422, ref="#/components/responses/422")
     * )
     */
    public function update(Client $client, UpdateRequest $request): Client
    {
        $data = $request->validated();

        $client->fill($data);

        $client->save();

        return $client;
    }

    /**
     * Delete client by ID
     *
     * @param Client $client
     * @return JsonResponse
     *
     * @OA\Delete(
     *     tags={"Public/Manage Clients"},
     *     path="/client/{client}",
     *     description="Delete client by ID",
     *     @OA\Parameter(
     *         description="ID of client",
     *         in="path",
     *         name="client_id",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Client deleted",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *         ),
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Client not found",
     *          @OA\JsonContent()
     *     )
     * )
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json(['success' => true]);
    }
}

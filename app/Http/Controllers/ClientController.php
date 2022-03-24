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
     * Display a listing of the resource.
     *
     * @return Client
     */
    public function index(): LengthAwarePaginator
    {
        return Client::orderBy('id', 'DESC')->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return Client
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
     * Display the specified resource.
     *
     * @param Client $client
     * @return Client
     */
    public function show(Client $client): Client
    {
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Client $client
     * @param UpdateRequest $request
     * @return Client
     */
    public function update(Client $client, UpdateRequest $request): Client
    {
        $data = $request->validated();

        $client->fill($data);

        $client->save();

        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return JsonResponse
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json(['success' => true]);
    }
}

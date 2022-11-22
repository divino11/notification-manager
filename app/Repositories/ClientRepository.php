<?php

namespace App\Repositories;

use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientRepository implements ClientRepositoryInterface
{

    public function allClients(): LengthAwarePaginator
    {
        return Client::orderByDesc('id')->paginate(20);
    }

    public function saveClient(StoreRequest $request): Client
    {
        $data = $request->validated();

        return Client::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
        ]);
    }

    public function getClient(Client $client): Client
    {
        return $client;
    }

    public function updateClient(Client $client, UpdateRequest $request): Client
    {
        $data = $request->validated();

        $client->fill($data);

        $client->save();

        return $client;
    }

    public function deleteClient(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json(['success' => true]);
    }
}

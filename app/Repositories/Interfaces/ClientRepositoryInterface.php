<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

interface ClientRepositoryInterface
{
    public function allClients(): LengthAwarePaginator;

    public function saveClient(StoreRequest $request): Client;

    public function getClient(Client $client): Client;

    public function updateClient(Client $client, UpdateRequest $request): Client;

    public function deleteClient(Client $client): JsonResponse;
}

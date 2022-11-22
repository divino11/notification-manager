<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

interface ClientRepositoryInterface
{
    public function allClients(): LengthAwarePaginator;

    public function saveClient(array $data): Client;

    public function getClient(Client $client): Client;

    public function updateClient(Client $client, array $data): Client;

    public function deleteClient(Client $client): JsonResponse;
}

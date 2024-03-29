<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class ClientRepository implements ClientRepositoryInterface
{
    public function allClients(): LengthAwarePaginator
    {
        try {
            return Client::orderByDesc('id')->paginate(20);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    public function saveClient(array $data): Client
    {
        DB::beginTransaction();

        try {
            $client = Client::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
            ]);

            DB::commit();

            return $client;
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    public function getClient(Client $client): Client
    {
        try {
            return $client;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    public function updateClient(Client $client, array $data): Client
    {
        DB::beginTransaction();

        try {
            $client->fill($data);

            $client->save();

            DB::commit();

            return $client;
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }

    public function deleteClient(Client $client): JsonResponse
    {
        DB::beginTransaction();

        try {
            $client->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }
}

<?php

namespace App\Services;

use App\Interface\IRepositoryClient;
use Illuminate\Support\Facades\DB;


class ClientService
{
    protected $repositoryClient;

    public function __construct(IRepositoryClient $repositoryClient)
    {
        $this->repositoryClient = $repositoryClient;
    }

    public function getAllClients()
    {
        try {
            $clients = $this->repositoryClient->findAll();

            if (count($clients) == 0) {
                return response()->json(['message' => 'No clients found'], 204);
            }
            return response()->json($clients);
        }
        catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function create($data)
    {
        DB::beginTransaction();

        try {
            if ($this->repositoryClient->existsClientByEmail($data['email'])) {
                throw new \Exception('Client already exists',400);
            }

            $client = $this->repositoryClient->create($data);

            DB::commit();

            return $client;

        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 400) {
                return response()->json(['message' => $e->getMessage()], $e->getCode());
            }
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $client = $this->repositoryClient->findById($id);
            if($client == null) {
                return response()->json(['message' => 'Client not found'], 204);
            }
            return response()->json($client);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function update($id, $data)
    {
        DB::beginTransaction();

        try {
            $client = $this->repositoryClient->findById($id);
            if ($client == null) {
                return response()->json(['message' => 'Client not found'], 404);
            }

            $client = $this->repositoryClient->update($id, $data);

            DB::commit();

            return $client;

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $client = $this->repositoryClient->findById($id);
            if ($client == null) {
                return response()->json(['message' => 'Client not found'], 404);
            }

            $this->repositoryClient->destroy($id);

            DB::commit();

            return response()->json(['message' => 'Client deleted'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}

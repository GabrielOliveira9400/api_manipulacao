<?php

namespace App\Repository;

use App\Interface\IRepositoryClient;
use App\Models\Client;


class RepositoryClient implements IRepositoryClient
{
    public function __construct()
    {
         $this->client = new Client();
    }

    public function findAll()
    {
        return $this->client->all();
    }

    public function create($data)
    {
        return $this->client->create($data);
    }

    public function findById($id)
    {
        return $this->client->find($id);
    }

    public function update($id, $data)
    {
        return $this->client->find($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->client->find($id)->delete();
    }

    public function existsClientByEmail($email)
    {
        return $this->client->where('email', $email)->exists();
    }
}

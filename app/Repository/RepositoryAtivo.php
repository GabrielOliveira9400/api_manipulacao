<?php

namespace App\Repository;

use App\Interface\IRepositoryAtivo;
use App\Models\Ativo;


class RepositoryAtivo implements IRepositoryAtivo
{
    public function __construct()
    {
         $this->Ativo = new Ativo();
    }

    public function findAll()
    {
        return $this->Ativo->all();
    }

    public function create($data)
    {
        return $this->Ativo->create($data);
    }

    public function findById($id)
    {
        return $this->Ativo->find($id);
    }

    public function update($id, $data)
    {
        return $this->Ativo->find($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->Ativo->find($id)->delete();
    }

    public function findByIds($ids)
    {
        return $this->Ativo->whereIn('id', $ids)->get();
    }
}

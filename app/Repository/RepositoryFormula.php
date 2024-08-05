<?php

namespace App\Repository;

use App\Interface\IRepositoryFormula;
use App\Models\Formula;


class RepositoryFormula implements IRepositoryFormula
{
    public function __construct()
    {
        $this->formula = new Formula();
    }

    public function findAll()
    {
        return $this->formula->all();
    }

    public function create($data)
    {
        return $this->formula->create($data);
    }

    public function findById($id)
    {
        return $this->formula->find($id);
    }

    public function update($id, $data)
    {
        return $this->formula->find($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->formula->find($id)->delete();
    }


}

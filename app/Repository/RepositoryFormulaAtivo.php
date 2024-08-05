<?php

namespace App\Repository;

use App\Interface\IRepositoryFormulaAtivo;
use App\Models\FormulaAtivo;

class RepositoryFormulaAtivo implements IRepositoryFormulaAtivo
{
    public function __construct()
    {
         $this->FormulaAtivo = new FormulaAtivo();
    }

    public function findByFormulaId($idFormula)
    {
        return $this->FormulaAtivo->where('formula_id', $idFormula)->get();
    }

    public function create($data)
    {
        return $this->FormulaAtivo->create($data);
    }

}

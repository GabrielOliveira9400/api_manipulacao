<?php

namespace App\Interface;

interface IRepositoryFormulaAtivo
{
    public function findByFormulaId($idFormula);
    public function create($data);
}

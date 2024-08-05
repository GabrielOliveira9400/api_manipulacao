<?php

namespace App\Interface;

interface IRepositoryFormula
{
    public function findAll();
    public function create($data);
    public function findById($id);
    public function update($id, $data);
    public function destroy($id);
}

<?php

namespace App\Interface;

interface IRepositoryClient
{
    public function findAll();
    public function create($data);
    public function findById($id);
    public function update($id, $data);
    public function destroy($id);
}

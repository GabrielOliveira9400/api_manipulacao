<?php

namespace App\Services;

use App\Interface\IRepositoryAtivo;
use Illuminate\Support\Facades\DB;


class AtivoService
{
    protected $repositoryAtivo;

    public function __construct(IRepositoryAtivo $repositoryAtivo)
    {
        $this->repositoryAtivo = $repositoryAtivo;
    }

    public function getAllAtivos()
    {
        try {
            $Ativos = $this->repositoryAtivo->findAll();

            if (count($Ativos) == 0) {
                return response()->json(['message' => 'No Ativos found'], 204);
            }
            return response()->json($Ativos);
        }
        catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function create($data)
    {
        DB::beginTransaction();

        try {
            $Ativo = $this->repositoryAtivo->create($data);

            DB::commit();

            return $Ativo;

        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 400) {
                return response()->json(['message' => $e->getMessage()], $e->getCode());
            }
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getAtivoById($id)
    {
        try {
            $Ativo = $this->repositoryAtivo->findById($id);
            if($Ativo == null) {
                return response()->json(['message' => 'Ativo not found'], 204);
            }
            return response()->json($Ativo);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function update($id, $data)
    {
        DB::beginTransaction();

        try {
            $Ativo = $this->repositoryAtivo->findById($id);
            if ($Ativo == null) {
                return response()->json(['message' => 'Ativo not found'], 404);
            }

            $Ativo = $this->repositoryAtivo->update($id, $data);

            DB::commit();

            return $Ativo;

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $Ativo = $this->repositoryAtivo->findById($id);
            if ($Ativo == null) {
                return response()->json(['message' => 'Ativo not found'], 404);
            }

            $this->repositoryAtivo->destroy($id);

            DB::commit();

            return response()->json(['message' => 'Ativo deleted'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}

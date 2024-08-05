<?php

namespace App\Services;

use App\Interface\IRepositoryAtivo;
use App\Interface\IRepositoryClient;
use App\Interface\IRepositoryFormula;
use App\Interface\IRepositoryFormulaAtivo;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;


class FormulaService
{
    protected $repositoryFormula;
    protected $repositoryAtivo;
    protected $repositoryFormulaAtivo;
    protected $repositoryClient;


    public function __construct(IRepositoryFormula $repositoryFormula, IRepositoryAtivo $repositoryAtivo,
    IRepositoryFormulaAtivo $repositoryFormulaAtivo, IRepositoryClient $repositoryClient)
    {
        $this->repositoryFormula = $repositoryFormula;
        $this->repositoryAtivo = $repositoryAtivo;
        $this->repositoryFormulaAtivo = $repositoryFormulaAtivo;
        $this->repositoryClient = $repositoryClient;
    }

    public function getAllFormulas()
    {
        try {
            $Formulas = $this->repositoryFormula->findAll();

            if (count($Formulas) == 0) {
                return response()->json(['message' => 'No Formulas found'], 204);
            }
            return response()->json($Formulas);
        }
        catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function CreateFormulaWithAtivos($data)
    {
        DB::beginTransaction();
        try {
            foreach ($data as $formulaData) {

                $client = $this->repositoryClient->findById($formulaData['cliente_id']);
                if (!$client) {
                    return response()->json(['message' => "Client with ID {$formulaData['cliente_id']} not found"], 404);
                }

                $ativosIds = array_column($formulaData['ativos'], 'id');

                $existsAtivos = $this->repositoryAtivo->findByIds($ativosIds);

                if (count($ativosIds) !== count($existsAtivos)) {
                    return response()->json(['message' => 'Some assets not found'], 404);
                }

                $formula = $this->repositoryFormula->create($formulaData);

                foreach ($formulaData['ativos'] as $ativo) {

                    $this->repositoryFormulaAtivo->create([
                        'formula_id' => $formula->id,
                        'ativo_id' => $ativo['id'],
                        'percentual' => $ativo['percentual']
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Formula created'], 201);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $Formula = $this->repositoryFormula->findById($id);

            if($Formula == null) {
                return response()->json(['message' => 'Formula not found'], 204);
            }

            $Ativos = $this->repositoryFormulaAtivo->findByFormulaId($id);

            $Formula->ativos = $Ativos;

            return $Formula;
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function update($id, $data)
    {
        DB::beginTransaction();

        try {
            $Formula = $this->repositoryFormula->findById($id);
            if ($Formula == null) {
                return response()->json(['message' => 'Formula not found'], 404);
            }

            $Formula = $this->repositoryFormula->update($id, $data);

            DB::commit();

            return $Formula;

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $Formula = $this->repositoryFormula->findById($id);
            if ($Formula == null) {
                return response()->json(['message' => 'Formula not found'], 404);
            }

            $this->repositoryFormula->destroy($id);

            DB::commit();

            return response()->json(['message' => 'Formula deleted'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}

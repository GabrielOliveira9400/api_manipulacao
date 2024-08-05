<?php

namespace App\Http\Api\Controllers;

use App\Models\Ativo;
use App\Models\FormulaAtivo;
use App\Services\FormulaService;
use Illuminate\Routing\Controller;
use App\Models\Formula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Client;


/**
 * @OA\Tag(
 *     name="formulas",
 *     description="Operations about formulas"
 * )
 */


class FormulaController extends Controller
{
    private $FormulaService;

    public function __construct(FormulaService $FormulaService)
    {
        $this->FormulaService = $FormulaService;
    }
    /**
     * @OA\Get(
     *     path="/formulas",
     *     tags={"formulas"},
     *     summary="Get all formulas",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   ),
     *     @OA\Response(
     *     response=404,
     *     description="No formulas found"
     *  ),
     *     )
     * )
     *
     */
    public function index()
    {
        try {
            return $this->FormulaService->getAllFormulas();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/formulas/{id}",
     *     tags={"formulas"},
     *     summary="Get formula by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of formula",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   ),
     *     @OA\Response(
     *     response=404,
     *     description="Formula not found"
     *  ),
     *     )
     * )
     *
     */
    public function show($id)
    {
        try {
            return $this->FormulaService->show($id);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/formulas/{id}",
     *     tags={"formulas"},
     *     summary="Update formula by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of formula",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   ),
     *     @OA\Response(
     *     response=404,
     *     description="Formula not found"
     *  ),
     *     )
     * )
     *
     */
    public function update(Request $request, $id)
    {
        $formulaData = $request->all();

        $validator = Validator::make($formulaData, [
            'nome' => 'required',
            'descricao' => 'required',
            'cliente_id' => 'required',
            'ativos' => 'required|array',
            'ativos.*.id' => 'required|integer',
            'ativos.*.percentual' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            return $this->FormulaService->update($id, $request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/formulas/{id}",
     *     tags={"formulas"},
     *     summary="Delete formula by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of formula",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   ),
     *     @OA\Response(
     *     response=404,
     *     description="Formula not found"
     *  ),
     *     )
     * )
     *
     */
    public function destroy($id)
    {
        try {
            return $this->FormulaService->destroy($id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $formulas = $request->all();

        if (empty($formulas)) {
            return response()->json(['message' => 'No formulas found'], 404);
        }

        foreach ($formulas as $formulaData) {
            $validator = Validator::make($formulaData, [
                'nome' => 'required',
                'descricao' => 'required',
                'cliente_id' => 'required',
                'ativos' => 'required|array',
                'ativos.*.id' => 'required|integer',
                'ativos.*.percentual' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
        }
        try {
            return $this->FormulaService->CreateFormulaWithAtivos($request->all());
        }catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

}

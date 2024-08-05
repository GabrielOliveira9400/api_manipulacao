<?php

namespace App\Http\Api\Controllers;

use App\Services\AtivoService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Ativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Ativos",
 *     description="Operations about assets"
 * )
 */

/**
 * @OA\Info(
 *     title="Ativos API",
 *     version="1.0.0",
 *     description="Operations about assets"
 * )
 */

class AtivoController extends Controller
{
    private AtivoService $AtivoService;

    public function __construct(AtivoService $AtivoService)
    {
        $this->AtivoService = $AtivoService;
    }

    /**
     * @OA\Get(
     *     path="/ativos",
     *     tags={"assets"},
     *     summary="Get all assets",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   ),
     *     @OA\Response(
     *     response=204,
     *     description="No assets found"
     *  ),
     * )
     * )
     *
     */
    public function index()
    {
        try {
            return $this->AtivoService->getAllAtivos();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/ativos",
     *     tags={"assets"},
     *     summary="Create asset",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "concentracao_maxima", "descricao"},
     *             @OA\Property(property="nome", type="string", example=""),
     *             @OA\Property(property="descricao", type="string", example=""),
     *             @OA\Property(property="concentracao_maxima", type="number", example="100"),
     *             @OA\Property(property="observacoes", type="string", example=""),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *         ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   ),
     *     @OA\Response(
     *     response=400,
     *     description="Bad Request"
     *  ),
     *     )
     * )
     *
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'propriedades' => 'required',
            'concentracao_maxima' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try
        {
            return $this->AtivoService->create($request->all());
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/ativos/{id}",
     *     tags={"assets"},
     *     summary="Get asset by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Asset id",
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
     *     description="Asset not found"
     *  ),
     *     )
     * )
     *
     */
    public function show($id)
    {
        try {
            return $this->AtivoService->getAtivoById($id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'propriedades' => 'required',
            'concentracao_maxima' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            return $this->AtivoService->update($id, $request->all());
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/ativos/{id}",
     *     tags={"assets"},
     *     summary="Delete asset by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Asset id",
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
     *     description="Asset not found"
     *  ),
     *     )
     * )
     *
     */
    public function destroy($id)
    {
        try {
            return $this->AtivoService->destroy($id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

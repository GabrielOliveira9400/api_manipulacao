<?php

namespace App\Http\Api\Controllers;

use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



/**
 * @OA\Tag(
 *     name="clients",
 *     description="Operations about clients"
 * )
 */

class ClientController extends Controller
{

    private ClientService $ClientService;

    public function __construct(ClientService $ClientService)
    {
        $this->ClientService = $ClientService;
    }

    /**
     * @OA\Get(
     *     path="/clientes",
     *     tags={"clients"},
     *     summary="Get all clients",
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
     *     description="No clients found"
     *  ),
     *     )
     * )
     *
     */
    public function index()
    {

        Try{

            $clientes = $this->ClientService->getAllClients();
            return $clientes;
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/clientes",
     *     tags={"clients"},
     *     summary="Create a new client",
     *     @OA\RequestBody(
     *         required=true,
     *        @OA\JsonContent(
     *            required={"nome","email","telefone","CPF"},
     *       @OA\Property(property="nome", type="string", example="João da Silva"),
     *     @OA\Property(property="email", type="string", example="joao@teste.com.br"),
     *     @OA\Property(property="telefone", type="string", example="11999999999"),
     *     @OA\Property(property="CPF", type="string", example="12345678910")
     *        )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *     ),
     *     @OA\Response(
     *     response=400,
     *     description="Client already exists"
     * ),
     *     @OA\Response(
     *     response=401,
     *     description="Validation error"
     * ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal Server Error"
     * )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
            'CPF' => 'required|cpf'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            return $this->ClientService->create($request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/clientes/{id}",
     *     tags={"clients"},
     *     summary="Get client by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     ),
     *     @OA\Response(
     *     response=404,
     *     description="Client not found"
     * ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal Server Error"
     * ),
     * )
     */
    public function show($id)
    {
        try {
            return $this->ClientService->show($id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/clientes/{id}",
     *     tags={"clients"},
     *     summary="Update client by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     ),
     *     @OA\Response(
     *     response=404,
     *     description="Client not found"
     * ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal Server Error"
     * ),
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'email' => 'required|email',
            'telefone' => 'required',
            'CPF' => 'required|cpf'
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            return $this->ClientService->update($id, $request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/clientes/{id}",
     *     tags={"clients"},
     *     summary="Delete client by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     ),
     *     @OA\Response(
     *     response=404,
     *     description="Client not found"
     * ),
     *     @OA\Response(
     *     response=500,
     *     description="Internal Server Error"
     * )
     * )
     */
    public function destroy($id)
    {
        try {
            return $this->ClientService->destroy($id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

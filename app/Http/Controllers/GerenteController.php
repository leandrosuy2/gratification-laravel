<?php

namespace App\Http\Controllers;

use App\Models\Gerente;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Gerente",
 *     description="Operações relacionadas a gerentes"
 * )
 */
class GerenteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/gerentes",
     *     tags={"Gerente"},
     *     summary="Listar todos os gerentes",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de todos os gerentes",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="recordsTotal", type="integer", example=10),
     *             @OA\Property(property="recordsFiltered", type="integer", example=10),
     *             @OA\Property(property="total", type="integer", example=10),
     *             @OA\Property(
     *                 property="docs",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="id_usuario", type="string", example="123"),
     *                     @OA\Property(property="status", type="boolean", example=true),
     *                     @OA\Property(property="usuario", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="João Silva")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $gerentes = Gerente::with('usuario')->get();

        return response()->json([
            'success' => true,
            'recordsTotal' => $gerentes->count(),
            'recordsFiltered' => $gerentes->count(),
            'docs' => $gerentes,
            'total' => $gerentes->count(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/gerentes/{id}",
     *     tags={"Gerente"},
     *     summary="Exibir um gerente específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes de um gerente específico",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="docs", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="id_usuario", type="string", example="123"),
     *                 @OA\Property(property="status", type="boolean", example=true),
     *                 @OA\Property(property="usuario", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="João Silva")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $gerente = Gerente::with('usuario')->findOrFail($id);

        return response()->json([
            'success' => true,
            'docs' => $gerente,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/gerentes",
     *     tags={"Gerente"},
     *     summary="Criar um novo gerente",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id_usuario", type="string", example="123"),
     *             @OA\Property(property="status", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Gerente criado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Gerente criado com sucesso!"),
     *             @OA\Property(property="docs", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="id_usuario", type="string", example="123"),
     *                 @OA\Property(property="status", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'required|string|exists:usuarios,id',
            'status' => 'required|boolean',
        ]);

        $gerente = Gerente::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Gerente criado com sucesso!',
            'docs' => $gerente,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/gerentes/{id}",
     *     tags={"Gerente"},
     *     summary="Atualizar um gerente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id_usuario", type="string", example="123"),
     *             @OA\Property(property="status", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Gerente atualizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Gerente atualizado com sucesso!"),
     *             @OA\Property(property="docs", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="id_usuario", type="string", example="123"),
     *                 @OA\Property(property="status", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $gerente = Gerente::findOrFail($id);

        $validatedData = $request->validate([
            'id_usuario' => 'required|string|exists:usuarios,id',
            'status' => 'required|boolean',
        ]);

        $gerente->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Gerente atualizado com sucesso!',
            'docs' => $gerente,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/gerentes/{id}",
     *     tags={"Gerente"},
     *     summary="Excluir um gerente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Gerente excluído com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Gerente excluído com sucesso!")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $gerente = Gerente::findOrFail($id);
        $gerente->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gerente excluído com sucesso!',
        ]);
    }
}

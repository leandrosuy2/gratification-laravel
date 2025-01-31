<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Servico",
 *     description="Operações relacionadas a serviços"
 * )
 */
class ServicoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/servicos",
     *     tags={"Servico"},
     *     summary="Listar todos os serviços",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de todos os serviços",
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
     *                     @OA\Property(property="nome", type="string", example="Serviço de Limpeza"),
     *                     @OA\Property(property="tipo_servico", type="string", example="Limpeza"),
     *                     @OA\Property(property="hora_inicio", type="string", example="08:00:00"),
     *                     @OA\Property(property="hora_final", type="string", example="16:00:00"),
     *                     @OA\Property(property="status", type="integer", example=1),
     *                     @OA\Property(property="user_add", type="string", example="admin"),
     *                     @OA\Property(
     *                         property="empresa",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="nome", type="string", example="Empresa X")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        // Recuperando todos os serviços, incluindo a empresa associada
        $servicos = Servico::with('empresa')->get();

        return response()->json([
            'success' => true,
            'recordsTotal' => $servicos->count(),
            'recordsFiltered' => $servicos->count(),
            'docs' => $servicos,
            'total' => $servicos->count(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/servicos/{id}",
     *     tags={"Servico"},
     *     summary="Exibir serviço específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do serviço",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="docs", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Serviço de Limpeza"),
     *                 @OA\Property(property="tipo_servico", type="string", example="Limpeza"),
     *                 @OA\Property(property="hora_inicio", type="string", example="08:00:00"),
     *                 @OA\Property(property="hora_final", type="string", example="16:00:00"),
     *                 @OA\Property(property="status", type="integer", example=1),
     *                 @OA\Property(property="user_add", type="string", example="admin"),
     *                 @OA\Property(
     *                     property="empresa",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nome", type="string", example="Empresa X")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        // Recuperando um serviço específico pelo ID
        $servico = Servico::with('empresa')->findOrFail($id);

        return response()->json([
            'success' => true,
            'docs' => $servico,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/servicos",
     *     tags={"Servico"},
     *     summary="Criar um novo serviço",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id_empresa", type="string", example="1"),
     *             @OA\Property(property="tipo_servico", type="string", example="Limpeza"),
     *             @OA\Property(property="nome", type="string", example="Serviço de Limpeza"),
     *             @OA\Property(property="hora_inicio", type="string", example="08:00:00"),
     *             @OA\Property(property="hora_final", type="string", example="16:00:00"),
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="user_add", type="string", example="admin")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Serviço criado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Serviço criado com sucesso!"),
     *             @OA\Property(property="docs", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Serviço de Limpeza")
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Validando os dados recebidos
        $validatedData = $request->validate([
            'id_empresa' => 'required|string|exists:empresas,_id',
            'tipo_servico' => 'required|string|max:255',
            'nome' => 'required|string|max:255',
            'hora_inicio' => 'required|date_format:H:i:s',
            'hora_final' => 'required|date_format:H:i:s',
            'status' => 'required|integer|in:1,2',
            'user_add' => 'required|string',
        ]);

        // Criando o serviço
        $servico = Servico::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Serviço criado com sucesso!',
            'docs' => $servico,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/servicos/{id}",
     *     tags={"Servico"},
     *     summary="Atualizar um serviço existente",
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
     *             @OA\Property(property="id_empresa", type="string", example="1"),
     *             @OA\Property(property="tipo_servico", type="string", example="Limpeza"),
     *             @OA\Property(property="nome", type="string", example="Serviço de Limpeza"),
     *             @OA\Property(property="hora_inicio", type="string", example="08:00:00"),
     *             @OA\Property(property="hora_final", type="string", example="16:00:00"),
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="user_add", type="string", example="admin")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Serviço atualizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Serviço atualizado com sucesso!"),
     *             @OA\Property(property="docs", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Serviço de Limpeza")
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Recuperando o serviço pelo ID
        $servico = Servico::findOrFail($id);

        // Validando os dados recebidos
        $validatedData = $request->validate([
            'id_empresa' => 'required|string|exists:empresas,_id',
            'tipo_servico' => 'required|string|max:255',
            'nome' => 'required|string|max:255',
            'hora_inicio' => 'required|date_format:H:i:s',
            'hora_final' => 'required|date_format:H:i:s',
            'status' => 'required|integer|in:1,2',
            'user_add' => 'required|string',
        ]);

        // Atualizando o serviço
        $servico->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Serviço atualizado com sucesso!',
            'docs' => $servico,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/servicos/{id}",
     *     tags={"Servico"},
     *     summary="Excluir um serviço",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Serviço excluído com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Serviço excluído com sucesso!")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        // Encontrando e excluindo o serviço
        $servico = Servico::findOrFail($id);
        $servico->delete();

        return response()->json([
            'success' => true,
            'message' => 'Serviço excluído com sucesso!',
        ]);
    }
}

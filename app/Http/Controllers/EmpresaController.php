<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Empresa",
 *     description="Operações relacionadas a empresas"
 * )
 */
class EmpresaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/empresas",
     *     tags={"Empresa"},
     *     summary="Listar todas as empresas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de todas as empresas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="docs", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nome", type="string", example="Empresa X"),
     *                     @OA\Property(property="razao_social", type="string", example="Razão Social X"),
     *                     @OA\Property(property="status", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        Log::info('Listando todas as empresas.');

        $empresas = Empresa::with(['servicos', 'gerentes'])->get();

        Log::info('Empresas listadas com sucesso.', ['quantidade' => $empresas->count()]);

        return view('empresas.index', compact('empresas'));
    }

    /**
     * @OA\Get(
     *     path="/empresas/{id}",
     *     tags={"Empresa"},
     *     summary="Exibir uma empresa específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes de uma empresa específica",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="docs", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Empresa X"),
     *                 @OA\Property(property="razao_social", type="string", example="Razão Social X"),
     *                 @OA\Property(property="status", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        Log::info('Buscando detalhes da empresa.', ['empresa_id' => $id]);

        $empresa = Empresa::with(['servicos', 'gerentes'])->findOrFail($id);

        Log::info('Detalhes da empresa recuperados com sucesso.', ['empresa_id' => $id]);

        return view('empresas.show', compact('empresa'));
    }

    /**
     * @OA\Post(
     *     path="/empresas",
     *     tags={"Empresa"},
     *     summary="Criar uma nova empresa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="logo", type="string", example="logo.png"),
     *             @OA\Property(property="nome", type="string", example="Empresa X"),
     *             @OA\Property(property="razao_social", type="string", example="Razão Social X"),
     *             @OA\Property(property="email", type="string", example="empresa@x.com"),
     *             @OA\Property(property="telcom", type="string", example="123456789"),
     *             @OA\Property(property="telcel", type="string", example="987654321"),
     *             @OA\Property(property="cnpj", type="string", example="12.345.678/0001-90"),
     *             @OA\Property(property="status", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Empresa criada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Empresa criada com sucesso!"),
     *             @OA\Property(property="docs", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Empresa X"),
     *                 @OA\Property(property="razao_social", type="string", example="Razão Social X"),
     *                 @OA\Property(property="status", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        Log::info('Recebendo dados para criação de nova empresa.', ['dados' => $request->all()]);

        $validatedData = $request->validate([
            'logo' => 'nullable|string',
            'nome' => 'required|string|max:255',
            'razao_social' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telcom' => 'nullable|string',
            'telcel' => 'nullable|string',
            'cnpj' => 'nullable|string',
            'qt_funcionarios' => 'nullable|integer',
            'cep' => 'nullable|string',
            'rua' => 'nullable|string',
            'numero' => 'nullable|string',
            'complem' => 'nullable|string',
            'bairro' => 'nullable|string',
            'cidade' => 'nullable|string',
            'estado' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $empresa = Empresa::create($validatedData);

        Log::info('Empresa criada com sucesso.', ['empresa_id' => $empresa->id]);

        return response()->json([
            'success' => true,
            'message' => 'Empresa criada com sucesso!',
            'docs' => $empresa,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/empresas/{id}",
     *     tags={"Empresa"},
     *     summary="Atualizar uma empresa",
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
     *             @OA\Property(property="logo", type="string", example="logo_updated.png"),
     *             @OA\Property(property="nome", type="string", example="Empresa Y"),
     *             @OA\Property(property="razao_social", type="string", example="Razão Social Y"),
     *             @OA\Property(property="email", type="string", example="empresa@y.com"),
     *             @OA\Property(property="status", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empresa atualizada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Empresa atualizada com sucesso!"),
     *             @OA\Property(property="docs", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Empresa X"),
     *                 @OA\Property(property="razao_social", type="string", example="Razão Social X"),
     *                 @OA\Property(property="status", type="boolean", example=true)
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        Log::info('Recebendo dados para atualização de empresa.', [
            'empresa_id' => $id,
            'dados' => $request->all(),
        ]);

        $empresa = Empresa::findOrFail($id);

        $validatedData = $request->validate([
            'logo' => 'nullable|string',
            'nome' => 'required|string|max:255',
            'razao_social' => 'required|string|max:255',
            'email' => 'nullable|email',
            'telcom' => 'nullable|string',
            'telcel' => 'nullable|string',
            'cnpj' => 'nullable|string',
            'qt_funcionarios' => 'nullable|integer',
            'cep' => 'nullable|string',
            'rua' => 'nullable|string',
            'numero' => 'nullable|string',
            'complem' => 'nullable|string',
            'bairro' => 'nullable|string',
            'cidade' => 'nullable|string',
            'estado' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $empresa->update($validatedData);

        Log::info('Empresa atualizada com sucesso.', ['empresa_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => 'Empresa atualizada com sucesso!',
            'docs' => $empresa,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/empresas/{id}",
     *     tags={"Empresa"},
     *     summary="Excluir uma empresa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empresa excluída com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Empresa excluída com sucesso!")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        Log::info('Solicitação para excluir empresa.', ['empresa_id' => $id]);

        $empresa = Empresa::findOrFail($id);
        $empresa->delete();

        Log::info('Empresa excluída com sucesso.', ['empresa_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => 'Empresa excluída com sucesso!',
        ]);
    }
}

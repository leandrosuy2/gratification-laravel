<?php

namespace App\Http\Controllers;

use App\Models\PerfilAcesso;

/**
 * @OA\Tag(
 *     name="PerfilAcesso",
 *     description="Operações relacionadas a perfis de acesso"
 * )
 */
class PerfilAcessoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/perfil_acessos",
     *     tags={"PerfilAcesso"},
     *     summary="Listar todos os perfis de acesso",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de todos os perfis de acesso",
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
     *                     @OA\Property(property="nome", type="string", example="Administrador"),
     *                     @OA\Property(property="descricao", type="string", example="Acesso total")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        // Buscar todos os perfis de acesso
        $perfis = PerfilAcesso::all();

        return response()->json([
            'success' => true,
            'recordsTotal' => $perfis->count(),
            'recordsFiltered' => $perfis->count(),
            'docs' => $perfis,
            'total' => $perfis->count(),
        ]);
    }
}

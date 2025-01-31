<?php

namespace App\Http\Controllers;

use App\Models\User;

/**
 * @OA\Tag(
 *     name="Usuario",
 *     description="Operações relacionadas a usuários"
 * )
 */
class UsuarioController extends Controller
{
    /**
     * @OA\Get(
     *     path="/usuarios",
     *     tags={"Usuario"},
     *     summary="Listar todos os usuários",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de todos os usuários",
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
     *                     @OA\Property(property="name", type="string", example="João Silva"),
     *                     @OA\Property(property="email", type="string", example="joao.silva@example.com"),
     *                     @OA\Property(property="perfil", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="nome", type="string", example="Administrador")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $usuarios = User::with('perfil')->get();

        return response()->json([
            'success' => true,
            'recordsTotal' => $usuarios->count(),
            'recordsFiltered' => $usuarios->count(),
            'docs' => $usuarios,
            'total' => $usuarios->count(),
        ]);
    }
}

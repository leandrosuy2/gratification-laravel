<?php

namespace App\Http\Controllers;

use App\Models\Voto;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Voto",
 *     description="Operações relacionadas a votos"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Voto",
 *     type="object",
 *     @OA\Property(property="data_registro", type="string", example="2025-01-31"),
 *     @OA\Property(property="id_empresa", type="integer", example=1),
 *     @OA\Property(property="id_gestor", type="integer", example=2),
 *     @OA\Property(property="qt_funcionarios", type="integer", example=100),
 *     @OA\Property(property="total_otimo", type="integer", example=50),
 *     @OA\Property(property="total_bom", type="integer", example=30),
 *     @OA\Property(property="total_regular", type="integer", example=10),
 *     @OA\Property(property="total_ruim", type="integer", example=10),
 *     @OA\Property(property="total", type="integer", example=100),
 *     @OA\Property(property="perc_otimo", type="number", format="float", example=50),
 *     @OA\Property(property="perc_bom", type="number", format="float", example=30),
 *     @OA\Property(property="perc_regular", type="number", format="float", example=10),
 *     @OA\Property(property="perc_ruim", type="number", format="float", example=10)
 * )
 */
class VotoController extends Controller
{
    /**
     * @OA\Post(
     *     path="/votar",
     *     tags={"Voto"},
     *     summary="Registrar ou atualizar um voto para a empresa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_empresa", "id_gestor", "qt_funcionarios", "total_otimo", "total_bom", "total_regular", "total_ruim"},
     *             @OA\Property(property="id_empresa", type="integer", example=1),
     *             @OA\Property(property="id_gestor", type="integer", example=2),
     *             @OA\Property(property="qt_funcionarios", type="integer", example=100),
     *             @OA\Property(property="total_otimo", type="integer", example=50),
     *             @OA\Property(property="total_bom", type="integer", example=30),
     *             @OA\Property(property="total_regular", type="integer", example=10),
     *             @OA\Property(property="total_ruim", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voto atualizado com sucesso!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Voto atualizado com sucesso!"),
     *             @OA\Property(property="data", ref="#/components/schemas/Voto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Voto registrado com sucesso!",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Voto registrado com sucesso!"),
     *             @OA\Property(property="data", ref="#/components/schemas/Voto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro na validação dos dados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Erro de validação")
     *         )
     *     )
     * )
     */
    public function votar(Request $request)
    {
        // Validação dos dados do voto
        $request->validate([
            'id_empresa' => 'required|exists:empresas,id', // A empresa deve existir no banco
            'id_gestor' => 'required|exists:gestores,id', // O gestor deve existir no banco
            'qt_funcionarios' => 'required|integer|min:1',
            'total_otimo' => 'required|integer|min:0',
            'total_bom' => 'required|integer|min:0',
            'total_regular' => 'required|integer|min:0',
            'total_ruim' => 'required|integer|min:0',
        ]);

        // Recuperar a data atual
        $dataAtual = Carbon::now()->format('Y-m-d'); // Formato de data YYYY-MM-DD

        // Procurar um voto existente para a data atual e a empresa
        $voto = Voto::where('data_registro', $dataAtual)
            ->where('id_empresa', $request->id_empresa)
            ->first();

        if ($voto) {
            // Atualiza o voto existente
            $voto->id_gestor = $request->id_gestor;
            $voto->qt_funcionarios = $request->qt_funcionarios;
            $voto->total_otimo = $request->total_otimo;
            $voto->total_bom = $request->total_bom;
            $voto->total_regular = $request->total_regular;
            $voto->total_ruim = $request->total_ruim;

            // Calcular o total de votos
            $voto->total = $voto->total_otimo + $voto->total_bom + $voto->total_regular + $voto->total_ruim;

            // Calcular a porcentagem de votos
            if ($voto->total > 0) {
                $voto->perc_otimo = round(($voto->total_otimo / $voto->total) * 100, 2);
                $voto->perc_bom = round(($voto->total_bom / $voto->total) * 100, 2);
                $voto->perc_regular = round(($voto->total_regular / $voto->total) * 100, 2);
                $voto->perc_ruim = round(($voto->total_ruim / $voto->total) * 100, 2);
            }

            // Salvar as alterações
            $voto->save();

            // Retorna a resposta em formato JSON
            return response()->json([
                'message' => 'Voto atualizado com sucesso!',
                'data' => $voto
            ], 200);
        } else {
            // Caso não exista voto para a data e empresa, cria um novo
            $voto = new Voto();
            $voto->data_registro = $dataAtual;
            $voto->id_empresa = $request->id_empresa;
            $voto->id_gestor = $request->id_gestor;
            $voto->qt_funcionarios = $request->qt_funcionarios;
            $voto->total_otimo = $request->total_otimo;
            $voto->total_bom = $request->total_bom;
            $voto->total_regular = $request->total_regular;
            $voto->total_ruim = $request->total_ruim;

            // Calcular o total de votos
            $voto->total = $voto->total_otimo + $voto->total_bom + $voto->total_regular + $voto->total_ruim;

            // Calcular a porcentagem de votos
            if ($voto->total > 0) {
                $voto->perc_otimo = round(($voto->total_otimo / $voto->total) * 100, 2);
                $voto->perc_bom = round(($voto->total_bom / $voto->total) * 100, 2);
                $voto->perc_regular = round(($voto->total_regular / $voto->total) * 100, 2);
                $voto->perc_ruim = round(($voto->total_ruim / $voto->total) * 100, 2);
            }

            // Salvar o novo voto
            $voto->save();

            // Retorna a resposta em formato JSON
            return response()->json([
                'message' => 'Voto registrado com sucesso!',
                'data' => $voto
            ], 201);
        }
    }

    /**
     * @OA\Get(
     *     path="/votos",
     *     tags={"Voto"},
     *     summary="Listar todos os votos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de votos registrados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="total", type="integer", example=100),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Voto")
     *             )
     *         )
     *     )
     * )
     */
    public function listarVotos()
    {
        // Buscar todos os votos
        $votos = Voto::all();

        // Retornar a resposta em formato JSON
        return response()->json([
            'success' => true,
            'total' => $votos->count(),
            'data' => $votos
        ]);
    }
}

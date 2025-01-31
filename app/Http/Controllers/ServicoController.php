<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
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

    public function show($id)
    {
        // Recuperando um serviço específico pelo ID
        $servico = Servico::with('empresa')->findOrFail($id);

        return response()->json([
            'success' => true,
            'docs' => $servico,
        ]);
    }

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

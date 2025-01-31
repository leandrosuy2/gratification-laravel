<?php

namespace App\Http\Controllers;

use App\Models\Gerente;
use Illuminate\Http\Request;

class GerenteController extends Controller
{
    public function index()
    {
        // Recuperando todos os gerentes, com as informações de usuário (id_usuario)
        $gerentes = Gerente::with('usuario')->get();

        return response()->json([
            'success' => true,
            'recordsTotal' => $gerentes->count(),
            'recordsFiltered' => $gerentes->count(),
            'docs' => $gerentes,
            'total' => $gerentes->count(),
        ]);
    }

    public function show($id)
    {
        // Recuperando um gerente específico pelo ID
        $gerente = Gerente::with('usuario')->findOrFail($id);

        return response()->json([
            'success' => true,
            'docs' => $gerente,
        ]);
    }

    public function store(Request $request)
    {
        // Validando os dados recebidos
        $validatedData = $request->validate([
            'id_usuario' => 'required|string|exists:usuarios,id',
            'status' => 'required|boolean',
        ]);

        // Criando o gerente
        $gerente = Gerente::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Gerente criado com sucesso!',
            'docs' => $gerente,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Recuperando o gerente pelo ID
        $gerente = Gerente::findOrFail($id);

        // Validando os dados recebidos
        $validatedData = $request->validate([
            'id_usuario' => 'required|string|exists:usuarios,id',
            'status' => 'required|boolean',
        ]);

        // Atualizando o gerente
        $gerente->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Gerente atualizado com sucesso!',
            'docs' => $gerente,
        ]);
    }

    public function destroy($id)
    {
        // Encontrando e excluindo o gerente
        $gerente = Gerente::findOrFail($id);
        $gerente->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gerente excluído com sucesso!',
        ]);
    }
}

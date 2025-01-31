<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmpresaController extends Controller
{
    // Método para listar empresas na view
    public function index()
    {
        Log::info('Listando todas as empresas.');

        $empresas = Empresa::with(['servicos', 'gerentes'])->get();

        Log::info('Empresas listadas com sucesso.', ['quantidade' => $empresas->count()]);

        return view('empresas.index', compact('empresas'));
    }

    // Método para exibir uma empresa específica na view
    public function show($id)
    {
        Log::info('Buscando detalhes da empresa.', ['empresa_id' => $id]);

        $empresa = Empresa::with(['servicos', 'gerentes'])->findOrFail($id);

        Log::info('Detalhes da empresa recuperados com sucesso.', ['empresa_id' => $id]);

        return view('empresas.show', compact('empresa'));
    }

    public function create()
    {
        Log::info('Abrindo formulário para criação de nova empresa.');
        return view('empresas.create');
    }

    // Método para criar uma nova empresa via API
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

    // Método para atualizar uma empresa via API
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

    // Método para excluir uma empresa via API
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

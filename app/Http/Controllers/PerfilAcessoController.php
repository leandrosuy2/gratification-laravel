<?php

namespace App\Http\Controllers;

use App\Models\PerfilAcesso;

class PerfilAcessoController extends Controller
{
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

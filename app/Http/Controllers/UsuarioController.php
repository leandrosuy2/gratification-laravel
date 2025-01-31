<?php

namespace App\Http\Controllers;

use App\Models\User;

class UsuarioController extends Controller
{
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

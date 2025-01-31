<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerfilAcessoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $perfis = [
            ['nome' => 'TI', 'status' => 1],
            ['nome' => 'Usuário Cliente', 'status' => 1],
            ['nome' => 'Gerente', 'status' => 1],
            ['nome' => 'Cliente', 'status' => 1],
            ['nome' => 'Diretor(a)', 'status' => 1],
            ['nome' => 'Administrador(a)', 'status' => 1],
        ];

        foreach ($perfis as $perfil) {
            \App\Models\PerfilAcesso::create($perfil);
        }
    }

}

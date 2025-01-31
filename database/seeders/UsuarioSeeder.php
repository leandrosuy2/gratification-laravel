<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Usuario::create([
            'nome' => 'ANDREIA OLIVEIRA R1',
            'username' => 'andreiar1',
            'image' => 'photo.png',
            'email' => 'andreia@example.com',
            'telcel' => '123456789',
            'id_perfil' => 4, // Cliente
            'setor' => 'Vendas',
            'date_acs' => now(),
            'menu_permissions' => [
                'menu_dashboard' => 0,
                'menu_gestao' => 0,
                'menu_cadastros' => 0,
                'menu_pesquisas' => 1,
                'menu_install_app_mobile' => 1,
            ],
            'user_edt' => 'iago',
            'status' => 1,
        ]);
    }

}

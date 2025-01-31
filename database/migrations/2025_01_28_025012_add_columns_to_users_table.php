<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Adicionando os campos que faltam
            $table->string('username')->nullable()->unique()->after('email'); // Permitir valores nulos
            $table->string('telcel')->nullable()->after('username');
            $table->foreignId('id_perfil')->nullable()->constrained('perfil_acessos')->after('telcel');
            $table->string('setor')->nullable()->after('id_perfil');
            $table->tinyInteger('status')->default(1)->after('setor');
            $table->json('menu_permissions')->nullable()->after('status');
            $table->string('user_edt')->nullable()->after('menu_permissions');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'telcel',
                'id_perfil',
                'setor',
                'status',
                'menu_permissions',
                'user_edt'
            ]);
        });
    }
}

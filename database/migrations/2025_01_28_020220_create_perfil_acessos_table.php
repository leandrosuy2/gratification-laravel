<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_acessos', function (Blueprint $table) {
            $table->id(); // bigint unsigned (chave primária)
            $table->string('nome'); // Nome do perfil
            $table->boolean('status')->default(1); // Status ativo ou inativo
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_acessos');
    }
};

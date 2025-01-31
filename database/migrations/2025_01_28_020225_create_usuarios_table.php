<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('username')->unique();
            $table->string('image')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('telcel')->nullable();
            $table->unsignedBigInteger('id_perfil'); // Deve ser unsignedBigInteger
            $table->string('setor')->nullable();
            $table->dateTime('date_acs')->nullable();
            $table->boolean('status')->default(1);
            $table->json('menu_permissions')->nullable();
            $table->string('user_edt')->nullable();
            $table->timestamps();

            // Adicionar a chave estrangeira corretamente
            $table->foreign('id_perfil')->references('id')->on('perfil_acessos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

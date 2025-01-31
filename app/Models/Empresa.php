<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';  // Defina o nome da tabela se não for o plural do nome do model

    protected $fillable = [
        'logo',
        'nome',
        'razao_social',
        'email',
        'telcom',
        'telcel',
        'cnpj',
        'qt_funcionarios',
        'cep',
        'rua',
        'numero',
        'complem',
        'bairro',
        'cidade',
        'estado',
        'id_usuario',
        'id_gestor',
        'versao',
        'resto_ingesta',
        'status',
        'user_edt',
    ];

    protected $casts = [
        'servicos' => 'array',
        'gerentes' => 'array',
    ];

    // Defina o relacionamento com outros modelos se necessário, por exemplo, com 'servicos' e 'gerentes'
    public function servicos()
    {
        return $this->hasMany(Servico::class, 'id_empresa');
    }

    public function gerentes()
    {
        return $this->hasMany(Gerente::class, 'id_empresa');
    }
}

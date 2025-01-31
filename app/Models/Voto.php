<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    use HasFactory;

    protected $table = 'votos';  // Nome da tabela no banco de dados

    protected $fillable = [
        'data_registro',
        'id_empresa',
        'nome_empresa',
        'id_gestor',
        'qt_funcionarios',
        'total_otimo',
        'total_bom',
        'total_regular',
        'total_ruim',
        'total',
        'perc_otimo',
        'perc_bom',
        'perc_regular',
        'perc_ruim',
    ];

    protected $casts = [
        'data_registro' => 'date',
    ];

    // Relacionamento com a model Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    // Relacionamento com a model Gestor (caso você tenha um modelo de Gestor)
    public function gestor()
    {
        return $this->belongsTo(Gerente::class, 'id_gestor');
    }
}

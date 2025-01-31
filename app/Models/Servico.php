<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'servicos';  // Defina o nome da tabela, caso seja diferente

    protected $fillable = [
        'id_empresa',
        'tipo_servico',
        'nome',
        'hora_inicio',
        'hora_final',
        'status',
        'user_add',
        'date_add',
    ];

    protected $casts = [
        'date_add' => 'datetime',
    ];

    // Defina o relacionamento com o modelo Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}

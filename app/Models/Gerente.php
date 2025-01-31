<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerente extends Model
{
    use HasFactory;

    protected $table = 'gerentes';  // Defina o nome da tabela, caso seja diferente

    protected $fillable = [
        'id_usuario',
        'id_empresa',
        'nome',
        'status',
    ];

    // Defina o relacionamento com o modelo Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    // Defina o relacionamento com o modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilAcesso extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'status'];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_perfil');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importar a classe Authenticatable
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // Herda de Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'telcel',
        'id_perfil',
        'setor',
        'status',
        'menu_permissions',
        'user_edt',
        'profile_image',
    ];

    protected $casts = [
        'menu_permissions' => 'array',
        'date_acs' => 'datetime',
    ];

    protected $hidden = [
        'password', // Esconde o campo password ao retornar em respostas JSON
    ];

    // Relacionamento com PerfilAcesso
    public function perfil()
    {
        return $this->belongsTo(PerfilAcesso::class, 'id_perfil');
    }

    // Adicione esse método para garantir que o Laravel encontre o campo de senha
    public function getAuthPassword()
    {
        return $this->password;
    }
}

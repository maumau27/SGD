<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class Perfil extends Model
{
    use Notifiable;
    use Sortable;

    protected $table = 'Perfil';
    
    public $timestamps = false;

    public function permissoes()
    {
        return $this->belongsToMany(Permissoes::class, 'PerfilPermissoes', 'idPerfil', 'idPermissoes');
    }

    public function usuario()
    {
        return $this->belongsToMany(Usuarios::class, 'UsuarioPerfil', 'idPerfil', 'idUsuario');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nome', 
        'Codigo',
    ];

    public $sortable = [
        'Nome', 
        'Codigo',
    ];
}

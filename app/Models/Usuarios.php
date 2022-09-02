<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

use Kyslik\ColumnSortable\Sortable;

class Usuarios extends Authenticatable
{
    use Notifiable;
    use Sortable;

    protected $table = 'Usuarios';
    
    public $timestamps = false;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function perfil()
    {
        return $this->belongsToMany(Perfil::class, 'UsuarioPerfil', 'idUsuario', 'idPerfil');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Login', 
        'Email',
        'Nome',
        'Senha',
        'DT_criado',
        'DT_ultima_senha'
    ];

    public $sortable = [
        'Login', 
        'Email',
        'Nome',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Senha',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Add a mutator to ensure hashed passwords
     */
    public function setSenhaAttribute($password)
    {
        $this->attributes['Senha'] = Hash::make($password);
    }

    /**
     * Overrides the getAuthPassword
     */
    public function getAuthPassword()
    {
        return $this->attributes['Senha'];
    }
}

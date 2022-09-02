<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class Permissoes extends Model
{
    use Notifiable;
    use Sortable;

    protected $table = 'Permissoes';
    
    public $timestamps = false;

    public function itemMenu()
    {
        return $this->hasOne(ItemMenu::class, 'idPermissoes');
    }

    public function perfil()
    {
        return $this->belongsToMany(Perfil::class, "PerfilPermissoes", 'idPermissoes', 'idPerfil');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nome', 
        'Controller',
        'Action',
    ];

    public $sortable = [
        'Nome', 
        'Controller',
        'Action',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        
    ];
}

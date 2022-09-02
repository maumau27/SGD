<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;

class ItemMenu extends Model
{
    use Notifiable;
    use Sortable;

    protected $table = 'ItemMenu';
    
    public $timestamps = false;

    public function permissoes()
    {
        return $this->belongsTo(Permissoes::class, 'idPermissoes');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Menu', 
        'Item',
        'idPermissoes'
    ];

    public $sortable = [
        'Menu', 
        'Item',
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

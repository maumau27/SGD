<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

use Kyslik\ColumnSortable\Sortable;

class PreReq extends Model
{
    use Notifiable;
    use Sortable;

    protected $table = 'PreReq';
    
    public $timestamps = false;

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class, 'idDisciplina');
    }

    public function requisitos()
    {
        return $this->belongsToMany(Disciplina::class, "DisciplinaPreReq", 'idPreReq', 'idDisciplina');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idDisciplina', 
        'ListaCodigos',
        'NumeroCreditos',
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

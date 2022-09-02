<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Kyslik\ColumnSortable\Sortable;

class DisciplinaTurmaCache extends Model
{
    use Notifiable;
    use Sortable;

    protected $table = 'DisciplinaTurmaCache';
    
    public $timestamps = false;

    public function turma()
    {
        return $this->hasOne(Turma::class, 'idDisciplinaCache');
    }

    public function turmas()
    {
        return $this->belongsTo(Turma::class, 'idTurma');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Codigo', 
        'Titulo',
        'Creditos',
        'Ementa',
        'idTurma',
    ];

    public $sortable = [
        'Codigo', 
        'Titulo',
        'Creditos',
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

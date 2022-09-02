<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Kyslik\ColumnSortable\Sortable;

class Turma extends Model
{
    use Notifiable;
    use Sortable;
    
    protected $table = 'Turma';
    
    public $timestamps = false;

    public function professor()
    {
        return $this->belongsTo(professor::class, 'idProfessor');
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class, 'idDisciplina');
    }

    public function professorCache()
    {
        return $this->belongsTo(ProfessorTurmaCache::class, 'idProfessorCache');
    }

    public function disciplinaCache()
    {
        return $this->belongsTo(DisciplinaTurmaCache::class, 'idDisciplinaCache');
    }

    public function professorCacheTodos()
    {
        return $this->hasMany(ProfessorTurmaCache::class, 'idTurma');
    }

    public function disciplinaCacheTodos()
    {
        return $this->hasMany(DisciplinaTurmaCache::class, 'idTurma');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Codigo',
        'MaximoAlunos',
        'Ano',
        'Semestre',
        'codigoDisciplina',
        'idProfessor', 
        'idDisciplina'
    ];

    public $sortable = [
        'Codigo',
        'MaximoAlunos',
        'Ano',
        'codigoDisciplina',
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

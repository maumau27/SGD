<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Kyslik\ColumnSortable\Sortable;

class Professor extends Model
{
    use Notifiable;
    use Sortable;

    protected $table = 'Professor';
    
    public $timestamps = false;

    public function disciplina()
    {
        return $this->belongsToMany(Disciplina::class, "Turma", 'idProfessor', 'idDisciplina')
                    ->withPivot('Ano', 'Semestre');
    }

    public function turma()
    {
        return $this->hasMany(Turma::class, 'idProfessor');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nome',
        'Bio', 
        'MiniBio',
        'Cargo', 
        'BolsaProdutividade',
        'Telefone', 
        'Sala',
        'Site', 
        'Email',
        'Lattes', 
        'Linkedin',
        'DBPL', 
        'ORCID',
        'Publons',
    ];

    public $sortable = [
        'Nome'
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

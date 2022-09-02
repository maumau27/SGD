<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProfessorTurmaCache extends Model
{
    use Notifiable;

    protected $table = 'ProfessorTurmaCache';
    
    public $timestamps = false;

    public function turma()
    {
        return $this->hasOne(Turma::class, 'idProfessorCache');
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
        'idTurma',
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

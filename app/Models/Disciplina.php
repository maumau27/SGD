<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Kyslik\ColumnSortable\Sortable;

class Disciplina extends Model
{
    use Notifiable;
    use Sortable;

    protected $table = 'Disciplina';
    
    public $timestamps = false;

    public function bibliografia()
    {
        return $this->belongsToMany(Bibliografia::class, "DisciplinaBibliografia", 'idDisciplina', 'idBibliografia')->where('Complementar', '=', '0');
    }

    public function bibliografiaComplementar()
    {
        return $this->belongsToMany(Bibliografia::class, "DisciplinaBibliografia", 'idDisciplina', 'idBibliografia')->where('Complementar', '=', '1');
    }

    public function professor()
    {
        return $this->belongsToMany(Professor::class, "ProfessorDisciplina", 'idDisciplina', 'idProfessor');
    }

    public function curriculo()
    {
        return $this->belongsToMany(Curriculo::class, "CurriculoDisciplina", 'idDisciplina', 'idCurriculo');
    }

    public function optativa() 
    {
        return $this->belongsToMany(Disciplina::class, "DisciplinaOptativa", 'idDisciplinaOptativa', 'idDisciplinaGrupo');
    }

    public function turma()
    {
        return $this->hasMany(Turma::class, 'idDisciplina');
    }

    public function preReq()
    {
        return $this->hasMany(PreReq::class, "idDisciplina");
    }

    public function temPreReq()
    {
        return !$this->preReq->isEmpty();
    }

    public function requisitos()
    {
        if(!$this->temPreReq())
            return array();

        $requisitos = array();
        
        foreach($this->preReq as $key => $prereq)
        {
            $requisitos[$key] = array();
            foreach($prereq->requisitos as $key2 => $requisito)
                array_push($requisitos[$key], ["Codigo" => $requisito->Codigo, "id" => $requisito->id]);

            if($prereq->NumeroCreditos != 0)
                array_push($requisitos[$key], ["NumeroCreditos" => $prereq->NumeroCreditos, "id" => $prereq->id]);
        }

        return $requisitos;
    }

    public function requisitosLista()
    {
        if(!$this->temPreReq())
            return "";

        $requisitos = array();
        foreach($this->preReq as $key => $prereq)
        {
            $requisitos[$key] = array();
            foreach($prereq->requisitos as $requisito)
                array_push($requisitos[$key], $requisito->Codigo);
            $requisitos[$key] = implode(",", $requisitos[$key]);
        }

        return implode(";", $requisitos);
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

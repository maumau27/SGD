<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Kyslik\ColumnSortable\Sortable;

class Curriculo extends Model
{
    use Notifiable;
    use Sortable;

    protected $table = 'Curriculo';
    
    public $timestamps = false;

    public function disciplina()
    {
        return $this->belongsToMany(Disciplina::class, "CurriculoDisciplina", 'idCurriculo', 'idDisciplina')->withPivot('PeriodoNumero', 'codigoDisciplina', 'PeriodoNome')->orderBy('PeriodoNumero');
    }

    public function periodos()
    {
        $disciplinas = $this->disciplina;
        $periodos = array();

        foreach($disciplinas as $disicplina)
        {
            if(!array_key_exists($disicplina->pivot->PeriodoNome, $periodos))
                $periodos[$disicplina->pivot->PeriodoNome] = array();

            array_push($periodos[$disicplina->pivot->PeriodoNome], $disicplina);
        }

        return $periodos;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nome',
    ];

    public $sortable = [
        'Nome',
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

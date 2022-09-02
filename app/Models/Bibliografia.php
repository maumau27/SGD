<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Kyslik\ColumnSortable\Sortable;

class Bibliografia extends Model
{
    use Notifiable;
    use Sortable;

    protected $table = 'Bibliografia';
    
    public $timestamps = false;

    public function disciplina()
    {
        return $this->belongsToMany(Disciplina::class, "DisciplinaBibliografia", 'idBibliografia', 'idDisciplina')->withPivot('Complementar');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Titulo',
    ];

    public $sortable = [
        'Titulo',
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

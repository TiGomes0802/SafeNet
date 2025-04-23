<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $table = 'unidades';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descricao',
        'ordem',
        'status',
        'idCurso',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'idCurso');
    }

    public function Jogo()
    {
        return $this->hasMany(Jogo::class, 'idJogo');
    }

    public function Pagina()
    {
        return $this->hasMany(Pagina::class, 'idUnidade');
    }

    public function User()
    {
        return $this->belongsToMany(User::class, 'user_unidades', 'idUnidade', 'idUser')
            ->withPivot('status');
    } 
}

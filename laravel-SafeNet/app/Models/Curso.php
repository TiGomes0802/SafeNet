<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'estado',
    ];

    public function linksExternos()
    {
        return $this->belongsToMany(LinkExterno::class, 'curso_link', 'idCurso', 'idLink');
    }

    public function unidades()
    {
        return $this->hasMany(Unidade::class, 'idCurso');
    }
}

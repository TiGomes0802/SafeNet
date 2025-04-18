<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkExterno extends Model
{
    protected $table = 'linksExternos';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'link',
    ];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_link', 'idLink', 'idCurso');
    }
}

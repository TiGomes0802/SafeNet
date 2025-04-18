<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    protected $table = 'respostas';

    public $timestamps = false;

    protected $fillable = [
        'resposta',
        'certa',
        'idJogo',
    ];

    public function jogo()
    {
        return $this->belongsTo(Jogo::class, 'idJogo');
    }

}

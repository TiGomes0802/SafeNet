<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoJogo extends Model
{
    protected $table = 'tipoJogos';

    public $timestamps = false;

    protected $fillable = [
        'tipo',
    ];

    public function jogos()
    {
        return $this->hasMany(Jogo::class, 'idTipoJogo');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMissao extends Model
{
    protected $table = 'tipoMissoes';

    public $timestamps = false;

    protected $fillable = [
        'tipo',
    ];

    public function missoes()
    {
        return $this->hasMany(Missao::class, 'idTipoMissao');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMissao extends Model
{
    protected $table = 'tipomissao';

    protected $fillable = [
        'tipo',
    ];

    public function missoes()
    {
        return $this->hasMany(Missao::class, 'idTipoMissao');
    }
}

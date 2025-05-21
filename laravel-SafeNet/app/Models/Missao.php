<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Missao extends Model
{
    protected $table = 'missoes';

    public $timestamps = false;

    protected $fillable = [
        'tipo',
        'estado',
        'descricao',
        'objetivo',
        'moedas',
        'idTipoMissao',
    ];

    public function UserMissao()
    {
        return $this->hasMany(UserMissao::class, 'idMissao');
    }

    public function tipoMissao()
    {
        return $this->belongsTo(TipoMissao::class, 'idTipoMissao');
    }
}

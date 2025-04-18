<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $table = 'rank';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'imagem',
        'minimo',
        'maximo',
    ];

    public function user()
    {
        return $this->HasMany(User::class, 'idRank');
    }
}

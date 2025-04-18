<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estatistica extends Model
{
    protected $table = 'estatisticas';
    
    public $timestamps = false;

    protected $fillable = [
        'numVezes',
        'numAcertos',
        'idJogo',
        'idUser',
    ];

    public function jogo()
    {
        return $this->belongsTo(Jogo::class, 'idJogo');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}

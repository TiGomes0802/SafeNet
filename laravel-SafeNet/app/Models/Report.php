<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
        'mensagem',
        'estado',
        'idJogo',
        'idUser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function jogo()
    {
        return $this->belongsTo(Jogo::class, 'idJogo');
    }
}

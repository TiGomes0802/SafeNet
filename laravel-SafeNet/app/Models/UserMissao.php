<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMissao extends Model
{
    protected $table = 'users_missoes';

    protected $fillable = [
        'presente',
        'concluida',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function missao()
    {
        return $this->belongsTo(Missao::class, 'idMissao');
    }
}

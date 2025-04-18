<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amigo extends Model
{
    protected $table = 'amigos';

    protected $fillable = [
        'status',
        'idUser1',
        'idUser2',
    ];

    public function user1()
    {
        return $this->belongsTo(User::class, 'idUser1');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'idUser2');
    }
}

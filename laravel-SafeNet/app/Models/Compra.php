<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    public $timestamps = false;

    protected $fillable = [
        'idProduto',
        'idUser',
        'usado',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'idProduto');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idCompra');
    }
}

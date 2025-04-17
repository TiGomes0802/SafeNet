<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'preco',
        'idTipoProduto',
    ];

    public function tipoProduto()
    {
        return $this->belongsTo(TipoProduto::class, 'idTipoProduto');
    }

    public function compra()
    {
        return $this->belongsToMany(User::class, 'compra', 'idProduto', 'idCompra')
            ->withPivot('quantidade')
            ->withTimestamps();
    }
}

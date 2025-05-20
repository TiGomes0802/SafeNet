<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
    protected $table = 'tipoProdutos';

    public $timestamps = false;

    protected $fillable = [
        'tipo',
        'imagem',
    ];

    public function produto()
    {
        return $this->hasMany(Produto::class, 'idTipoProduto');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    protected $table = 'paginas';

    public $timestamps = false;

    protected $fillable = [
        'descricao',
        'ordem',
        'idUnidade',
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'idUnidade');
    }
}

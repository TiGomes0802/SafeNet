<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jogo extends Model
{
    protected $table = 'jogos';
    
    public $timestamps = false;

    protected $fillable = [
        'xp',
        'estado',
        'pergunta',
        'idUser',
        'idGestor',
        'idTipo',
        'idUnidade',
    ];

    public function respostas()
    {
        return $this->hasMany(Resposta::class, 'idJogo');
    }

    public function estatisticas()
    {
        return $this->hasMany(Estatistica::class, 'idJogo');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'idJogo');
    }

    public function tipoJogo()
    {
        return $this->belongsTo(TipoJogo::class, 'idTipo');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'idUnidade');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function gestor()
    {
        return $this->belongsTo(User::class, 'idGestor');
    }
}

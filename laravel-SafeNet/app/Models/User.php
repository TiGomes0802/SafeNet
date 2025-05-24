<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
        'email',
        'password',
        'type',
        'username',
        'foto',
        'moedas',
        'streak',
        'xp',
        'vida',
        'idRank',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * 
     */
    public function rank()
    {
        return $this->belongsTo(Rank::class, 'idRank');
    }

    public function amigo1()
    {
        return $this->hasMany(Amigo::class, 'idUser1');
    }

    public function amigo2()
    {
        return $this->hasMany(Amigo::class, 'idUser2');
    }

    public function todosAmigos()
    {
        // Vai buscar os amigos a quem este utilizador enviou pedidos
        $amigos1 = $this->amigo1()
            ->where('status', 1)
            ->with('amigo2')
            ->get()
            ->pluck('amigo2'); // Devolve os amigos (user2)

        // Vai buscar os amigos que enviaram pedido a este utilizador
        $amigos2 = $this->amigo2()
            ->where('status', 1)
            ->with('amigo1')
            ->get()
            ->pluck('amigo1'); // Devolve os amigos (user1)

        // Junta os dois lados
        return $amigos1->merge($amigos2)->sortBy('id')->values();
    }

    public function enviarPedidoAmizade(User $amigo)
    {

        // Cria o pedido de amizade
        Amigo::create([
            'idUser1' => $this->id,
            'idUser2' => $amigo->id,
            'status' => 0, // 0 = Pendente
        ]);

        return true; // Pedido enviado com sucesso
    }

    public function report()
    {
        return $this->hasMany(Report::class, 'idUser');
    }

    /*public function estatistica()
    {
        return $this->hasMany(Estatistica::class, 'idUser');
    }*/

    public function userMissao()
    {
        return $this->hasMany(UserMissao::class, 'idUser');
    }

    public function jogo()
    {
        return $this->hasMany(Jogo::class, 'idUser');
    }

    public function jogoGestor()
    {
        return $this->hasMany(Jogo::class, 'idGestor');
    }

    public function unidade()
    {
        return $this->belongsToMany(Unidade::class, 'user_unidades', 'idUser', 'idUnidade')
            ->withPivot('status');
    }

    public function estatistica()
    {
        return $this->belongsToMany(Jogo::class, 'estatisticas', 'idUser', 'idJogo')
            ->withPivot('numVezes', 'numAcertos');
    }
}

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
        // Junta os dois lados da amizade
        return $this->amigos1->merge($this->amigos2);
    }

    public function Report()
    {
        return $this->hasMany(Report::class, 'idUser');
    }

    public function Estatistica()
    {
        return $this->hasMany(Estatistica::class, 'idUser');
    }

    public function UserMissao()
    {
        return $this->hasMany(UserMissao::class, 'idUser');
    }

    public function Jogo()
    {
        return $this->hasMany(Jogo::class, 'idUser');
    }

    public function JogoGestor()
    {
        return $this->hasMany(Jogo::class, 'idGestor');
    }

    public function Unidade()
    {
        return $this->belongsToMany(Unidade::class, 'user_unidades', 'idUser', 'idUnidade')
            ->withPivot('status');
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'type' => $this->type,
            'username' => $this->username,
            'moedas' => $this->moedas,
            'streak' => $this->streak,
            'streakFeita' => $this->streakFeita,
            'xp' => $this->xp,
            'vida' => $this->vida,
            'ultima_vida_update' => $this->ultima_vida_update,
            'rank' => $this->rank ?? null,
            'foto' => $this->foto ? asset('storage/photos/' . $this->foto) : null,
            'congelar' => $this->compra()
                ->where('usado', false)
                ->whereHas('produto.tipoProduto', function($query) {
                    $query->where('tipo', 'Gelo');
                })->count(),
        ];
    }
}

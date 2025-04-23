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
            'xp' => $this->xp,
            'vida' => $this->vida,
            'idRank' => $this->idRank,
            'foto' => $this->foto ? '/storage/photos/' . $this->photo_filename : null,
        ];
    }
}

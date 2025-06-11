<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMissao;
use App\Models\Missao;
use App\Models\Rank;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        return User::all();
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);

        $user = User::create($validatedData);

        return response()->json($user, 201);
    }


    public function show($id)
    {
        $user = User::with(['transactions', 'gamesCreated', 'gamesWon', 'multiplayerGamesPlayed'])->findOrFail($id);
        return response()->json($user);
    }

    /**
     * Display the authenticated user.
     */
    public function showMe(Request $request)
    {
        $user = $request->user();
        $user->updateLives();

        $user->rank = Rank::where('minimo', '<=', $user->xp)
            ->where('maximo', '>=', $user->xp)
            ->value('nome');

        return new UserResource($user);
    }

    public function getCoins(Request $request)
    {
        try {

            $user = $request->user();
            return response()->json(['coins' => $user->moedas]);
        } catch (\Exception $e) {
            \Log::error('Erro ao buscar moedas: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao buscar moedas'], 500);
        }
    }

    /**
     * Ganhar moedas.
     */

    public function ganharMoedas(Request $request)
    {
        $user = Auth::user();
        $quantidade = $request->input('quantidade');

        $user->moedas += $quantidade;
        $user->save();

        return response()->json(['moedas' => $user->moedas]);
    }

    /**
     * Get all users.
     */
    public function getAllGestoresAdmins(Request $request)
    {
        $users = User::whereIn('type', ['G', 'A'])->get();

        foreach ($users as $user) {
            $user->foto = $user->foto ? asset('storage/photos/' . $user->foto) : null;
            $user->makeHidden(['password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at', 'email_verified_at', 'moedas', 'streakFeita', 'vida', 'ultima_vida_update', 'deleted_at', 'idRank']);
        }

        return response()->json($users);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    /**
     * Block the specified user.
     * @param Request $request
     * @id int $id -> id do user para bloquear
     */
    public function block(Request $request)
    {
        try {
            $userToBlock = User::findOrFail($request->id);

            $userToBlock->blocked = 1;
            $userToBlock->save();

            return response()->json(['message' => 'User blocked successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Erro ao bloquear utilizador: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao bloquear utilizador'], 500);
        }
    }

    /**
     * Unblock the specified user.
     * @param Request $request
     * @id int $id -> id do user para desbloquear
     */
    public function unblock(Request $request)
    {
        try {
            $userToUnblock = User::findOrFail($request->id);

            $userToUnblock->blocked = 0;
            $userToUnblock->save();

            return response()->json(['message' => 'User unblocked successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Erro ao desbloquear utilizador: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao desbloquear utilizador'], 500);
        }
    }

    public function getVidas(Request $request)
    {
        //O utilizador que esta logado tem vidas
        $user = $request->user();
        $user->updateLives();

        return response()->json([
            'vidas' => $user->vida,
            'ultimaReposicao' => $user->ultima_vida_update,
        ], 200);
    }

    /**
     * Lost 1 life.
     * @param Request $request
     */
    public function perderVida(Request $request)
    {
        //O utilizador perdeu uma vida que esta logado perde uma vida não pode ser menor que 0
        $user = $request->user();

        $user->updateLives();

        if ($user->vida > 0) {
            $user->vida -= 1;
            
            if ($user->vida < 5 && $user->ultima_vida_update === null) {
                $user->ultima_vida_update = now();
            }
            
            $user->save();

            return response()->json([
                'message' => 'O utilizador perdeu uma vida com sucesso', 
                'vidas' => $user->vida,
                'ultimaReposicao' => $user->ultima_vida_update,
            ], 200);

        } else {
            return response()->json(['message' => 'O utilizador já não tem vidas'], 400);
        }
    }

    public function ganharVidas(Request $request)
    {
        //Validate the request
        $request->validate([
            'numVidas' => 'required|integer|min:1',
        ]);

        //O utilizador ganhou uma vida que esta logado ganha uma vida
        $user = $request->user();
        $user->updateLives();
        $user->vida += $request->numVidas;
        if ($user->vida >= 5) {
            $user->ultima_vida_update = null;
        }
        $user->save();
        return response()->json([
            'message' => 'O utilizador ganhou vidas com sucesso',
            'vidas' => $user->vida,
            'ultimaReposicao' => $user->ultima_vida_update,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * Get user by username.
     */
    public function getUserByUsername($username, Request $request)
    {
        if (!$username) {
            return response()->json(['error' => 'Username is required'], 400);
        }

        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $authUser = $request->user();

        $user->isFriend = $authUser->todosAmigos()->contains('id', $user->id);;

        $pedidoEnviado = $authUser->amigo1()
            ->where('idUser2', $user->id)
            ->where('status', 0)
            ->exists();
        
        $pedidoRecebido = $authUser->amigo2()
            ->where('idUser1', $user->id)
            ->where('status', 0)
            ->exists();

        $user->isHaveRequest = ($pedidoEnviado || $pedidoRecebido);

        $user->rank = Rank::where('minimo', '<=', $user->xp)
            ->where('maximo', '>=', $user->xp)
            ->value('nome');

        $user->foto = $user->foto ? asset('storage/photos/' . $user->foto) : null;

        // Escolher os campos que quer retornar
        $user->makeHidden(['password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at', 'email_verified_at', 'moedas', 'streakFeita', 'vida', 'ultima_vida_update', 'deleted_at', 'idRank']);
        
        return $user;
    }
}

<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Amigo;

class AmigoController extends Controller
{
    public function getAmigos(Request $request)
    {
        $user = auth()->user();
        $amigos = $user->todosAmigos()->map(function ($amigo) {
            return [
                'nome' => $amigo->nome,
                'username' => $amigo->username,
                'xp' => $amigo->xp,
            ];
        });

        return response()->json($amigos);
    }

    public function getPedidosAmizade(Request $request)
    {
        $pedidos = $this->obterPedidosPendentes();

        return response()->json($pedidos);
    }

    public function enviarPedidoAmizade(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $user = auth()->user();

        $amigo = User::where('username', $request->input('username'))->first();

        if (!$amigo) {
            return response()->json(['message' => 'Utilizador não encontrado'], 400);
        }
        if ($user->id === $amigo->id) {
            return response()->json(['message' => 'Você não pode enviar um pedido de amizade para si mesmo'], 400);
        }
        
        if ($user->todosAmigos()->contains('id', $amigo->id)) {
            return response()->json(['message' => 'Já és amigo deste utilizador'], 400);
        }

        $pedidoExistente = $user->amigo1()
            ->where('idUser2', $amigo->id)
            ->where('status', 0)
            ->exists();

        $pedidoRecebido = $user->amigo2()
            ->where('idUser2', $amigo->id)
            ->where('status', 0)
            ->exists();

        if ($pedidoExistente || $pedidoRecebido) {
            return response()->json(['message' => 'Já existe um pedido de amizade pendente com este utilizador'], 400);
        }

        $user->enviarPedidoAmizade($amigo);

        return response()->json(['message' => 'Pedido de amizade enviado com sucesso', 200]);
    }

    public function responderPedidoAmizade(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'resposta' => 'required|integer|in:-1,1',
        ]);

        $user = auth()->user();

        $amigo = User::where('username', $request->input('username'))->first();

        if (!$amigo) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $pedido = Amigo::where('idUser1', $amigo->id)
            ->where('idUser2', $user->id)
            ->first();

        if (!$pedido || $pedido->status !== 0) {
            return response()->json(['message' => 'Nenhum pedido de amizade pendente encontrado'], 404);
        }

        if ($request->input('resposta') == -1) {
            $pedido->delete();
        }else {
            $pedido->status = 1;
            $pedido->save();
        }
        
        $pedidos = $this->obterPedidosPendentes();
        $amigos = $user->todosAmigos()->map(function ($amigo) {
            return [
                'nome' => $amigo->nome,
                'username' => $amigo->username,
            ];
        });

        return response()->json([
            'message' => 'Pedido de amizade aceito com sucesso',
            'pedidos' => $pedidos,
            'amigos' => $amigos,
        ]);
    }

    public function removerAmigo(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $user = auth()->user();

        $amigo = User::where('username', $request->input('username'))->first();

        if (!$amigo) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        if (!$user->todosAmigos()->contains('id', $amigo->id)) {
            return response()->json(['message' => 'Este utilizador não é teu amigo'], 400);
        }

        Amigo::where(function ($query) use ($user, $amigo) {
                $query->where('idUser1', $user->id)->where('idUser2', $amigo->id);
            })->orWhere(function ($query) use ($user, $amigo) {
                $query->where('idUser1', $amigo->id)->where('idUser2', $user->id);
            })->delete();

        return response()->json(['message' => 'Amigo removido com sucesso']);
    }

    private function obterPedidosPendentes()
    {
        $user = auth()->user();

        $pedidosRecebidos = Amigo::with('amigo1')
            ->where('idUser2', $user->id)
            ->where('status', 0)
            ->get()
            ->map(function ($pedido) {
                return [
                    'nome' => $pedido->amigo1->nome,
                    'username' => $pedido->amigo1->username,
                ];
            });

        $pedidosEnviados = Amigo::with('amigo2')
            ->where('idUser1', $user->id)
            ->where('status', 0)
            ->get()
            ->map(function ($pedido) {
                return [
                    'nome' => $pedido->amigo2->nome,
                    'username' => $pedido->amigo2->username,
                ];
            });

        return [
            'pedidosRecebidos' => $pedidosRecebidos,
            'pedidosEnviados' => $pedidosEnviados,
        ];
    }
}

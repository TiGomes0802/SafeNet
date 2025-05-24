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
        $user = auth()->user();
        $amigo = User::where('username', $request->input('username'))->first();

        if (!$amigo) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
        
        if ($user->id === $amigo->id) {
            return response()->json(['message' => 'Você não pode enviar um pedido de amizade para si mesmo'], 400);
        }

        if ($user->todosAmigos()->contains('id', $amigo->id)) {
            return response()->json(['message' => 'Já és amigo deste utilizador'], 400);
        }

        $user->enviarPedidoAmizade($amigo);

        return response()->json(['message' => 'Pedido de amizade enviado com sucesso']);
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
            // Rejeitar o pedido de amizade
            $pedido->delete();
            // Devolve a lista de pedidos atualizada

            $pedidos = $this->obterPedidosPendentes();

            return response()->json([
                'message' => 'Pedido de amizade rejeitado com sucesso',
                'pedidos' => $pedidos,
                
            ]);
        }else {
            // Aceitar o pedido de amizade
            $pedido->status = 1;
            $pedido->save();

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
    }

    // removerAmigo
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
                    'tipo' => 'recebido',
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
                    'tipo' => 'enviado',
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

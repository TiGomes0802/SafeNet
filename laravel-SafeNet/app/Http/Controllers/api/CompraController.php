<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;
use App\Services\GeradorMissoesUtilizadorService;
use \App\Models\UserMissao;

class CompraController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $compras = Compra::where('idUser', $user->id)
            ->with('produto')
            ->get();

        return response()->json($compras);
    }

    public function comprar($idProduto)
    {
        $user = Auth::user();
        $produto = Produto::findOrFail($idProduto);

        if ($user->moedas < $produto->preco) {
            return response()->json(['message' => 'Moedas insuficientes.'], 400);
        }

        if ($produto->idTipoProduto == 3) {
            $missoesNaoConcluidas = UserMissao::where('idUser', $user->id)
                ->where('concluida', false)
                ->whereHas('missao', function($query) {
                    $query->where('tipo', 'missao');
                })
                ->count();

            $limiteMaximo = 5;

            if ($missoesNaoConcluidas >= $limiteMaximo) {
                return response()->json([
                    'message' => 'Já atingiste o limite máximo de missões em aberto (5). Conclui algumas para poder comprar mais!'
                ], 400);
            }
        }

        DB::beginTransaction();

        try {
            // Registar a compra
            $compra = Compra::create([
                'idProduto' => $produto->id,
                'idUser' => $user->id,
            ]);

            $user->moedas -= $produto->preco;

            if ($produto->idTipoProduto == 1) {
                $compra->usado = false;
            }

            // Se for vidas
            if ($produto->idTipoProduto == 2) {
                $user->vida += $produto->valor;
            }

            // Se for missão extra (idTipoProduto == 3)
            if ($produto->idTipoProduto == 3) {
                $servico = new GeradorMissoesUtilizadorService();
                $servico->gerarPara($user, 1, true);
            }

            $compra->save();
            $user->save();

            DB::commit();

            return response()->json([
                'message' => 'Compra efetuada com sucesso!',
                'moedas' => $user->moedas,
                'vidas' => $user->vida,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Erro ao realizar compra.'], 500);
        }
    }
}

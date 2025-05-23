<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function comprar($idProduto)
    {
        $user = Auth::user();
        $produto = Produto::findOrFail($idProduto);

        if ($user->moedas < $produto->preco) {
            return response()->json(['message' => 'Moedas insuficientes.'], 400);
        }

        DB::beginTransaction();

        try {
            // Registar a compra
            Compra::create([
                'idProduto' => $produto->id,
                'idUser' => $user->id,
            ]);

            
            $user->moedas -= $produto->preco;

            // Se for vidas
            if ($produto->idTipoProduto == 2) {
                $user->vida += $produto->valor;
            }

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

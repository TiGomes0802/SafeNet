<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    /**
     * Retorna todos os produtos com o seu tipo associado.
     */
    public function index()
    {
        $produtos = Produto::with('tipoProduto')->get();

        return response()->json($produtos);
    }

    /**
     * Retorna um produto específico pelo seu ID.
     */
    public function show($id)
    {
        $produto = Produto::with('tipoProduto')->find($id);

        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        return response()->json($produto);
    }

    public function comprar($id)
    {
        $user = Auth::user();

        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        if ($user->moedas < $produto->preco) {
            return response()->json(['message' => 'Moedas insuficientes'], 400);
        }

        $user->moedas -= $produto->preco;

        // Se for produto de vidas, adiciona 5
        if ($produto->tipo_produto_id == 2) {
            $user->vidas += 5;
        }

        $user->save();

        return response()->json(['message' => 'Compra efetuada com sucesso']);
    }
}

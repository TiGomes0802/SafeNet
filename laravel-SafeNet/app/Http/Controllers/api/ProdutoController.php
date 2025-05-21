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
}

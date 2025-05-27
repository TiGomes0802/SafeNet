<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;

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


    public function alterarEstado($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        $produto->estado = $produto->estado == 1 ? 0 : 1;
        $produto->save();


        return response()->json(['success' => true, 'novo_estado' => $produto->estado], 200);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'valor' => 'required|numeric|min:0',
            'idTipoProduto' => 'required|exists:tipoProdutos,id',
        ]);

        $produto = Produto::create([
            'nome' => $validated['nome'],
            'preco' => $validated['preco'],
            'valor' => $validated['valor'],
            'idTipoProduto' => $validated['idTipoProduto'],
            'estado' => 0,
        ]);

        return response()->json($produto, 201);
    }
}

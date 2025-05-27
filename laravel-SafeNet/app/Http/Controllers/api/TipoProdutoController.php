<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TipoProduto;

class TipoProdutoController extends Controller
{
    public function index()
    {
        return response()->json(TipoProduto::all());
    }
}

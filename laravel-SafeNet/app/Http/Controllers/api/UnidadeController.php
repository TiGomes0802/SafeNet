<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Unidade;

class UnidadeController extends Controller
{

    public function index($idCurso)
    {
        $curso = Curso::find($idCurso);
        if (!$curso) {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }

        $unidades = $curso->unidades;
        return response()->json($unidades);
    }

    public function show($idCurso, $idUnidade)
    {
        $curso = Curso::find($idCurso);
        if (!$curso) {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }

        // Encontra a unidade dentro do curso
        $unidade = Unidade::where('idCurso', $idCurso)->find($idUnidade);
        if (!$unidade) {
            return response()->json(['error' => 'Unidade não encontrada'], 404);
        }

        return response()->json($unidade);
    }

    public function createUnidade(Request $request, $idCurso)
    {
        $curso = Curso::find($idCurso);
        if (!$curso) {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }

        // Valida os dados recebidos
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'ordem' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $unidade = Unidade::create([
            'titulo' => $validatedData['titulo'],
            'descricao' => $validatedData['descricao'],
            'ordem' => $validatedData['ordem'],
            'status' => $validatedData['status'],
            'idCurso' => $idCurso,
        ]);

        return response()->json($unidade, 201);
    }

    public function update(Request $request, $idCurso, $idUnidade)
    {
        $curso = Curso::find($idCurso);
        if (!$curso) {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }

        $unidade = Unidade::where('idCurso', $idCurso)->find($idUnidade);
        if (!$unidade) {
            return response()->json(['error' => 'Unidade não encontrada'], 404);
        }

        // Valida os dados recebidos
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'ordem' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $unidade->update([
            'titulo' => $validatedData['titulo'],
            'descricao' => $validatedData['descricao'],
            'ordem' => $validatedData['ordem'],
            'status' => $validatedData['status'],
        ]);

        return response()->json($unidade);
    }
}
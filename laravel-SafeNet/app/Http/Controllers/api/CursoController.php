<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::with('unidades')->get();

        return response()->json($cursos);
    }

    public function show($idCurso)
    {
        $curso = Curso::with('unidades')->find($idCurso);

        if (!$curso) {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }

        return response()->json($curso);
    }


    public function createCurso(Request $request)
    {
        // Valida os dados recebidos
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $curso = Curso::create([
            'nome' => $validatedData['nome'],
            'estado' => false,
        ]);

        return response()->json($curso, 201);
    }

    public function update(Request $request, $idCurso)
    {
        $curso = Curso::find($idCurso);

        if (!$curso) {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }

        // Valida os dados recebidos
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

        $curso->update([
            'nome' => $validatedData['nome'],
            'estado' => $validatedData['estado'],
        ]);

        return response()->json($curso);
    }

    public function alterarEstado($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->estado = $curso->estado === 1 ? 0 : 1;
        $curso->save();

        return response()->json(['estado' => $curso->estado], 200);
    }
}

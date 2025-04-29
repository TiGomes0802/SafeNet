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
            'status' => 'required|boolean',
        ]);
        
        $curso = Curso::create([
            'status' => $validatedData['status'],
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
            'status' => 'required|boolean',
        ]);

        $curso->update([
            'status' => $validatedData['status'],
        ]);

        return response()->json($curso);
    }
}

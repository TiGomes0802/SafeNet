<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    public function index()
    {
        if(auth()->user()->type == 'J') {
            $cursos = Curso::with('unidades')->get();

            foreach ($cursos as $curso) {
                $primeiraPorFazerMarcada = false;

                foreach ($curso->unidades as $unidade) {
                    // Verifica na pivot se a unidade foi feita
                    $pivot = auth()->user()->unidade()->where('idUnidade', $unidade->id)->first();

                    if ($pivot && $pivot->pivot->status) {
                        $unidade->status = 1;
                    } else {
                        if (!$primeiraPorFazerMarcada) {
                            $unidade->status = 0;
                            $primeiraPorFazerMarcada = true;
                        } else {
                            $unidade->status = -1;
                        }
                    }
                }
            }

            return response()->json($cursos);
        }

        $cursos = Curso::with('unidades')->get();
        
        return response()->json($cursos);
    }

    public function show($idCurso)
    {
        if(auth()->user()->type == 'J') {
            $curso = Curso::with('unidades')->findOrFail($idCurso);

            if(!$curso) {
                return response()->json(['error' => 'Curso não encontrado'], 404);
            }

            if($curso->estado == 0) {
                return response()->json(['error' => 'Curso não está ativo'], 403);
            }

            $primeiraPorFazerMarcada = false;
            foreach ($curso->unidades as $unidade) {
                // Verifica na pivot se a unidade foi feita
                $pivot = auth()->user()->unidade()->where('idUnidade', $unidade->id)->first();

                if ($pivot && $pivot->pivot->status) {
                    $unidade->status = 1;
                } else {
                    if (!$primeiraPorFazerMarcada) {
                        $unidade->status = 0;
                        $primeiraPorFazerMarcada = true;
                    } else {
                        $unidade->status = -1;
                    }
                }
            }


            return response()->json($curso);
        }

        $curso = Curso::with('unidades')->findOrFail($idCurso);
        
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

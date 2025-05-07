<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reportsNaoVistos = Report::all()->where('estado', 0);
        $reportsVistos = Report::all()->where('estado', 1);
        
        // created_at para data e hora
        $reportsNaoVistos = $reportsNaoVistos->map(function ($report) {
            return [
                'id' => $report->id,
                'mensagem' => $report->mensagem,
                'estado' => $report->estado,
                'user' => [
                    'id' => $report->user->id,
                    'nome' => $report->user->nome,
                    'email' => $report->user->email,
                    'username' => $report->user->username,
                ],
                'idJogo' => $report->idJogo,
                'created_at' => $report->created_at->format('d-m-Y H:i:s'),
                'updated_at' => $report->updated_at->format('d-m-Y H:i:s'),
            ];
        });

        $reportsVistos = $reportsVistos->map(function ($report) {
            return [
                'id' => $report->id,
                'mensagem' => $report->mensagem,
                'estado' => $report->estado,
                'user' => [
                    'id' => $report->user->id,
                    'nome' => $report->user->nome,
                    'email' => $report->user->email,
                    'username' => $report->user->username,
                ],
                'idJogo' => $report->idJogo,
                'created_at' => $report->created_at->format('d-m-Y H:i:s'),
                'updated_at' => $report->updated_at->format('d-m-Y H:i:s'),
            ];
        });

        $reports = [
            'reportsNaoVistos' => $reportsNaoVistos,
            'reportsVistos' => $reportsVistos,
        ];

        return response()->json($reports);
    }

    public function show($id)
    {
        $report = Report::find($id);
        if ($report) {
            // created_at para data e hora
            return response()->json([
                'id' => $report->id,
                'mensagem' => $report->mensagem,
                'estado' => $report->estado,
                'user' => [
                    'id' => $report->user->id,
                    'nome' => $report->user->nome,
                    'email' => $report->user->email,
                    'username' => $report->user->username,
                ],
                'idJogo' => $report->idJogo,
                'created_at' => $report->created_at->format('d-m-Y H:i:s'),
                'updated_at' => $report->updated_at->format('d-m-Y H:i:s'),
            ], 201);
        } else {
            return response()->json(['message' => 'Report not found'], 404);
        }
    }

    public function createReport(Request $request)
    {
        $validatedData = $request->validate([
            'mensagem' => 'required|string|max:255',
            'idJogo' => 'required|integer|exists:jogos,id',
        ]);

        $report = Report::create(
            [
                'mensagem' => $validatedData['mensagem'],
                'estado' => false,
                'idUser' => auth()->user()->id,
                'idJogo' => $validatedData['idJogo'],
            ]
        );

        return response()->json($report, 201);
    }

    public function updateEstadoReport(Request $request, $id)
    {
        $report = Report::find($id);
        if ($report) {
            $report->estado = true;
            $report->save();
            return response()->json($report);
        } else {
            return response()->json(['message' => 'Report not found'], 404);
        }
    }
}

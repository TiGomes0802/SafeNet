<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\api\RespostaController;
use App\Models\Unidade;
use App\Models\Pagina;

class PaginaController extends Controller
{
    public function getPagina($idPagina)
    {
        // Verifica se a página existe
        $pagina = Pagina::find($idPagina);
        if (!$pagina) {
            return response()->json(['error' => 'Página não encontrada'], 404);
        }


        // Retorna a página em formato JSON
        return response()->json($pagina);
    }

    public function getPaginas($idUnidade)
    {
        // Verifica se a unidade existe
        $unidade = Unidade::find($idUnidade);
        if (!$unidade) {
            return response()->json(['error' => 'Unidade não encontrada'], 404);
        }

        // Obtém as páginas associadas à unidade e que estão ativas e todas as respostas(sem qualquer where) de cada página
        $paginas = Pagina::where('idUnidade', $idUnidade)
                        ->orderBy('ordem', 'asc')
                        ->get();
        
        // Verifica se existem páginas associadas à unidade
        if ($paginas->isEmpty()) {
            return response()->json(['message' => 'Nenhuma página encontrada para esta unidade'], 404);
        }

        return response()->json($paginas);
    }


    public function createPagina(Request $request, $idUnidade)
    {
        // Valida os dados da requisição
        $validatedData = $request->validate([
            'descricao' => 'required|string|max:255',
        ]);
    
        // Verifica se a unidade existe
        $unidade = Unidade::find($idUnidade);
        if (!$unidade) {
            return response()->json(['error' => 'Unidade não encontrada'], 404);
        }
    
        // Verifica se a unidade tem páginas
        $paginas = Pagina::where('idUnidade', $idUnidade)->get();
        if ($paginas->isEmpty()) {
            $ordem = 1;
        } else {
            // Ordena as páginas por ordem e pega a última
            $ultimaPagina = $paginas->sortByDesc('ordem')->first();
            $ordem = $ultimaPagina->ordem + 1;
        }
    
        // Cria a página
        $pagina = Pagina::create([
            'descricao' => $validatedData['descricao'],
            'ordem' => $ordem,
            'idUnidade' => $idUnidade,
        ]);
    
        // Verifica se a página foi criada com sucesso
        if (!$pagina) {
            return response()->json(['error' => 'Erro ao criar a página'], 500);
        }
    
        // Retorna a página criada com status 201 (Criado)
        return response()->json($pagina, 201);
    }
    

    public function updatePaginas(Request $request)
    {
        $validatedData = $request->validate([
            'paginas' => 'required|array',
            'paginas.*.id' => 'required|exists:paginas,id',
            'paginas.*.descricao' => 'required|string|max:255',
            'paginas.*.ordem' => 'required|integer',
        ]);
        
        // Atualiza cada página com os dados fornecidos
        foreach ($validatedData['paginas'] as $paginaData) {
            $pagina = Pagina::find($paginaData['id']);
            if (!$pagina) {
                // Se não encontrar uma página, retorna erro (não necessário se já validou o id)
                return response()->json(['error' => 'Página não encontrada'], 404);
            }
        
            // Atualiza a página, mas apenas se os dados realmente mudaram
            $pagina->update([
                'descricao' => $paginaData['descricao'],
                'ordem' => $paginaData['ordem'],
            ]);
        }
        
        return response()->json(['message' => 'Páginas atualizadas com sucesso'], 200);
    }
}


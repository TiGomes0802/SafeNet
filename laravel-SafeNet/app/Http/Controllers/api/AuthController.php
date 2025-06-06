<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\GeradorMissoesUtilizadorService;
use App\Models\User;
use App\Models\Missao;
use App\Models\UserMissao;

class AuthController extends Controller
{
    use SoftDeletes;

    private function purgeExpiredTokens(){
        // Only deletes if token expired 2 hours ago
        $dateTimetoPurge = now()->subHours(2);
        
        DB::table('personal_access_tokens')
            ->where('expires_at', '<', $dateTimetoPurge)->delete();
    }

    private function revokeCurrentToken(User $user){
        $currentTokenId = $user->currentAccessToken()->id;
        $user->tokens()->where('id', $currentTokenId)->delete();
    }

    public function login(LoginRequest $request){
        $this->purgeExpiredTokens();
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        if ($user->blocked === 1) {
            return response()->json(['message' => 'User blocked'], 403);
        }

        $token = $request->user()->createToken(
            'authToken',
            ['*'],
            now()->addHours(2)
        )->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request){
        $this->purgeExpiredTokens();
        $this->revokeCurrentToken($request->user());

        return response()->json(null, 204);
    }

    public function refreshToken(Request $request){
        // Revokes current token and creates a new token
        $this->purgeExpiredTokens();
        $this->revokeCurrentToken($request->user());

        $token = $request->user()->createToken(
            'authToken',
            ['*'],
            now()->addHours(2)
        )->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->fill($request->validated());
        $user->save();
        
        if ($user->type == 'J') {
            $conquistas = Missao::where('tipo', 'conquista')->get();

            foreach ($conquistas as $conquista) {
                UserMissao::create([
                    'idUser' => $user->id,
                    'idMissao' => $conquista->id,
                    'concluida' => false,
                    'data' => null,
                ]);
            }
            $gerador = new GeradorMissoesUtilizadorService();
            $gerador->gerarPara($user);
        }

        return new UserResource($user);
    }

    public function updateMe(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nome' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $fotoAntiga = $user->foto;

        if ($request->hasFile('foto')) {
            // Apagar todas as fotos antigas com o prefixo do username
            $ficheiros = Storage::disk('public')->files('photos');
            $prefixo = $user->username . '_update_';

            foreach ($ficheiros as $ficheiro) {
                if (str_starts_with(basename($ficheiro), $prefixo)) {
                    Storage::disk('public')->delete($ficheiro);
                }
            }

            // Criar novo nome único com timestamp
            $extensao = $request->file('foto')->getClientOriginalExtension();
            $timestamp = now()->timestamp;
            $nomeFoto = $request->username . '_update_' . $timestamp . '.' . $extensao;

            $request->file('foto')->storeAs('photos', $nomeFoto, 'public');

            $user->foto = $nomeFoto;
        } elseif ($fotoAntiga && $request->username !== $user->username) {
            // Renomear se mudou o username mas manteve a foto
            $partes = explode('_update_', $fotoAntiga);
            if (count($partes) === 2) {
                $extensao = pathinfo($fotoAntiga, PATHINFO_EXTENSION);
                $novoNome = $request->username . '_update_' . pathinfo($fotoAntiga, PATHINFO_FILENAME, PATHINFO_EXTENSION) . '.' . $extensao;

                if (Storage::disk('public')->exists('photos/' . $fotoAntiga)) {
                    Storage::disk('public')->move('photos/' . $fotoAntiga, 'photos/' . $novoNome);
                    $user->foto = $novoNome;
                }
            }
        }

        // Campos normais
        $user->nome = $request->nome;
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Perfil atualizado com sucesso.',
            'data' => new UserResource($user)
        ]);
    }


    /**
     * Delete the user account
     * Soft delete the user account 
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        $user->delete();

        return response()->json(null, 204);
    }
}

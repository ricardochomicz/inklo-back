<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserGitController extends Controller
{
    public function salvarLocal(Request $request)
    {

        $login = $request->get('login');

        $client = new Client([
            'base_uri' => 'https://api.github.com/',
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json'
            ]
        ]);

        // retorna os dados do usuário
        $response = $client->request('GET', 'users/' . $login, ['verify' => false]);

        $conteudo = $response->getBody()->getContents();

        // Salva o arquivo na pasta public
        Storage::disk('public')->put("user-{$login}.json", json_encode($conteudo));

        return response()->json(['mensagem' => 'Usuário salvo com sucesso!']);
    }
}

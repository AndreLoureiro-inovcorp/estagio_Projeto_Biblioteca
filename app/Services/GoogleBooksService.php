<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleBooksService
{
    private const API_URL = 'https://www.googleapis.com/books/v1/volumes';

    public function pesquisarLivros($termoPesquisa, $numeroMaximoResultados = 10)
    {

        try {
            $respostaApi = Http::get(self::API_URL, [
                'q' => $termoPesquisa,
                'maxResults' => $numeroMaximoResultados,
            ]);

            if ($respostaApi->successful()) {
                $dadosRecebidos = $respostaApi->json();

                return $dadosRecebidos['items'] ?? [];

            }

            return [];

        } catch (\Exception $erro) {
            Log::error('Erro ao carregar livros da API do Google Books: '.$erro->getMessage());

            return [];
        }
    }

    public function formatarDadosLivro($dadosLivroApi)
    {
        $informacoesLivro = $dadosLivroApi['volumeInfo'] ?? [];

        // Procurar ISBN-13 (maioria dos livros tem)
        $isbn = null;
        $identificadores = $informacoesLivro['industryIdentifiers'] ?? [];

        foreach ($identificadores as $identificador) {
            if (isset($identificador['type']) && $identificador['type'] === 'ISBN_13') {
                $isbn = $identificador['identifier'];
                break;
            }
        }

        return [
            'isbn' => $isbn,
            'nome' => $informacoesLivro['title'] ?? 'Sem título',
            'editora_nome' => $informacoesLivro['publisher'] ?? null,
            'autores_nomes' => $informacoesLivro['authors'] ?? [],
            'bibliografia' => $informacoesLivro['description'] ?? null,
            'imagem_capa' => $informacoesLivro['imageLinks']['thumbnail'] ?? null,
            'disponivel' => true,
        ];
    }

    public function validarLivro($dadosLivroFormatado)
    {
        return ! empty($dadosLivroFormatado['isbn']) &&
               ! empty($dadosLivroFormatado['nome']);
    }
}

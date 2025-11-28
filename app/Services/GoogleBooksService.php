<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleBooksService
{
    private const API_URL = 'https://www.googleapis.com/books/v1/volumes';

    public function pesquisarLivros($termoPesquisa)
    {

        $respostaApi = Http::get(self::API_URL, [
            'q' => $termoPesquisa,
            'key' => config('services.google_books.api_key'),
        ]);

        if ($respostaApi->successful()) {
            $dadosRecebidos = $respostaApi->json();

            return $dadosRecebidos['items'] ?? [];

        }

        return [];

    }

    public function formatarDadosLivro($dadosLivroApi)
    {
        $informacoesLivro = $dadosLivroApi['volumeInfo'] ?? [];

        $informacoesVenda = $dadosLivroApi['saleInfo'] ?? [];
        $informacoesPreco = $informacoesVenda['listPrice'] ?? [];

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
            'preco' => $informacoesPreco['amount'] ?? null,
        ];
    }

    public function validarLivro($dadosLivroFormatado)
    {
        return ! empty($dadosLivroFormatado['isbn']) &&
               ! empty($dadosLivroFormatado['nome']);
    }
}

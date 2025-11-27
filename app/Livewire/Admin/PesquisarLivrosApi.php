<?php

namespace App\Livewire\Admin;

use App\Models\Autor;
use App\Models\Editora;
use App\Models\Livro;
use App\Services\GoogleBooksService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PesquisarLivrosApi extends Component
{
    public $termoPesquisa = '';

    public $resultados = [];

    public function pesquisar()
    {
        $this->validate([
            'termoPesquisa' => 'required',
        ], [
            'termoPesquisa.required' => 'Escreve o título de um livro ou autor.',
        ]);

        $servico = new GoogleBooksService;

        $livrosDaApi = $servico->pesquisarLivros($this->termoPesquisa);

        $this->resultados = [];

        foreach ($livrosDaApi as $livro) {
            $livroFormatado = $servico->formatarDadosLivro($livro);

            if ($servico->validarLivro($livroFormatado)) {
                $this->resultados[] = $livroFormatado;
            }
        }

        if (empty($this->resultados)) {
            session()->flash('message', 'Nenhum livro encontrado para "'.$this->termoPesquisa.'".');
        }
    }

    public function limpar()
    {
        $this->reset(['termoPesquisa', 'resultados']);
    }

    public function importarLivro($index)
    {
        $dadosLivro = $this->resultados[$index];

        // Se já existe, parar
        if (Livro::where('isbn', $dadosLivro['isbn'])->exists()) {
            session()->flash('error', 'Este livro já foi importado!');

            return;
        }

        try {

            // 1. Criar/editora se existir nome
            $editoraId = null;
            if (! empty($dadosLivro['editora_nome'])) {
                $editora = Editora::firstOrCreate(['nome' => $dadosLivro['editora_nome']]);
                $editoraId = $editora->id;
            }

            // 2. Criar autores
            $autoresIds = [];
            foreach ($dadosLivro['autores_nomes'] as $nomeAutor) {
                $autor = Autor::firstOrCreate(['nome' => $nomeAutor]);
                $autoresIds[] = $autor->id;
            }

            // 3. Criar o livro
            $livro = Livro::create([
                'isbn' => $dadosLivro['isbn'],
                'nome' => $dadosLivro['nome'],
                'editora_id' => $editoraId,
                'bibliografia' => $dadosLivro['bibliografia'],
                'imagem_capa' => $dadosLivro['imagem_capa'],
                'disponivel' => true,
                'preco' => $dadosLivro['preco'],
            ]);

            // 4. Associar autores
            if (! empty($autoresIds)) {
                $livro->autores()->attach($autoresIds);
            }

            session()->flash('success', 'Livro importado com sucesso!');

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao importar livro.');
        }
    }

    public function render()
    {
        return view('livewire.admin.pesquisar-livros-api');
    }
}

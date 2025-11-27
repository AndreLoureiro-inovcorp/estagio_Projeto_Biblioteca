<?php

namespace App\Livewire\Admin;


use App\Services\GoogleBooksService;
use Livewire\Attributes\Layout;
use Livewire\Component;

use App\Models\Autor;
use App\Models\Editora;
use App\Models\Livro;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class PesquisarLivrosApi extends Component
{
    public $termoPesquisa = '';

    public $resultados = [];

    public $carregando = false;

    public function pesquisar()
    {
        $this->validate([
            'termoPesquisa' => 'required|min:3',
        ], [
            'termoPesquisa.required' => 'Escreve um titulo ou autor',
            'termoPesquisa.min' => 'Digite pelo menos 3 caracteres',
        ]);

        $this->carregando = true;

        $servico = new GoogleBooksService;
        $livrosDaApi = $servico->pesquisarLivros($this->termoPesquisa);

        $this->resultados = collect($livrosDaApi)
            ->map(function ($livro) use ($servico) {
                return $servico->formatarDadosLivro($livro);
            })
            ->filter(function ($livro) use ($servico) {
                return $servico->validarLivro($livro);
            })
            ->toArray();

        $this->carregando = false;

        if (empty($this->resultados)) {
            session()->flash('message', 'Nenhum livro encontrado para "'.$this->termoPesquisa.'"');
        }
    }

    public function limpar()
    {
        $this->reset(['termoPesquisa', 'resultados']);
    }

    public function importarLivro($index)
    {
        $dadosLivro = $this->resultados[$index];

        if (Livro::where('isbn', $dadosLivro['isbn'])->exists()) {
            session()->flash('error', 'Este livro já foi importado!');

            return;
        }

        try {
            DB::transaction(function () use ($dadosLivro) {

                $editoraId = null;
                if (! empty($dadosLivro['editora_nome'])) {
                    $editora = Editora::firstOrCreate(
                        ['nome' => $dadosLivro['editora_nome']]
                    );
                    $editoraId = $editora->id;
                }

                $autoresIds = [];
                foreach ($dadosLivro['autores_nomes'] as $nomeAutor) {
                    $autor = Autor::firstOrCreate(['nome' => $nomeAutor]);
                    $autoresIds[] = $autor->id;
                }

                $livro = Livro::create([
                    'isbn' => $dadosLivro['isbn'],
                    'nome' => $dadosLivro['nome'],
                    'editora_id' => $editoraId,
                    'bibliografia' => $dadosLivro['bibliografia'],
                    'imagem_capa' => $dadosLivro['imagem_capa'],
                    'disponivel' => true,
                    'preco' => null,
                ]);

                if (! empty($autoresIds)) {
                    $livro->autores()->attach($autoresIds);
                }
            });

            session()->flash('success', 'Livro importado com sucesso!');

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao importar livro: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.pesquisar-livros-api');
    }
}

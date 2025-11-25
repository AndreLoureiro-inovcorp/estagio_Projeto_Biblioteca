<?php

namespace App\Livewire\Admin;

use App\Services\GoogleBooksService;
use Livewire\Attributes\Layout;
use Livewire\Component;

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
        $livrosDaApi = $servico->pesquisarLivros($this->termoPesquisa, 20);

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

    public function render()
    {
        return view('livewire.admin.pesquisar-livros-api');
    }
}

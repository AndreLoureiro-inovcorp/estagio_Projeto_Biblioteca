<?php

namespace App\Livewire\Biblioteca;

use App\Models\Livro;
use App\Models\Autor;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Exports\LivrosExport;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.app')]

class Livros extends Component
{

    public $autores = [];
    public $autorSelecionado = '';
    public $pesquisa = '';
    public $ordenarPorNome = '';

    public function mount()
    {
        // carregar lista de autores para o dropdown
        $this->autores = Autor::orderBy('nome')->get();
    }

    public function exportar()
    {
        return Excel::download(new LivrosExport, 'livros_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function render()
    {

        $query = Livro::with(['autores', 'editora']);

        // Filtro por autor
        if ($this->autorSelecionado) {
            $query->whereHas('autores', function ($q) {
                $q->where('autores.id', $this->autorSelecionado);
            });
        }

        // Filtro por nome do livro
        if ($this->pesquisa) {
            $query->where('nome', 'like', '%' . $this->pesquisa . '%');
        }

        // Ordenação por nome se o utilizador escolher
        if ($this->ordenarPorNome === 'asc') {
            $query->orderBy('nome', 'asc');
        } elseif ($this->ordenarPorNome === 'desc') {
            $query->orderBy('nome', 'desc');
        }


        $livros = $query->get();

        return view('livewire.livros', [
            'livros' => $livros,
        ]);
    }
}

<?php

namespace App\Livewire\Biblioteca\livros;

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
        $this->autores = Autor::orderBy('nome')->get();
    }

    public function exportar()
    {
        return Excel::download(new LivrosExport, 'livros_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function render()
    {

        $query = Livro::with(['autores', 'editora']);


        if ($this->autorSelecionado) {
            $query->whereHas('autores', function ($q) {
                $q->where('autores.id', $this->autorSelecionado);
            });
        }

        if ($this->pesquisa) {
            $query->where('nome', 'like', '%' . $this->pesquisa . '%');
        }

        if ($this->ordenarPorNome === 'asc') {
            $query->orderBy('nome', 'asc');
        } elseif ($this->ordenarPorNome === 'desc') {
            $query->orderBy('nome', 'desc');
        }


        $livros = $query->get();

        return view('livewire.biblioteca.livros.livros', [
            'livros' => $livros,
        ]);
    }
}

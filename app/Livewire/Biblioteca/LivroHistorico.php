<?php

namespace App\Livewire\Biblioteca;

use App\Models\Livro;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class LivroHistorico extends Component
{
    public $livro;

    public function mount($livro)
    {
        $this->livro = Livro::with([
            'editora',
            'autores',
            'historicoRequisicoes.user',
        ])->findOrFail($livro);
    }

    public function render()
    {
        return view('livewire.biblioteca.livro-historico');
    }
}

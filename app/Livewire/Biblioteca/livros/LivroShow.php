<?php

namespace App\Livewire\Biblioteca\livros;

use App\Models\Livro;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class LivroShow extends Component
{
    public Livro $livro;

    public function mount(Livro $livro)
    {
        $this->livro = $livro;
    }

    public function render()
    {
        $livrosRelacionados = $this->livro->livrosRelacionados(3);

        return view('livewire.biblioteca.livros.livro-show', [
            'livrosRelacionados' => $livrosRelacionados,
        ]);
    }
}

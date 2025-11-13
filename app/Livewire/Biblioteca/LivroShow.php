<?php

namespace App\Livewire\Biblioteca;

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
        return view('livewire.livro-show');
    }
}


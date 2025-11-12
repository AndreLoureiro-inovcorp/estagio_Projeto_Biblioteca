<?php

namespace App\Livewire\Livro;

use App\Models\Livro;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Livros extends Component
{
    public $livros;
    
    public function mount()
    {
        $this->livros = Livro::with('autores', 'editora')->get();
    }

    public function render()
    {
        return view('livewire.livros');
    }
}

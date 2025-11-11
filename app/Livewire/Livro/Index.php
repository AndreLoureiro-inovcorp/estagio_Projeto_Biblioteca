<?php

namespace App\Livewire\Livro;

use App\Models\Livro;
use Livewire\Component;

class Index extends Component
{
    public $livros;
    
    public function mount()
    {
        $this->livros = Livro::with('autores', 'editora')->get();
    }

    public function render()
    {
        return view('livewire.livro.index');
    }
}

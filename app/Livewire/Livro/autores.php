<?php

namespace App\Livewire\Livro;

use App\Models\Autor;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Autores extends Component
{
    public $autores;

    public function mount()
    {
        $this->autores = Autor::with('livros')->get();
    }
    public function render()
    {
        return view('livewire.autores');
    }
}

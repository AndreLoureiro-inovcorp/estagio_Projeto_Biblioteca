<?php

namespace App\Livewire\Livro;

use App\Models\Editora;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Editoras extends Component
{
    public $editoras;

    public function mount()
    {
        $this->editoras = Editora::with('livros')->get();
    }
    public function render()
    {
        return view('livewire.editoras');
    }
}

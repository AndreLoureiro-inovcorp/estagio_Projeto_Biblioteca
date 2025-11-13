<?php

namespace App\Livewire\Biblioteca;

use App\Models\Editora;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Editoras extends Component
{
    public $pesquisa = '';
    public $ordenarPorNome = '';

    public function render()
    {
        $query = Editora::query();

        if ($this->pesquisa) {
            $query->where('nome', 'like', '%' . $this->pesquisa . '%');
        }

        if ($this->ordenarPorNome === 'asc') {
            $query->orderBy('nome', 'asc');
        } elseif ($this->ordenarPorNome === 'desc') {
            $query->orderBy('nome', 'desc');
        }

        return view('livewire.editoras', [
            'editoras' => $query->with('livros')->get()
        ]);
    }
}

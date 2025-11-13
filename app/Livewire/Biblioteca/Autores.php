<?php

namespace App\Livewire\Biblioteca;

use App\Models\Autor;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Autores extends Component
{
    public $pesquisa = '';
    public $ordenarPorNome = '';

    public function render()
    {
        $query = Autor::query();

        if ($this->pesquisa) {
            $query->where('nome', 'like', '%' . $this->pesquisa . '%');
        }

        if ($this->ordenarPorNome === 'asc') {
            $query->orderBy('nome', 'asc');
        } elseif ($this->ordenarPorNome === 'desc') {
            $query->orderBy('nome', 'desc');
        }

        return view('livewire.autores', [
            'autores' => $query->with('livros')->get()
        ]);
    }
}

<?php

namespace App\Livewire\Biblioteca\Admin;

use App\Models\Encomenda;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class GerirEncomendas extends Component
{
    use WithPagination;

    public function render()
    {
        $encomendas = Encomenda::with(['user', 'itens.livro'])->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.biblioteca.admin.gerir-encomendas', [
            'encomendas' => $encomendas,
        ]);
    }
}

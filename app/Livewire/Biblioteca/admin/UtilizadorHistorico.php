<?php

namespace App\Livewire\Biblioteca\admin;

use App\Models\Requisicao;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class UtilizadorHistorico extends Component
{
    public $utilizador;

    public $requisicoes;

    public function mount(User $utilizador)
    {
        $this->utilizador = $utilizador;
        $this->requisicoes = Requisicao::where('user_id', $utilizador->id)
            ->with(['livro.editora', 'livro.autores'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.biblioteca.admin.utilizador-historico');
    }
}

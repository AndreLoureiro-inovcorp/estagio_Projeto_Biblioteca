<?php

namespace App\Livewire\Biblioteca;

use App\Models\Requisicao;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Requisicoes extends Component
{

    public function render()
    {
        $utilizador = Auth::user();
        if (! $utilizador) {
            return redirect()->route('login');
        }

        $isCidadao = $utilizador->hasRole('cidadao');
        $isAdmin = $utilizador->hasRole('admin');

        $query = Requisicao::with(['user', 'livro.editora', 'livro.autores'])
            ->orderBy('created_at', 'desc');

        if ($isCidadao) {
            $query->where('user_id', $utilizador->id);
        }

        $requisicoes = $query->get();

        return view('livewire.biblioteca.requisicoes.requisicoes', compact('requisicoes', 'isAdmin', 'isCidadao'));
    }
}

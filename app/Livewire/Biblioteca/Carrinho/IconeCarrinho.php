<?php

namespace App\Livewire\Biblioteca\Carrinho;

use Livewire\Component;
use Livewire\Attributes\On;

class IconeCarrinho extends Component
{
    public $totalItens = 0;

    public function mount()
    {
        $this->atualizarTotal();
    }

    #[On('carrinho-atualizado')]
    public function atualizarTotal()
    {
        if (auth()->check()) {
            $this->totalItens = auth()->user()->totalItensCarrinho();
        } else {
            $this->totalItens = 0;
        }
    }

    public function render()
    {
        return view('livewire.biblioteca.carrinho.icone-carrinho');
    }
}

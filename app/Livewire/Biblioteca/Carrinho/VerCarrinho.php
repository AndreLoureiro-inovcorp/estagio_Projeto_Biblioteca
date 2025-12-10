<?php

namespace App\Livewire\Biblioteca\Carrinho;

use App\Models\CarrinhoItem;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class VerCarrinho extends Component
{
    public $itensCarrinho;

    public $totalCarrinho = 0;

    public function mount()
    {
        $this->carregarCarrinho();
    }

    public function carregarCarrinho()
    {
        $this->itensCarrinho = CarrinhoItem::where('user_id', auth()->id())->with(['livro.editora', 'livro.autores'])->get();

        $this->calcularTotal();
    }

    public function calcularTotal()
    {
        $this->totalCarrinho = $this->itensCarrinho->sum(
            fn ($item) => $item->quantidade * $item->livro->preco
        );
    }

    public function atualizarQuantidade($itemId, $quantidade)
    {
        $item = CarrinhoItem::findOrFail($itemId);

        if ($item->user_id !== auth()->id()) {
            return;
        }

        $quantidade = max(1, intval($quantidade));

        $item->update(['quantidade' => $quantidade]);

        $this->carregarCarrinho();

        $this->dispatch('carrinho-atualizado');
    }

    public function removerItem($itemId)
    {
        $item = CarrinhoItem::findOrFail($itemId);

        if ($item->user_id !== auth()->id()) {
            return;
        }

        $item->delete();

        $this->carregarCarrinho();

    }

    public function render()
    {
        return view('livewire.biblioteca.carrinho.ver-carrinho');
    }
}

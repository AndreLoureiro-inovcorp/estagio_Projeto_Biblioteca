<?php

namespace App\Livewire\Biblioteca\Carrinho;

use App\Models\CarrinhoItem;
use App\Models\Livro;
use Livewire\Component;

class AdicionarAoCarrinho extends Component
{
    public $livroId;

    public function mount($livroId)
    {
        $this->livroId = $livroId;
    }

    public function adicionar()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $livro = Livro::findOrFail($this->livroId);

        $item = CarrinhoItem::where('user_id', auth()->id())->where('livro_id', $livro->id)->first();

        if ($item) {
            $item->increment('quantidade');
        } else {
            CarrinhoItem::create([
                'user_id' => auth()->id(),
                'livro_id' => $livro->id,
                'quantidade' => 1,
            ]);
        }

        $this->dispatch('carrinho-atualizado');

        return redirect()->route('livros.show', $livro->id)->with('sucesso', 'Livro adicionado ao carrinho!');
    }

    public function render()
    {
        $livro = Livro::findOrFail($this->livroId);

        return view('livewire.biblioteca.carrinho.adicionar-ao-carrinho', [
            'livro' => $livro,
        ]);
    }
}


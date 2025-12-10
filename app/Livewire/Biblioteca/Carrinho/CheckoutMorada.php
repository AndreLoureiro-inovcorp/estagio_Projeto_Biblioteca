<?php

namespace App\Livewire\Biblioteca\Carrinho;

use App\Models\CarrinhoItem;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CheckoutMorada extends Component
{
    public $nome_completo = '';

    public $morada = '';

    public $cidade = '';

    public $codigo_postal = '';

    public $pais = '';

    public $telefone = '';

    public $itensCarrinho;

    public $totalCarrinho = 0;

    protected $rules = [
        'nome_completo' => 'required|string|min:3|max:255',
        'morada' => 'required|string|min:5|max:500',
        'cidade' => 'required|string|min:2|max:100',
        'codigo_postal' => 'required|string|regex:/^\d{4}-\d{3}$/',
        'pais' => 'required|string|max:100',
        'telefone' => 'required|string|regex:/^[0-9]{9}$/',
    ];

    protected $messages = [
        'nome_completo.required' => 'O nome completo é obrigatório.',
        'morada.required' => 'A morada é obrigatória.',
        'cidade.required' => 'A cidade é obrigatória.',
        'codigo_postal.required' => 'O código postal é obrigatório.',
        'codigo_postal.regex' => 'Formato inválido.',
        'pais.required' => 'O país é obrigatório.',
        'telefone.required' => 'O telefone é obrigatório.',
        'telefone.regex' => 'O telefone deve ter 9 dígitos.',
    ];

    public function mount()
    {
        $this->itensCarrinho = CarrinhoItem::where('user_id', auth()->id())->with('livro')->get();

        if ($this->itensCarrinho->isEmpty()) {
            session()->flash('error', 'O teu carrinho está vazio!');

            return redirect()->route('carrinho.ver');
        }

        $this->totalCarrinho = $this->itensCarrinho
            ->sum(fn ($item) => $item->quantidade * $item->livro->preco);

        $this->nome_completo = auth()->user()->name ?? '';
    }

    public function continuar()
    {
        $this->validate();

        session([
            'checkout_morada' => [
                'nome_completo' => $this->nome_completo,
                'morada' => $this->morada,
                'cidade' => $this->cidade,
                'codigo_postal' => $this->codigo_postal,
                'pais' => $this->pais,
                'telefone' => $this->telefone,
            ],
        ]);

        return redirect()->route('checkout.pagamento');
    }

    public function voltarCarrinho()
    {
        return redirect()->route('carrinho.ver');
    }

    public function render()
    {
        return view('livewire.biblioteca.carrinho.checkout-morada');
    }
}

<?php

namespace App\Livewire\Biblioteca\Carrinho;

use App\Models\CarrinhoItem;
use App\Models\Encomenda;
use App\Models\EncomendaItem;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use App\Services\LogService;

#[Layout('layouts.app')]
class CheckoutPagamento extends Component
{
    public $itensCarrinho;

    public $totalCarrinho = 0;

    public $moradaEntrega;

    public $clientSecret;

    public function mount()
    {
        if (! session()->has('checkout_morada')) {
            session()->flash('error', 'Por favor, preenche a morada de entrega primeiro.');

            return redirect()->route('checkout.morada');
        }

        $this->itensCarrinho = CarrinhoItem::where('user_id', auth()->id())->with('livro')->get();

        if ($this->itensCarrinho->isEmpty()) {
            session()->flash('error', 'O teu carrinho está vazio!');

            return redirect()->route('carrinho.ver');
        }

        $this->totalCarrinho = $this->itensCarrinho->sum(function ($item) {
            return $item->quantidade * $item->livro->preco;
        });

        $this->moradaEntrega = session('checkout_morada');

        $this->criarPaymentIntent();
    }

    public function criarPaymentIntent()
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $this->totalCarrinho * 100,
                'currency' => 'eur',
                'description' => 'Encomenda Biblioteca - '.auth()->user()->name,
            ]);

            $this->clientSecret = $paymentIntent->client_secret;

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao iniciar pagamento.');
        }
    }

    public function processarPagamento($paymentIntentId)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status === 'succeeded') {

                $encomenda = $this->criarEncomenda($paymentIntent);

                CarrinhoItem::where('user_id', auth()->id())->delete();
                session()->forget('checkout_morada');

                return redirect()->route('livros.index', [
                    'encomenda' => $encomenda->id,
                ]);
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro ao processar o pagamento.');
        }
    }

    private function criarEncomenda($paymentIntent)
    {
        $numeroEncomenda = Encomenda::gerarNumeroEncomenda();

        $encomenda = Encomenda::create([
            'numero_encomenda' => $numeroEncomenda,
            'user_id' => auth()->id(),
            'nome_completo' => $this->moradaEntrega['nome_completo'],
            'morada' => $this->moradaEntrega['morada'],
            'cidade' => $this->moradaEntrega['cidade'],
            'codigo_postal' => $this->moradaEntrega['codigo_postal'],
            'pais' => $this->moradaEntrega['pais'],
            'telefone' => $this->moradaEntrega['telefone'],
            'valor_total' => $this->totalCarrinho,
            'estado' => 'paga',
            'stripe_payment_intent_id' => $paymentIntent->id,
        ]);

        foreach ($this->itensCarrinho as $item) {
            EncomendaItem::create([
                'encomenda_id' => $encomenda->id,
                'livro_id' => $item->livro_id,
                'quantidade' => $item->quantidade,
                'preco_unitario' => $item->livro->preco,
                'subtotal' => $item->quantidade * $item->livro->preco,
            ]);
        }

        return $encomenda;
    }

    public function voltarMorada()
    {
        return redirect()->route('checkout.morada');
    }

    public function render()
    {
        return view('livewire.biblioteca.carrinho.checkout-pagamento');
    }
}

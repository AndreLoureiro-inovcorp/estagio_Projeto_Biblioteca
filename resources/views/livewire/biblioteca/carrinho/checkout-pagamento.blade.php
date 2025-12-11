<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Checkout - Pagamento
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        @if (session()->has('error'))
        <div class="alert alert-error shadow-lg mb-4">
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 sticky top-4">

                    <h3 class="text-lg font-semibold mb-4">Resumo do Pedido</h3>

                    <div class="space-y-3 mb-4">
                        @foreach($itensCarrinho as $item)
                        <div class="flex gap-3 text-sm">
                            <img src="{{ Str::startsWith($item->livro->imagem_capa, 'http') ? $item->livro->imagem_capa : Storage::url($item->livro->imagem_capa) }}" alt="{{ $item->livro->nome }}" class="w-12 h-16 object-cover rounded" />

                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 truncate">{{ $item->livro->nome }}</p>
                                <p class="text-gray-600">Qtd: {{ $item->quantidade }}</p>
                                <p class="text-gray-900 font-semibold">
                                    {{ number_format($item->quantidade * $item->livro->preco, 2, ',', '.') }} €
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="divider"></div>

                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold">Total:</span>
                        <span class="text-2xl font-bold text-blue-600">
                            {{ number_format($totalCarrinho, 2, ',', '.') }} €
                        </span>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                    <div class="mb-6 p-4 bg-gray-50 rounded">
                        <h4 class="font-semibold mb-2">Enviar para:</h4>

                        <p class="text-sm text-gray-700 leading-relaxed">
                            {{ $moradaEntrega['nome_completo'] }}<br>
                            {{ $moradaEntrega['morada'] }}<br>
                            {{ $moradaEntrega['codigo_postal'] }} {{ $moradaEntrega['cidade'] }}<br>
                            {{ $moradaEntrega['pais'] }}<br>
                            Tel: {{ $moradaEntrega['telefone'] }}
                        </p>

                        <button wire:click="voltarMorada" class="px-3 py-1 mt-3 text-sm bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                            Alterar Morada
                        </button>
                    </div>

                    <div class="divider"></div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Dados do Cartão</h3>

                        @if($clientSecret)
                        <div id="payment-form">
                            <div id="card-element" class="p-4 border border-gray-300 rounded mb-4"></div>

                            <div id="card-errors" role="alert" class="text-error text-sm mb-4"></div>

                            <button id="submit-payment" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Pagar {{ number_format($totalCarrinho, 2, ',', '.') }} €
                            </button>
                        </div>
                        @else
                        <div class="alert alert-error mt-4">
                            <span>Erro ao carregar sistema de pagamento. Por favor, tenta novamente.</span>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const stripe = Stripe('{{ config("services.stripe.key") }}');
            const clientSecret = '{{ $clientSecret }}';

            if (!clientSecret) return;

            const elements = stripe.elements();
            const cardElement = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px'
                        , color: '#32325d'
                        , '::placeholder': {
                            color: '#aab7c4'
                        }
                    }
                    , invalid: {
                        color: '#fa755a'
                        , iconColor: '#fa755a'
                    }
                }
            });

            cardElement.mount('#card-element');

            const submitButton = document.getElementById('submit-payment');

            submitButton.addEventListener('click', async function(e) {
                e.preventDefault();

                submitButton.disabled = true;
                submitButton.textContent = 'A processar...';

                const {
                    error
                    , paymentIntent
                } = await stripe.confirmCardPayment(clientSecret, {
                    payment_method: {
                        card: cardElement
                    }
                });

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Pagar';
                } else {
                    @this.call('processarPagamento', paymentIntent.id);
                }
            });
        });

    </script>
    @endpush
</div>

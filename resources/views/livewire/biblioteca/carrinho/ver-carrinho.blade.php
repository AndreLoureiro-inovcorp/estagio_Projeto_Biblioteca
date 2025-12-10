<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Carrinho
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        @if($itensCarrinho->isEmpty())
        <div class="bg-white shadow-xl sm:rounded-lg p-10 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">O teu carrinho está vazio</h3>
            <p class="text-gray-500 mb-6">Adiciona alguns livros para começar!</p>
            <a href="{{ route('livros.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Ver Livros
            </a>
        </div>

        @else

        <div class="bg-white shadow-xl sm:rounded-lg">

            <ul class="list bg-white rounded-xl divide-y divide-gray-200">

                @foreach($itensCarrinho as $item)
                <li class="list-row p-6 gap-6">

                    <a href="{{ route('livros.show', $item->livro->id) }}">
                        <img class="w-24 h-36 rounded-md object-cover shadow" src="{{ Str::startsWith($item->livro->imagem_capa, 'http')? $item->livro->imagem_capa: Storage::url($item->livro->imagem_capa) }}" />
                    </a>

                    <div class="flex-1 min-w-0">
                        <a href="{{ route('livros.show', $item->livro->id) }}" class="text-lg font-semibold text-gray-900 hover:text-blue-600">
                            {{ $item->livro->nome }}
                        </a>

                        <p class="text-sm text-gray-600">
                            {{ $item->livro->autores->pluck('nome')->join(', ') }}
                        </p>

                        <p class="text-xl font-bold text-primary mt-2">
                            €{{ number_format($item->livro->preco, 2, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex flex-col items-end gap-3">

                        <select class="border rounded-lg py-1 px-2 text-sm w-20" wire:change="atualizarQuantidade({{ $item->id }}, $event.target.value)">
                            @for($i = 1; $i <= 10; $i++) <option value="{{ $i }}" @selected($i==$item->quantidade)>{{ $i }}</option>
                                @endfor
                        </select>

                        <p class="text-sm text-gray-700">
                            Subtotal:
                            <span class="font-semibold">
                                €{{ number_format($item->quantidade * $item->livro->preco, 2, ',', '.') }}
                            </span>
                        </p>

                        <button wire:click="removerItem({{ $item->id }})" class="border border-red-500 text-red-600 px-3 py-1 text-xs rounded-lg hover:bg-red-50 transition">
                            Remover
                        </button>

                    </div>

                </li>
                @endforeach

            </ul>

            <div class="p-6 bg-gray-50 border-t border-gray-200">

                <div class="flex justify-end items-center mb-6 gap-4">
                    <span class="text-xl font-semibold text-gray-700">Total:</span>

                    <span class="text-3xl font-bold text-primary">
                        €{{ number_format($totalCarrinho, 2, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between flex-col sm:flex-row gap-3">

                    <a href="{{ route('livros.index') }}" class="border px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition text-center">
                        ← Voltar
                    </a>

                    <a href="{{ route('checkout.morada') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-700 transition">
                        Finalizar Compra
                    </a>

                </div>
            </div>

        </div>

        @endif

    </div>
</div>

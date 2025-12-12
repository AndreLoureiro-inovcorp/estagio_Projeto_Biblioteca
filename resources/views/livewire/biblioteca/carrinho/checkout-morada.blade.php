<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Checkout
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div>
                <div class="bg-white shadow-xl rounded-lg p-6 sticky top-4">

                    <h3 class="text-lg font-semibold mb-4">Resumo do Pedido</h3>

                    <div class="space-y-3 mb-4">
                        @foreach($itensCarrinho as $item)
                        <div class="flex gap-3 text-sm">
                            <img src="{{ Str::startsWith($item->livro->imagem_capa, 'http')
                                    ? $item->livro->imagem_capa
                                    : Storage::url($item->livro->imagem_capa) }}" class="w-12 h-16 object-cover rounded" />

                            <div class="flex-1">
                                <p class="font-medium truncate">{{ $item->livro->nome }}</p>
                                <p class="text-gray-600">Qtd: {{ $item->quantidade }}</p>
                                <p class="font-semibold">
                                    {{ number_format($item->livro->preco * $item->quantidade, 2, ',', '.') }} €
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="divider"></div>

                    <div class="flex items-center gap-2">
                        <span class="text-lg font-semibold">Total: </span>
                        <span class="text-2xl font-bold text-blue-600">
                            {{ number_format($totalCarrinho, 2, ',', '.') }} €
                        </span>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white shadow-xl rounded-lg p-6">

                    <h3 class="text-lg font-semibold mb-6">Dados de Entrega</h3>

                    <form wire:submit.prevent="continuar" class="space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                            <input type="text" wire:model="nome_completo" class="input input-bordered w-full @error('nome_completo') input-error @enderror" />
                            @error('nome_completo')
                            <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Morada *</label>
                            <input type="text" wire:model="morada" class="input input-bordered w-full @error('morada') input-error @enderror" />
                            @error('morada')
                            <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cidade *</label>
                                <input type="text" wire:model="cidade" class="input input-bordered w-full @error('cidade') input-error @enderror" />
                                @error('cidade')
                                <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Código Postal *</label>
                                <input type="text" wire:model="codigo_postal" class="input input-bordered w-full @error('codigo_postal') input-error @enderror" maxlength="8" />
                                @error('codigo_postal')
                                <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">País *</label>
                                <input type="text" wire:model="pais" class="input input-bordered w-full @error('pais') input-error @enderror"/>
                                @error('pais')
                                <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Telefone *</label>
                                <input type="tel" wire:model="telefone" class="input input-bordered w-full @error('telefone') input-error @enderror" maxlength="9" />
                                @error('telefone')
                                <span class="text-error text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4 justify-between">

                            <button type="button" wire:click="voltarCarrinho" class="border px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition text-center">
                                ← Voltar
                            </button>

                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-700 transition">
                                Continuar para Pagamento
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

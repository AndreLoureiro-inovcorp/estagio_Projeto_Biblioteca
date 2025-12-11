<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Gerir Encomendas
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <div class="bg-white shadow-xl sm:rounded-lg p-6">

            @if($encomendas->isEmpty())
            <div class="p-10 text-center text-gray-500">
                <p class="text-lg">Nenhuma encomenda encontrada.</p>
            </div>

            @else

            <div class="space-y-4">

                @foreach($encomendas as $encomenda)

                <div class="card bg-base-100 shadow border border-gray-200">
                    <div class="card-body">

                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">

                            <div>
                                <h3 class="text-lg font-semibold">{{ $encomenda->numero_encomenda }}</h3>

                                @if($encomenda->estado === 'paga')
                                <span class="badge badge-success">Paga</span>
                                @endif

                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $encomenda->user->name }} •
                                    {{ $encomenda->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ number_format($encomenda->valor_total, 2, ',', '.') }} €
                                </p>
                            </div>

                        </div>

                        <div class="divider my-2"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <h4 class="font-semibold mb-1">Cliente</h4>
                                <p>{{ $encomenda->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $encomenda->user->email }}</p>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-1">Morada de Entrega</h4>
                                <p>{{ $encomenda->nome_completo }}</p>
                                <p>{{ $encomenda->morada }}</p>
                                <p>{{ $encomenda->codigo_postal }} {{ $encomenda->cidade }}</p>
                                <p>{{ $encomenda->pais }}</p>
                                <p class="mt-1">{{ $encomenda->telefone }}</p>
                            </div>

                        </div>

                        <div class="divider"></div>

                        <div>
                            <h4 class="font-semibold mb-3">Livros</h4>

                            <div class="space-y-2">
                                @foreach($encomenda->itens as $item)

                                <div class="flex items-center gap-3 p-3 bg-white border rounded">
                                    <img src="{{ Str::startsWith($item->livro->imagem_capa, 'http') ? $item->livro->imagem_capa : Storage::url($item->livro->imagem_capa) }}" class="w-12 h-16 object-cover rounded">

                                    <div class="flex-1">
                                        <p class="font-semibold">{{ $item->livro->nome }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ number_format($item->preco_unitario, 2, ',', '.') }} €
                                            x {{ $item->quantidade }}
                                            =
                                            <strong>{{ number_format($item->subtotal, 2, ',', '.') }} €</strong>
                                        </p>
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach

            </div>

            <div class="mt-6">
                {{ $encomendas->links() }}
            </div>

            @endif

        </div>
    </div>
</div>

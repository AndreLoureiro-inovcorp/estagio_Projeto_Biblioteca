<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Livro: ') }}{{ $livro->nome }}
            </h2>
            @livewire('biblioteca.carrinho.icone-carrinho')
        </div>
    </x-slot>

    @if(session('sucesso'))
    <div class="max-w-4xl mx-auto mt-16 alert alert-success">
        <span>{{ session('sucesso') }}</span>
    </div>
    @endif

    <div class="max-w-4xl mx-auto mt-16 bg-base-100 shadow-md rounded-2xl px-6 py-8">
        <div class="flex flex-col sm:flex-row items-start gap-6">
            <figure class="flex-shrink-0">
                <img src="{{ Str::startsWith($livro->imagem_capa, 'http') ? $livro->imagem_capa : Storage::url($livro->imagem_capa) }}" alt="{{ $livro->nome }}" class="w-48 h-64 rounded-xl object-contain" />
            </figure>

            <div class="space-y-2 min-w-0 break-words">
                <h1 class="text-2xl font-semibold">{{ $livro->nome }}</h1>
                @if ($livro->bibliografia)
                <div>
                    <h2 class="font-semibold">Bibliografia</h2>
                    <p class="text-sm text-gray-600 break-words">{{ $livro->bibliografia }}</p>
                </div>
                @endif

                <p><strong>Editora:</strong> {{ $livro->editora->nome ?? 'N/A' }}</p>
                <p><strong>Autores:</strong>
                    @forelse ($livro->autores as $autor)
                    {{ $autor->nome }}@if (!$loop->last), @endif
                    @empty
                    <span class="italic text-gray-400">Sem autores</span>
                    @endforelse
                </p>
                <p><strong>ISBN:</strong> {{ $livro->isbn }}</p>
                <p><strong>Preço:</strong> {{ number_format($livro->preco, 2, ',', '.') }} €</p>
                <p><strong>Disponibilidade:</strong>
                    @if($livro->disponivel)
                    <span class="badge badge-success">Disponível</span>
                    @else
                    <span class="badge badge-error">Indisponível</span>
                    @endif
                </p>

                <div class="max-w-4xl mx-auto mt-6 px-4 flex justify-end gap-3">
                    @livewire('biblioteca.livros.solicitar-alerta', ['livroId' => $livro->id])

                    @livewire('biblioteca.requisitar-livro-direto', ['livroId' => $livro->id])

                    @livewire('biblioteca.carrinho.adicionar-ao-carrinho', ['livroId' => $livro->id])

                    <a href="{{ route('livros.historico', $livro->id) }}" class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium text-sm px-4 py-2 rounded transition">
                        Histórico
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="max-w-4xl mx-auto mt-6 px-4">
        <a href="{{ route('livros.index') }}" class="btn btn-outline btn-sm rounded-full">
            ← Voltar
        </a>
    </div>

    <div class="max-w-4xl mx-auto mt-14 px-4">

        <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
            Reviews deste livro:
        </h3>

        @php
        $reviewsAtivos = $livro->reviews()->ativo()->latest()->get();
        @endphp

        @if($reviewsAtivos->isEmpty())
        <div class="">
            Ainda sem Reviews!
        </div>
        @else

        <div class="space-y-6">
            @foreach($reviewsAtivos as $review)

            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="font-semibold text-gray-800">
                            {{ $review->user->name }}
                        </p>

                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $review->created_at->format('d M Y') }}
                        </p>
                    </div>

                    <div class="text-right">
                        <div class="flex text-yellow-400 text-lg justify-end">
                            {!! $review->estrelasHtml() !!}
                        </div>
                    </div>
                </div>

                <p class="mt-4 text-gray-700 leading-relaxed text-sm">
                    {{ $review->comentario }}
                </p>

            </div>
            @endforeach
        </div>
        @endif
    </div>

    @if($livrosRelacionados->isNotEmpty())
    <div class="flex justify-center mt-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($livrosRelacionados as $livroRelacionado)
            <a href="{{ route('livros.show', $livroRelacionado->id) }}" class="card bg-base-100 w-64 shadow-md rounded-2xl px-4 hover:shadow-xl transition">

                <figure class="px-4 pt-4">
                    <img src="{{ Str::startsWith($livroRelacionado->imagem_capa, 'http') ? $livroRelacionado->imagem_capa : Storage::url($livroRelacionado->imagem_capa) }}" alt="{{ $livroRelacionado->nome }}" class="rounded-xl h-48 object-contain" />
                </figure>

                <div class="card-body items-center text-center space-y-2">

                    <h2 class="card-title text-lg font-semibold">
                        {{ $livroRelacionado->nome }}
                    </h2>

                    <p class="text-sm">
                        <strong>Autores:</strong>
                        {{ $livroRelacionado->autores->pluck('nome')->join(', ') }}
                    </p>

                    <p class="text-sm">
                        <strong>Preço:</strong>
                        €{{ number_format($livroRelacionado->preco, 2, ',', '.') }}
                    </p>

                </div>
            </a>
            @endforeach

        </div>
    </div>
    @endif
</div>

<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Livro: ') }}{{ $livro->nome }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-16 bg-base-100 shadow-md rounded-2xl px-6 py-8">
        <div class="flex flex-col sm:flex-row items-start gap-6">
            <figure class="flex-shrink-0">
                <img src="{{ $livro->imagem_capa ?? 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}"
                    alt="{{ $livro->nome }}"
                    class="w-48 h-64 object-cover rounded-lg shadow-md" />
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
                <p><strong>Preço:</strong> €{{ number_format($livro->preco, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>
    <div class="max-w-4xl mx-auto mt-6 px-4">
        <a href="{{ route('livros.index') }}" class="btn btn-outline btn-sm rounded-full">
            ← Voltar
        </a>
    </div>
</div>
<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Livro: ') }}{{ $livro->nome }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8 bg-base-100 shadow-md rounded-2xl px-6 py-8">
        <figure>
            <img src="{{ $livro->imagem_capa ?? 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}"
                alt="{{ $livro->nome }}" class="w-full object-cover rounded-md mb-4 mx-auto" />
        </figure>

        <h1 class="text-2xl font-semibold mb-2">{{ $livro->nome }}</h1>
        <p><strong>ISBN:</strong> {{ $livro->isbn }}</p>
        <p><strong>Editora:</strong> {{ $livro->editora->nome ?? 'N/A' }}</p>
        <p><strong>Autores:</strong>
            @forelse ($livro->autores as $autor)
            {{ $autor->nome }}@if (!$loop->last), @endif
            @empty
            <span class="italic text-gray-400">Sem autores</span>
            @endforelse
        </p>
        <p><strong>Preço:</strong> €{{ number_format($livro->preco, 2, ',', '.') }}</p>

        @if ($livro->bibliografia)
        <div class="mt-4">
            <h2 class="font-semibold">Bibliografia</h2>
            <p class="text-sm text-gray-600">{{ $livro->bibliografia }}</p>
        </div>
        @endif
    </div>
</div>
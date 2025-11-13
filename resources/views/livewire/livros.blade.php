<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Livros Disponíveis') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 mb-6 mt-4 flex gap-4">
        <select id="author" wire:model.live="autorSelecionado"
            class="max-w-[12.5rem] w-full h-10 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-3">
            <option value="">Todos os autores</option>
            @foreach ($autores as $autor)
            <option value="{{ $autor->id }}">{{ $autor->nome }}</option>
            @endforeach
        </select>

        <select wire:model.live="ordenarPorNome"
            class="max-w-[12.5rem] w-full h-10 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-3">
            <option value=" ">Ordena por nome</option>
            <option value="asc">Ascendente (A-Z)</option>
            <option value="desc">Descendente (Z-A)</option>
        </select>

        <input type="text" wire:model.live="pesquisa" placeholder="Pesquisa por nome do livro"
            class="max-w-[12.5rem] w-full h-10 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-3">
        </input>
    </div>

    <div class="flex justify-center mt-8">
        <div wire:loading.class="opacity-50" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($livros as $livro)
            <div class="card bg-base-100 w-80 shadow-md rounded-2xl px-4 py-6">
                <figure>
                    <img src="{{ $livro->imagem_capa ?? 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}"
                        alt="{{ $livro->nome }}" class="w-full object-cover" />
                </figure>
                <div class="card-body space-y-2">
                    <h2 class="card-title text-lg font-semibold">{{ $livro->nome }}</h2>
                    <p class="text-sm"><strong>Editora:</strong> {{ $livro->editora->nome ?? 'N/A' }}</p>
                    <p class="text-sm"><strong>Autores:</strong>
                        @forelse ($livro->autores as $autor)
                        {{ $autor->nome }}@if (!$loop->last), @endif
                        @empty
                        <span class="italic text-gray-400">Sem autores</span>
                        @endforelse
                    </p>
                    <p class="text-sm"><strong>Preço:</strong> €{{ number_format($livro->preco, 2, ',', '.') }}</p>

                    @if ($livro->bibliografia)
                    <p class="text-sm text-gray-600">
                        <strong>Bibliografia:</strong> {{ Str::limit($livro->bibliografia, 80) }}
                    </p>
                    @endif

                    <div class="card-actions justify-end mt-4">
                        <a href="{{ route('livros.show', $livro->id) }}" class="text-blue-600 hover:underline">Ver Mais</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
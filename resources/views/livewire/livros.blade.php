<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Livros Disponíveis') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 mb-6 mt-4 flex flex-wrap gap-4">
        <select id="author" wire:model.live="autorSelecionado" class="select select-bordered w-full max-w-xs rounded-xl">
            <option value="">Todos os autores</option>
            @foreach ($autores as $autor)
            <option value="{{ $autor->id }}">{{ $autor->nome }}</option>
            @endforeach
        </select>

        <select wire:model.live="ordenarPorNome" class="select select-bordered w-full max-w-xs rounded-xl">
            <option value=" ">Ordena por nome</option>
            <option value="asc">Ascendente (A-Z)</option>
            <option value="desc">Descendente (Z-A)</option>
        </select>

        <input type="text" wire:model.live="pesquisa" placeholder="Pesquisa por nome do livro"
            class="input input-bordered w-full max-w-xs rounded-xl" />
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

                    <p class="text-sm">
                        <strong>Autores:</strong>
                        {{ $livro->autores->pluck('nome')->join(', ') }}
                    </p>
                    <p class="text-sm"><strong>Preço:</strong> €{{ number_format($livro->preco, 2, ',', '.') }}</p>

                    <div class="card-actions justify-end ">
                        <a href="{{ route('livros.show', $livro->id) }}" class="btn btn-info">Ver Mais</a>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
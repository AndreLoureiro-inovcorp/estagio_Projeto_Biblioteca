<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Autores') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 mb-6 mt-4 flex flex-wrap gap-4">
        <input type="text" wire:model.live="pesquisa" placeholder="Pesquisa por autor" class="input input-bordered w-full max-w-xs rounded-xl" />

        <select wire:model.live="ordenarPorNome" class="select select-bordered w-full max-w-xs rounded-xl">
            <option value=" ">Ordena por nome</option>
            <option value="asc">Ascendente (A-Z)</option>
            <option value="desc">Descendente (Z-A)</option>
        </select>
    </div>

    <div class="flex justify-center mt-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($autores as $autor)
            <div class="card bg-base-100 w-80 shadow-md rounded-2xl overflow-hidden">
                <figure>
                    <img src="{{ $autor->foto ?? 'https://via.placeholder.com/300x400?text=Autor' }}" alt="{{ $autor->nome }}" class="w-full h-64 object-cover rounded-t-xl" />
                </figure>
                <div class="card-body space-y-2">
                    <h2 class="card-title text-lg font-semibold">{{ $autor->nome }}</h2>
                    <p class="text-sm"><strong>Bio:</strong>Eu sou um autor...</p>
                    <p class="text-sm"><strong>Total de livros:</strong> {{ $autor->livros->count() }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editoras') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 mb-6 mt-4 flex gap-4">
        <input type="text" wire:model.live="pesquisa" placeholder="Pesquisa por editora"
            class="max-w-[12.5rem] w-full h-10 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-3">
        </input>
        <select wire:model.live="ordenarPorNome"
            class="max-w-[12.5rem] w-full h-10 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-3">
            <option value=" ">Ordena por nome</option>
            <option value="asc">Ascendente (A-Z)</option>
            <option value="desc">Descendente (Z-A)</option>
        </select>
    </div>

    <div class="flex justify-center mt-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($editoras as $editora)
            <div class="card bg-base-100 w-80 shadow-md rounded-2xl px-4 py-6 overflow-hidden">
                <figure class="bg-gray-100">
                    <img src="{{ $editora->logotipo ?? 'https://via.placeholder.com/300x120?text=Editora' }}"
                        alt="{{ $editora->nome }}"
                        class="w-full h-40 object-contain p-4" />
                </figure>
                <div class="card-body space-y-2">
                    <h2 class="card-title text-lg font-semibold">{{ $editora->nome }}</h2>
                    <div class="card-actions justify-end mt-4">
                        <a href="#" class="btn btn-primary btn-sm rounded-full">Ver Mais</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
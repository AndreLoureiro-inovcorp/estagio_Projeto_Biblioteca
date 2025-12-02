<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editoras') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl px-4 mb-6 mt-4 flex flex-wrap gap-4">
        <input type="text" wire:model.live="pesquisa" placeholder="Pesquisa por editora" class="input input-bordered w-full max-w-xs rounded-xl" />

        <select wire:model.live="ordenarPorNome" class="select select-bordered w-full max-w-xs rounded-xl">
            <option value=" ">Ordena por nome</option>
            <option value="asc">Ascendente (A-Z)</option>
            <option value="desc">Descendente (Z-A)</option>
        </select>
    </div>

    <div class="flex justify-center mt-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($editoras as $editora)
            <div class="card bg-base-100 w-80 shadow-md rounded-2xl overflow-hidden">

                <div class="avatar justify-center pt-4">
                    <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="{{ $editora->logotipo ?? 'https://via.placeholder.com/150?text=Editora' }}" alt="{{ $editora->nome }}" />
                    </div>
                </div>

                <div class="card-body items-center text-center space-y-2">
                    <h2 class="card-title text-lg font-semibold">{{ $editora->nome }}</h2>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Editoras') }}
    </h2>
</x-slot>

<div class="flex justify-center mt-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($editoras as $editora)
        <div class="card bg-base-100 w-80 shadow-md rounded-2xl overflow-hidden">
            <figure class="bg-gray-100">
                <img src="{{ $editora->logotipo ?? 'https://via.placeholder.com/300x120?text=Editora' }}"
                    alt="{{ $editora->nome }}"
                    class="w-full h-40 object-contain p-4" />
            </figure>
            <div class="card-body space-y-2">
                <h2 class="card-title text-lg font-semibold">{{ $editora->nome }}</h2>
                <p class="text-sm"><strong>Total de livros:</strong> {{ $editora->livros->count() }}</p>
                <div class="card-actions justify-end mt-4">
                    <a href="#" class="btn btn-primary btn-sm rounded-full">Ver Mais</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
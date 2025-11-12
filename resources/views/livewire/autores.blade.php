<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Autores') }}
    </h2>
</x-slot>

<div class="flex justify-center mt-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($autores as $autor)
        <div class="card bg-base-100 w-80 shadow-md rounded-2xl overflow-hidden">
            <figure>
                <img src="{{ $autor->foto ?? 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}"
                    alt="{{ $autor->nome }}"
                    class="w-full h-60 object-cover" />
            </figure>
            <div class="card-body space-y-2">
                <h2 class="card-title text-lg font-semibold">{{ $autor->nome }}</h2>
                <p class="text-sm"><strong>Bio:</strong> {{ Str::limit($autor->biografia, 100) ?? 'Sem informação' }}</p>
                <p class="text-sm"><strong>Total de livros:</strong> {{ $autor->livros->count() }}</p>
                <div class="card-actions justify-end mt-4">
                    <a href="#" class="btn btn-primary btn-sm rounded-full">Ver Mais</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

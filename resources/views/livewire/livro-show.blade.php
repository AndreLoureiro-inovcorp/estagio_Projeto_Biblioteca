<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Livro: ') }}{{ $livro->nome }}
        </h2>
    </x-slot>
    @if(session('sucesso'))
    <div class="alert alert-success shadow-lg mb-4 mt-4">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('sucesso') }}</span>
        </div>
    </div>
    @endif


    <div class="max-w-4xl mx-auto mt-16 bg-base-100 shadow-md rounded-2xl px-6 py-8">
        <div class="flex flex-col sm:flex-row items-start gap-6">
            <figure class="flex-shrink-0">
                <img src="{{ $livro->imagem_capa ?? 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}" alt="{{ $livro->nome }}" class="w-48 h-64 object-cover rounded-lg shadow-md" />
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
                <p><strong>Disponibilidade:</strong>
                    @if($livro->disponivel)
                    <span class="badge badge-success">Disponível</span>
                    @else
                    <span class="badge badge-error">Indisponível</span>
                    @endif
                </p>

                <div class="card-actions justify-end ">
                    <a href="{{ route('livros.historico', $livro->id) }}" class="btn btn-sm btn-info">Histórico</a>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-4xl mx-auto mt-6 px-4">
        @livewire('biblioteca.requisitar-livro-direto', ['livroId' => $livro->id])

        <a href="{{ route('livros.index') }}" class="btn btn-outline btn-sm rounded-full">
            ← Voltar
        </a>
    </div>
</div>

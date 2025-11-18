<div class="py-10 max-w-7xl mx-auto">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Gestão de Livros') }}
            </h2>
            <a href="{{ route('livros.criar') }}" class="btn btn-primary text-sm">
                Criar Novo Livro
            </a>
        </div>
    </x-slot>



    @if (session()->has('message'))
    <div class="alert alert-success mb-4">
        {{ session('message') }}
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-error mb-4">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid gap-6">
        @forelse ($livros as $livro)
        <div class="bg-base-100 shadow-md rounded-2xl px-6 py-8">
            <div class="flex flex-col sm:flex-row items-start gap-6">
                <figure class="flex-shrink-0">
                    <img src="{{ $livro->imagem_capa ? Storage::url($livro->imagem_capa) : 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}"
                        alt="{{ $livro->nome }}"
                        class="w-48 h-64 object-cover rounded-lg shadow-md" />
                </figure>

                <div class="flex-1 space-y-2 min-w-0 break-words">
                    <h1 class="text-2xl font-semibold">{{ $livro->nome }}</h1>

                    @if ($livro->bibliografia)
                    <div>
                        <h2 class="font-semibold">Bibliografia</h2>
                        <p class="text-sm text-gray-600">{{ $livro->bibliografia }}</p>
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

                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('livros.editar', $livro->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <button wire:click="eliminarDireto({{ $livro->id }})" class="btn btn-sm btn-error">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500">Nenhum livro encontrado.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $livros->links() }}
    </div>
</div>
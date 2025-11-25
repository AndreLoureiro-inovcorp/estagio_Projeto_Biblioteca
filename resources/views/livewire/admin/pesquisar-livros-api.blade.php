<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Pesquisar Livros - Google Books API') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4">

            @if (session()->has('message'))
            <div class="alert alert-info mb-6">
                {{ session('message') }}
            </div>
            @endif

            <div class="card bg-base-100 shadow-xl mb-8">
                <div class="card-body">
                    <form wire:submit.prevent="pesquisar" class="flex gap-3">
                        <input type="text" wire:model="termoPesquisa" placeholder="Digite o nome do livro ou do autor" class="input input-bordered flex-1">

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition disabled:opacity-50" wire:loading.attr="disabled">
                            <span wire:loading.remove>Pesquisar</span>
                            <span wire:loading>A carregar livros...</span>
                        </button>

                        <button type="button" wire:click="limpar" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg transition">
                            Limpar
                        </button>
                    </form>

                    @error('termoPesquisa')
                    <div class="text-error text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>



            @if(!empty($resultados))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" wire:loading.class="opacity-50">
                @foreach($resultados as $livro)
                <div class="card bg-base-100 shadow-xl">
                    <figure class="px-4 pt-4">
                        @if($livro['imagem_capa'])
                        <img src="{{ $livro['imagem_capa'] }}" alt="{{ $livro['nome'] }}" class="rounded-xl h-48 object-contain">
                        @else
                        <div class="bg-base-200 rounded-xl h-48 w-full flex items-center justify-center">
                            <span class="text-base-content opacity-40">Sem imagem</span>
                        </div>
                        @endif
                    </figure>

                    <div class="card-body p-4 space-y-1">
                        <h2 class="card-title text-base">{{ $livro['nome'] }}</h2>

                        @if(!empty($livro['autores_nomes']))
                        <p class="text-sm">
                            <strong>Autor(es):</strong>
                            {{ implode(', ', $livro['autores_nomes']) }}
                        </p>
                        @endif

                        @if($livro['editora_nome'])
                        <p class="text-sm">
                            <strong>Editora:</strong>
                            {{ $livro['editora_nome'] }}
                        </p>
                        @endif

                        <p class="text-sm">
                            <strong>ISBN:</strong>
                            {{ $livro['isbn'] }}
                        </p>

                        @if($livro['bibliografia'])
                        <p class="text-sm text-base-content opacity-70">
                            {{ Str::limit($livro['bibliografia'], 100) }}
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

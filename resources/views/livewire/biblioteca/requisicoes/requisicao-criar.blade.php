<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Nova Requisição') }}
        </h2>
    </div>
</x-slot>

<div class="py-10">
    <div class="max-w-4xl mx-auto bg-base-100 shadow-md rounded-2xl p-6">

        @if (session()->has('error'))
        <div class="alert alert-error mb-4">
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <div class="card bg-base-200 p-4 rounded-xl mb-6">
            <h3 class="text-lg font-semibold mb-4">Informação do Requisitante</h3>
            <div class="flex justify-between">
                <p><strong>Nome:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Requisições Ativas:</strong> {{ auth()->user()->numeroDeLivrosRequisitados() }} / 3</p>
            </div>
        </div>

        <form wire:submit.prevent="criar">
            <div class="form-control mb-6">
                <label class="label font-semibold">Seleciona o Livro *</label>
                <select wire:model.live="livro_id" class="select select-bordered w-full">
                    <option value="">Escolhe um livro...</option>
                    @foreach($livrosDisponiveis as $livro)
                    <option value="{{ $livro->id }}">{{ $livro->nome }} - {{ $livro->editora->nome }}</option>
                    @endforeach
                </select>
                @error('livro_id')
                <span class="text-error text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            @if($livroSelecionado)
            <div class="bg-base-200 p-6 rounded-xl mb-6 space-y-4">
                <div class="flex flex-col md:flex-row gap-6">
                    <figure class="flex-shrink-0">
                        <img src="{{ $livroSelecionado->imagem_capa ?? 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}" alt="{{ $livroSelecionado->nome }}" class="w-48 h-64 object-cover rounded-lg shadow-md" />
                    </figure>

                    <div class="flex-1 space-y-2">
                        <h3 class="text-xl font-bold">{{ $livroSelecionado->nome }}</h3>
                        <p><strong>ISBN:</strong> {{ $livroSelecionado->isbn }}</p>
                        <p><strong>Editora:</strong> {{ $livroSelecionado->editora->nome }}</p>
                        <p><strong>Autores:</strong>
                            @foreach($livroSelecionado->autores as $autor)
                            {{ $autor->nome }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                        @if($livroSelecionado->bibliografia)
                        <p class="mt-2"><strong>Bibliografia:</strong> {{ $livroSelecionado->bibliografia }}</p>
                        @endif
                    </div>
                </div>

                <div class="divider"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-center">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <p class="text-sm text-gray-500">Data de Requisição</p>
                        <p class="text-lg font-bold">{{ now()->format('d/m/Y') }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <p class="text-sm text-gray-500">Prazo Entrega</p>
                        <p class="text-lg font-bold text-yellow-600">{{ now()->addDays(5)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded transition" @if(!$livroSelecionado) disabled @endif>
                    Confirmar Requisição
                </button>
            </div>
        </form>
    </div>
    <div class="max-w-4xl mx-auto mt-6 px-4">
        <a href="{{ route('requisicoes.index') }}" class="btn btn-outline btn-sm rounded-full">
            ← Voltar
        </a>
    </div>
</div>

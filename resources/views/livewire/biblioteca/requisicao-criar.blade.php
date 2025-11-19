<div class="py-10">
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Nova Requisição') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-base-100 shadow-md rounded-2xl p-6">

        @if (session()->has('error'))
        <div class="alert alert-error mb-4">
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <div class="bg-base-200 p-4 rounded-xl mb-6">
            <h3 class="text-lg font-semibold mb-2">Informação do Requisitante</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <p><strong>Nome:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
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
            <div class="bg-base-200 p-6 rounded-xl mb-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <img src="{{ $livroSelecionado->imagem_capa ? Storage::url($livroSelecionado->imagem_capa) : 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}" class="w-32 h-48 object-cover rounded-md shadow">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold mb-2">{{ $livroSelecionado->nome }}</h3>
                        <p><strong>ISBN:</strong> {{ $livroSelecionado->isbn }}</p>
                        <p><strong>Editora:</strong> {{ $livroSelecionado->editora->nome }}</p>
                        <p><strong>Autores:</strong>
                            @foreach($livroSelecionado->autores as $autor)
                            <span class="badge badge-sm mr-1">{{ $autor->nome }}</span>
                            @endforeach
                        </p>
                        @if($livroSelecionado->bibliografia)
                        <p class="mt-2"><strong>Bibliografia:</strong> {{ $livroSelecionado->bibliografia }}</p>
                        @endif
                    </div>
                </div>

                <div class="divider"></div>

                <div class="grid md:grid-cols-3 text-center gap-4">
                    <div>
                        <p class="text-sm opacity-70">Data de Requisição</p>
                        <p class="font-bold">{{ now()->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm opacity-70">Prazo Entrega</p>
                        <p class="font-bold text-warning">{{ now()->addDays(5)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm opacity-70">Dias Disponíveis</p>
                        <p class="font-bold text-info">5 dias</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex justify-between">
                <a href="{{ route('requisicoes.index') }}" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-primary" @if(!$livroSelecionado) disabled @endif>
                    Confirmar Requisição
                </button>
            </div>
        </form>
    </div>
</div>

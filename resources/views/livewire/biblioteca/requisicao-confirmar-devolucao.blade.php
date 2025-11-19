<div class="py-10">
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Confirmar Devolução') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-base-100 shadow-md rounded-2xl p-6">

        @if (session()->has('error'))
            <div class="alert alert-error mb-4">
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if (session()->has('message'))
            <div class="alert alert-success mb-4">
                <span>{{ session('message') }}</span>
            </div>
        @endif

        <div class="mb-6">
            <p class="text-sm opacity-70">
                Requisição: <span class="font-mono font-semibold">{{ $requisicao->numero_requisicao }}</span>
            </p>
        </div>

        <div class="bg-base-200 p-4 rounded-xl mb-6">
            <h3 class="text-lg font-semibold mb-4">Detalhes da Requisição</h3>

            <div class="grid md:grid-cols-2 gap-6 mb-4">
                <div>
                    <h4 class="text-sm font-semibold opacity-70 mb-2">Cidadão</h4>
                    <div class="flex items-center gap-3">
                        <div class="avatar">
                            <div class="w-16 h-16 rounded-full">
                                <img src="{{ $requisicao->foto_cidadao 
                                    ?? 'https://ui-avatars.com/api/?name=' . urlencode($requisicao->user->name) }}" 
                                     alt="{{ $requisicao->user->name }}">
                            </div>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $requisicao->user->name }}</p>
                            <p class="text-sm opacity-70">{{ $requisicao->user->email }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold opacity-70 mb-2">Livro</h4>
                    <div class="flex gap-3">
                        @if($requisicao->livro->imagem_capa)
                            <div class="avatar">
                                <div class="w-16 h-20 rounded">
                                    <img src="{{ Storage::url($requisicao->livro->imagem_capa) }}" 
                                         alt="{{ $requisicao->livro->nome }}">
                                </div>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold">{{ $requisicao->livro->nome }}</p>
                            <p class="text-sm opacity-70">{{ $requisicao->livro->editora->nome }}</p>
                            <p class="text-xs font-mono opacity-60">{{ $requisicao->livro->isbn }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm opacity-70">Data de Requisição</p>
                    <p class="font-semibold">{{ $requisicao->data_requisicao->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm opacity-70">Data Prevista de Entrega</p>
                    <p class="font-semibold">{{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm opacity-70">Estado</p>
                    @php 
                        $atrasado = $requisicao->data_prevista_entrega < now();
                    @endphp
                    <span class="badge {{ $atrasado ? 'badge-error' : 'badge-info' }}">
                        {{ $atrasado 
                            ? 'Atrasado ' . now()->diffInDays($requisicao->data_prevista_entrega) . ' dias' 
                            : 'No prazo' }}
                    </span>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="confirmar">
            <div class="bg-base-200 p-6 rounded-xl mb-6">
                <h3 class="text-lg font-semibold mb-4">Confirmação de Devolução</h3>

                <div class="form-control mb-4">
                    <label class="label font-semibold">Data Real de Entrega *</label>
                    <input type="date" 
                           wire:model="data_entrega_real" 
                           class="input input-bordered @error('data_entrega_real') input-error @enderror" 
                           min="{{ $requisicao->data_requisicao->format('Y-m-d') }}" 
                           max="{{ now()->format('Y-m-d') }}">
                    @error('data_entrega_real')
                        <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <span class="label-text-alt">Por padrão, a data de hoje está selecionada</span>
                </div>

                @if($data_entrega_real)
                    @php
                        $diasCalculados = \Carbon\Carbon::parse($requisicao->data_requisicao)
                                        ->diffInDays(\Carbon\Carbon::parse($data_entrega_real));
                        $diferenca = $diasCalculados - 5;
                    @endphp
                    <div class="alert {{ $diferenca > 0 ? 'alert-warning' : 'alert-success' }}">
                        <p class="font-semibold">Total de dias com o livro: {{ $diasCalculados }} dias</p>
                        <p class="text-sm">
                            @if($diferenca > 0)
                                Entrega com {{ $diferenca }} dia(s) de atraso
                            @elseif($diferenca < 0)
                                Entrega {{ abs($diferenca) }} dia(s) antes do prazo
                            @else
                                Entrega no prazo
                            @endif
                        </p>
                    </div>
                @endif
            </div>

            <div class="flex justify-between">
                <a href="{{ route('requisicoes.index') }}" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-success gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Confirmar Devolução
                </button>
            </div>
        </form>
    </div>
</div>

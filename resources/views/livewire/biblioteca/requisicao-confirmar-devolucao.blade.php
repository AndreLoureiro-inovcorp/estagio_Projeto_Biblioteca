<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Confirmar Devolução') }}
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

        @if (session()->has('message'))
        <div class="alert alert-success mb-4">
            <span>{{ session('message') }}</span>
        </div>
        @endif

        <div class="bg-base-200 p-6 rounded-xl mb-6">
            <h3 class="text-lg font-semibold mb-4">Informações da Requisição</h3>

            <div class="mb-4 grid md:grid-cols-2 gap-4">
                <div>
                    <p><strong>Utilizador:</strong> {{ $requisicao->user->name }}</p>
                    <p class="text-sm opacity-70">{{ $requisicao->user->email }}</p>
                </div>
                <div>
                    <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
                    <p class="text-sm text-gray-500">Requisição Nº: <span class="font-mono">{{ $requisicao->numero_requisicao }}</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Data de Requisição</p>
                    <p class="text-lg font-bold">{{ $requisicao->data_requisicao->format('d/m/Y') }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Data Prevista</p>
                    <p class="text-lg font-bold">{{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Estado</p>
                    @php
                    $atrasado = $requisicao->data_prevista_entrega < now(); @endphp <p class="text-lg font-bold {{ $atrasado ? 'text-red-600' : 'text-green-600' }}">{{ $atrasado ? 'Atrasado' : 'No Prazo' }}</p>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="confirmar">
            <div class="bg-base-200 p-6 rounded-xl mb-6">
                <h3 class="text-lg font-semibold mb-4">Data Real de Entrega</h3>

                <div class="form-control mb-4">
                    <label class="label font-semibold">Selecionar Data *</label>
                    <input type="date" wire:model="data_entrega_real" class="input input-bordered @error('data_entrega_real') input-error @enderror" min="{{ $requisicao->data_requisicao->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
                    @error('data_entrega_real')
                    <span class="text-error text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                @if($data_entrega_real)
                @php
                $diasCalculados = \Carbon\Carbon::parse($requisicao->data_requisicao)
                ->diffInDays(\Carbon\Carbon::parse($data_entrega_real));
                $diferenca = $diasCalculados - 5;
                @endphp
                <div class="alert {{ $diferenca > 0 ? 'alert-warning' : 'alert-success' }}">
                    <p class="font-semibold">Total com o livro: {{ $diasCalculados }} dia(s)</p>
                    <p class="text-sm">
                        @if($diferenca > 0)
                        Com {{ $diferenca }} dia(s) de atraso
                        @elseif($diferenca < 0) Devolvido {{ abs($diferenca) }} dia(s) antes @else Devolvido no prazo @endif </p>
                </div>
                @endif
            </div>

            <div class="flex justify-between">
                <a href="{{ route('requisicoes.index') }}" class="btn btn-ghost">← Cancelar</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded transition">
                    Confirmar Devolução
                </button>
            </div>
        </form>
    </div>
</div>

<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Diz-nos o que achaste deste livro:
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10">

        @if (session()->has('error'))
            <div class="alert alert-error mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="salvar" class="space-y-6 bg-base-100 p-6 rounded-xl shadow-md">

            <div>
                <label class="label font-medium">Classificação:</label>

                <select wire:model="classificacao" class="select select-bordered w-full">
                    <option value="5">⭐⭐⭐⭐⭐ - Espetacular</option>
                    <option value="4">⭐⭐⭐⭐ - Muito bom</option>
                    <option value="3">⭐⭐⭐ - Bom</option>
                    <option value="2">⭐⭐ - Mau</option>
                    <option value="1">⭐ - Muito mau</option>
                </select>

                @error('classificacao')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="label font-medium">
                    O que achas-te deste livro ?
                </label>

                <textarea
                    wire:model="comentario"
                    rows="5"
                    class="textarea textarea-bordered w-full"
                    placeholder="Escreve aqui..."></textarea>

                @error('comentario')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('requisicoes.index') }}" class="btn btn-outline">
                    ← Voltar
                </a>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded transition">
                    Enviar Review
                </button>
            </div>

        </form>

    </div>
</div>




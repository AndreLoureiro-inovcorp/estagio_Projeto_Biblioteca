<div class="max-w-4xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Editar Livro</h1>

    @if (session()->has('message'))
    <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="atualizar" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="label">ISBN *</label>
                <input type="text" wire:model="isbn" class="input input-bordered w-full">
                @error('isbn') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="label">Nome do Livro *</label>
                <input type="text" wire:model="nome" class="input input-bordered w-full">
                @error('nome') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="label">Editora *</label>
                <select wire:model="editora_id" class="select select-bordered w-full">
                    <option value="">Seleciona uma editora</option>
                    @foreach($editoras as $editora)
                    <option value="{{ $editora->id }}">{{ $editora->nome }}</option>
                    @endforeach
                </select>
                @error('editora_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="label">Preço (€)</label>
                <input type="number" step="0.01" wire:model="preco" class="input input-bordered w-full">
                @error('preco') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="label">Autores * (pode escolher vários)</label>
            <select wire:model="autoresSelecionados" multiple size="5" class="select select-bordered w-full">
                @foreach($autores as $autor)
                <option value="{{ $autor->id }}">{{ $autor->nome }}</option>
                @endforeach
            </select>
            <span class="text-xs text-gray-500">Usa Ctrl/Cmd para selecionar múltiplos</span>
            @error('autoresSelecionados') <span class="text-error text-sm block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="label">Bibliografia</label>
            <textarea wire:model="bibliografia" class="textarea textarea-bordered w-full"></textarea>
            @error('bibliografia') <span class="text-error text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="label">Imagem da Capa</label>

            @if ($imagem_capa)
            <div class="mb-2">
                <img src="{{ Storage::url($imagem_capa) }}" alt="Capa atual" class="w-32 h-48 object-cover rounded">
                <p class="text-sm text-gray-500 mt-1">Imagem atual</p>
            </div>
            @endif

            <input type="file" wire:model="nova_imagem" accept="image/*" class="file-input file-input-bordered w-full">
            @error('nova_imagem') <span class="text-error text-sm">{{ $message }}</span> @enderror
            <div wire:loading wire:target="nova_imagem" class="text-sm mt-2">A carregar imagem...</div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('livros.gerir') }}" class="btn btn-ghost">← Voltar</a>
            <button type="submit" class="btn btn-primary">Guardar Alterações</button>
        </div>
    </form>
</div>

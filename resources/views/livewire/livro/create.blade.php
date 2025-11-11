<div class="p-6">
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label for="titulo">Título</label>
            <input wire:model="titulo" id="titulo" type="text" class="w-full border rounded p-2">
            @error('titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="editora_id">Editora</label>
            <select wire:model="editora_id" id="editora_id" class="w-full border rounded p-2">
                <option value="">Selecione uma editora</option>
                @foreach($editoras as $editora)
                    <option value="{{ $editora->id }}">{{ $editora->nome }}</option>
                @endforeach
            </select>
            @error('editora_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="autores">Autores</label>
            <select wire:model="autores" multiple id="autores" class="w-full border rounded p-2">
                @foreach($autores as $autor)
                    <option value="{{ $autor->id }}">{{ $autor->nome }}</option>
                @endforeach
            </select>
            @error('autores') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
            Guardar Livro
        </button>
    </form>
</div>

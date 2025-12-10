<div>

    @if($livro->podeSerComprado())

    <button wire:click="adicionar" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-4 py-2 rounded transition flex items-center gap-2">
        Comprar
    </button>

    @else

    <button class="bg-gray-400 text-white font-medium text-sm px-4 py-2 rounded opacity-70 cursor-not-allowed" disabled>
        Esgotado
    </button>
    
    @endif

</div>

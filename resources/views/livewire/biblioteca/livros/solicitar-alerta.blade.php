<div class="flex items-center gap-3">

    @if(!$livro->disponivel)

    @if($jaPediu)
    <span class="badge badge-info badge-outline">
        Notificação ativa
    </span>
    @else
    <button wire:click="solicitarAlerta" class="bg-sky-500 hover:bg-sky-600 text-white font-medium text-sm px-4 py-2 rounded transition">
        Notificar-me quando disponível
    </button>
    @endif

    @endif

</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-base-200 shadow-xl sm:rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4">Histórico de Requisições <span class="badge badge-lg">{{ $livro->historicoRequisicoes->count() }}</span></h3>
            @if($livro->historicoRequisicoes->count() > 0)
            <div class="space-y-4">
                @foreach($livro->historicoRequisicoes as $requisicao)
                <div class="bg-base-300 rounded-xl p-4">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4 flex-1">
                            <div class="avatar">
                                <div class="w-12 h-12 rounded-full">
                                    <img src="{{ $requisicao->foto_cidadao ?? 'https://ui-avatars.com/api/?name=' . urlencode($requisicao->user->name) }}" alt="{{ $requisicao->user->name }}">
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold">{{ $requisicao->user->name }}</div>
                                <div class="text-sm opacity-70">{{ $requisicao->numero_requisicao }}</div>
                                <div class="text-sm mt-2">
                                    <p>Requisitado: <span class="font-semibold">{{ $requisicao->data_requisicao->format('d/m/Y') }}</span></p>
                                    <p>Previsto: <span class="font-semibold">{{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</span></p>
                                    @if($requisicao->data_entrega_real)
                                    <p>Entregue: <span class="font-semibold">{{ $requisicao->data_entrega_real->format('d/m/Y') }}</span>
                                        <span class="text-xs ml-2">({{ $requisicao->dias_decorridos }} dias)</span>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            @if($requisicao->estado === 'ativa')
                            <span class="badge badge-info">Requisitado</span>
                            @elseif($requisicao->estado === 'entregue')
                            <span class="badge badge-success">Entregue</span>
                            @else
                            <span class="badge">{{ ucfirst($requisicao->estado) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 opacity-50">
                <p>Este livro ainda não foi requisitado.</p>
            </div>
            @endif

        </div>
        <div class="mb-4 mt-4">
            <a href="{{ route('livros.show', $livro->id) }}" class="btn btn-outline btn-sm rounded-full">
                ← Voltar
            </a>
        </div>
    </div>
</div>


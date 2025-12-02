<x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800 leading-tight">
        Histórico de Requisições
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-base-100 shadow-xl rounded-xl p-6">
            @if($livro->historicoRequisicoes->count() > 0)
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead class="text-base font-semibold text-neutral">
                        <tr>
                            <th>Utilizador</th>
                            <th>Nº Requisição</th>
                            <th>Data Requisição</th>
                            <th>Data Prevista</th>
                            <th>Data Entrega</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($livro->historicoRequisicoes as $index => $requisicao)
                        <tr>
                            <td>{{ $requisicao->user->name }}</td>
                            <td>{{ $requisicao->numero_requisicao }}</td>
                            <td>{{ $requisicao->data_requisicao->format('d/m/Y') }}</td>
                            <td>{{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</td>
                            <td>
                                @if($requisicao->data_entrega_real)
                                {{ $requisicao->data_entrega_real->format('d/m/Y') }}
                                @else
                                <span class="text-gray-400 italic">—</span>
                                @endif
                            </td>
                            <td>
                                @if($requisicao->estado === 'ativa')
                                <span class="badge badge-info">Requisitado</span>
                                @elseif($requisicao->estado === 'entregue')
                                <span class="badge badge-success">Entregue</span>
                                @else
                                <span class="badge">{{ ucfirst($requisicao->estado) }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8 opacity-50">
                <p>Este livro ainda não foi requisitado.</p>
            </div>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('livros.show', $livro->id) }}" class="btn btn-outline btn-sm rounded-full">
                ← Voltar
            </a>
        </div>
    </div>
</div>

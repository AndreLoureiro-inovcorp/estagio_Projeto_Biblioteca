<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $isAdmin ? 'Todas as Requisições' : 'As Minhas Requisições' }}
        </h2>
        <a href="{{ route('requisicao.criar') }}" class="btn btn-outline">Nova Requisição</a>
    </div>
</x-slot>

<div class="py-10 max-w-7xl mx-auto">

    @role('admin')
    <div class="mb-6">
        <livewire:biblioteca.indicadores-requisicoes />
    </div>
    @endrole

    <div class="bg-base-100 shadow-xl rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead class="text-base font-semibold text-neutral">
                    <tr>
                        <th>Nº Requisição</th>
                        @if($isAdmin)
                        <th>Utilizador</th>
                        @endif
                        <th>Livro</th>
                        <th>Data Requisição</th>
                        <th>Prev. Entrega</th>
                        <th>Entrega Real</th>
                        <th>Estado</th>
                        @if($isAdmin)
                        <th>Confirmar devoluções</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($requisicoes as $requisicao)
                    <tr>
                        <td>
                            <span>
                                {{ $requisicao->numero_requisicao }}
                            </span>
                        </td>

                        @if($isAdmin)
                        <td>{{ $requisicao->user->name }}</td>
                        @endif

                        <td>
                            <div>{{ $requisicao->livro->nome }}</div>
                        </td>

                        <td>{{ $requisicao->data_requisicao->format('d/m/Y') }}</td>
                        <td>{{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</td>
                        <td>
                            @if($requisicao->data_entrega_real)
                            {{ \Carbon\Carbon::parse($requisicao->data_entrega_real)->format('d/m/Y') }}
                            @else
                            <span class="text-gray-400 italic">—</span>
                            @endif
                        </td>

                        <td>
                            @if($requisicao->estado === 'entregue')
                            <span class="badge badge-success">Entregue</span>
                            @else
                            <span class="badge badge-info">Por Devolver</span>
                            @endif
                        </td>

                        @if($isAdmin)
                        <td>
                            @if($requisicao->estado === 'ativa')
                            <a href="{{ route('requisicoes.confirmar-devolucao', $requisicao->id) }}" class="btn btn-sm btn-success">
                                Confirmar Devolução
                            </a>
                            @else
                            <span class="text-gray-400 italic">—</span>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? '8' : '6' }}" class="text-center py-6 text-base-content opacity-50">
                            Nenhuma requisição encontrada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

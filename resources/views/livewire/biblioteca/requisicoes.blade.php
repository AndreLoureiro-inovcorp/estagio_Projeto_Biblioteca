<div class="py-10 max-w-7xl mx-auto">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ $isAdmin ? 'Todas as Requisições' : 'As Minhas Requisições' }}
            </h2>
            <a href="{{ route('requisicao.criar') }}" class="btn btn-primary btn-sm">
                + Nova Requisição
            </a>
        </div>
    </x-slot>

    <div class="bg-base-100 shadow-md rounded-2xl p-6 mt-6">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Nº Requisição</th>
                        @if($isAdmin)
                        <th>Cidadão</th>
                        @endif
                        <th>Livro</th>
                        <th>Data Requisição</th>
                        <th>Data Prev. Entrega</th>
                        <th>Estado</th>
                        @if($isAdmin)
                        <th>Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($requisicoes as $requisicao)
                    <tr>
                        <td>
                            <span class="font-mono font-semibold">
                                {{ $requisicao->numero_requisicao }}
                            </span>
                        </td>

                        @if($isAdmin)
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="avatar">
                                    <div class="w-8 h-8 rounded-full">
                                        <img src="{{ $requisicao->foto_cidadao ?? 'https://ui-avatars.com/api/?name=' . urlencode($requisicao->user->name) }}" alt="{{ $requisicao->user->name }}">
                                    </div>
                                </div>
                                <span>{{ $requisicao->user->name }}</span>
                            </div>
                        </td>
                        @endif

                        <td>
                            <div>
                                <div class="font-semibold">{{ $requisicao->livro->nome }}</div>
                                <div class="text-sm opacity-70">{{ $requisicao->livro->editora->nome }}</div>
                            </div>
                        </td>

                        <td>{{ $requisicao->data_requisicao->format('d/m/Y') }}</td>

                        <td>
                            <div>
                                {{ $requisicao->data_prevista_entrega->format('d/m/Y') }}
                                @php
                                    $diasRestantes = now()->diffInDays($requisicao->data_prevista_entrega, false);
                                @endphp
                                @if($requisicao->estado === 'ativa' && $diasRestantes <= 1 && $diasRestantes >= 0)
                                <div class="badge badge-warning badge-sm mt-1">Entrega amanhã!</div>
                                @elseif($requisicao->estado === 'ativa' && $diasRestantes < 0)
                                <div class="badge badge-error badge-sm mt-1">Atrasado {{ abs($diasRestantes) }} dias</div>
                                @endif
                            </div>
                        </td>

                        <td>
                            @if($requisicao->estado === 'ativa')
                            <span class="badge badge-info">Ativa</span>
                            @elseif($requisicao->estado === 'entregue')
                            <span class="badge badge-success">Entregue</span>
                            @elseif($requisicao->estado === 'atrasada')
                            <span class="badge badge-error">Atrasada</span>
                            @endif
                        </td>

                        @if($isAdmin && $requisicao->estado === 'ativa')
                        <td>
                            <a href="{{ route('requisicoes.confirmar-devolucao', $requisicao->id) }}" class="btn btn-sm btn-success">
                                Confirmar Devolução
                            </a>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? '7' : '5' }}" class="text-center py-8">
                            <p class="text-base-content opacity-50">Nenhuma requisição encontrada</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
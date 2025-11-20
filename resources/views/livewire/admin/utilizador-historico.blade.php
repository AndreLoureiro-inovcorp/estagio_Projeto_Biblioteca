<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Histórico de Requisições - {{ $utilizador->name }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-base-100 shadow-xl rounded-xl p-6">
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead class="text-base font-semibold text-neutral">
                        <tr>
                            <th>Nº Requisição</th>
                            <th>Livro</th>
                            <th>Data Requisição</th>
                            <th>Data Prevista de Entrega</th>
                            <th>Data de Entrega Real</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requisicoes as $requisicao)
                        <tr>
                            <td>{{ $requisicao->numero_requisicao }}</td>
                            <td>{{ $requisicao->livro->nome }}</td>
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
                                @if($requisicao->estado === 'ativa')
                                <span class="badge badge-info">Requisitado</span>
                                @else
                                <span class="badge badge-success">Entregue</span>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.utilizadores') }}" class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
                    ← Voltar
                </a>
            </div>
        </div>
    </div>
</div>

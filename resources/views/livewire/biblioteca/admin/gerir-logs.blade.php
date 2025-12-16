<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Logs
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <div class="bg-white shadow-xl sm:rounded-lg p-6">

            @if($logs->isEmpty())
            <div class="alert alert-info">
                <span>Nenhum log encontrado.</span>
            </div>
            @else

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Utilizador</th>
                            <th>Módulo</th>
                            <th>Ação</th>
                            <th>Descrição</th>
                            <th>IP</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td class="text-sm text-gray-500">
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="font-semibold text-gray-800">
                                {{ $log->user->name }}
                            </td>

                            <td>
                                <span class="badge badge-outline">
                                    {{ $log->modulo }}
                                </span>
                            </td>

                            <td class="font-medium text-gray-800">
                                {{ $log->acao }}
                            </td>

                            <td class="text-gray-600 max-w-xs truncate">
                                {{ $log->descricao }}
                            </td>

                            <td class="text-xs text-gray-500">
                                {{ $log->ip }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $logs->links() }}
            </div>

            @endif

        </div>
    </div>
</div>

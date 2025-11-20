<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gerir Utilizadores') }}
    </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">
        @if (session()->has('message'))
        <div class="alert alert-success mb-4 shadow">
            <span>{{ session('message') }}</span>
        </div>
        @endif

        <div class="overflow-x-auto bg-base-100 shadow-xl rounded-xl p-6">
            <table class="table table-zebra">
                <thead class="text-base font-semibold text-neutral">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Ações</th>
                        <th>Histórico de Requisições</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="font-medium">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->hasRole('admin'))
                            <div class="badge badge-primary">Admin</div>
                            @else
                            <div class="badge badge-accent">Cidadão</div>
                            @endif
                        </td>
                        <td>
                            @if($user->hasRole('admin'))
                            <button wire:click="removerAdmin({{ $user->id }})" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                Remover Admin
                            </button>
                            @else
                            <button wire:click="tornarAdmin({{ $user->id }})" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                                Tornar Admin
                            </button>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.utilizador.historico', $user->id) }}" title="Ver histórico de requisições deste utilizador" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
                                Ver Histórico
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

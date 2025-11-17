<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-base-100 shadow-xl rounded-2xl p-6">

            <h2 class="text-3xl font-semibold mb-6">Gerir Utilizadores</h2>

            @if (session()->has('message'))
            <div class="alert alert-success shadow-lg mb-4">
                <span>{{ session('message') }}</span>
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead class="text-base font-semibold text-neutral">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Ações</th>
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
                                <button wire:click="tornarAdmin({{ $user->id }})"
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                                    Tornar Admin
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
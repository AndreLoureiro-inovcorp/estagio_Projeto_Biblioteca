<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Gerir Reviews
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4">

            @if (session()->has('success'))
                <div class="alert alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($reviews->isEmpty())
                <div>
                    Não há reviews para gerir.
                </div>
            @else
                <div class="space-y-6">
                    @foreach($reviews as $review)

                        <div class="card bg-base-100 shadow-xl border border-base-300">
                            <div class="card-body">

                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold">
                                            {{ $review->livro->nome }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Feita por: <strong>{{ $review->user->name }}</strong>
                                            no dia: {{ $review->created_at->format('d/m/Y') }}
                                        </p>
                                    </div>

                                    @if ($review->estado === 'suspenso')
                                        <span class="badge badge-warning">
                                            Pendente
                                        </span>
                                    @elseif ($review->estado === 'recusado')
                                        <span class="badge badge-error">
                                            Recusada
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <span class="text-2xl">
                                        {!! $review->estrelasHtml() !!}
                                    </span>
                                </div>

                                <div class="bg-base-200 p-4 rounded-lg">
                                    <p class="text-gray-700">
                                        {{ $review->comentario }}
                                    </p>
                                </div>

                                @if ($review->estado === 'recusado' && $review->justificacao_recusada)
                                    <div class="mt-4 bg-base-200 p-4 rounded-lg">
                                        <strong class="text-sm">Porque foi recusada:</strong>
                                        <p class="text-gray-700 mt-1">
                                            {{ $review->justificacao_recusada }}
                                        </p>
                                    </div>
                                @endif

                                <div class="flex gap-4 mt-6">

                                    @if ($review->estado === 'suspenso')

                                        <button
                                            wire:click="aprovar({{ $review->id }})"
                                            class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-1.5 px-3 rounded-md transition duration-200 shadow-sm">
                                            Aprovar
                                        </button>

                                        <a
                                            href="{{ route('admin.reviews.recusar', $review->id) }}"
                                            class="text-center bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-1.5 px-3 rounded-md transition duration-200 shadow-sm">
                                            Recusar
                                        </a>

                                    @elseif ($review->estado === 'recusado')

                                        <button
                                            wire:click="eliminar({{ $review->id }})"
                                            class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-1.5 px-3 rounded-md transition duration-200 shadow-sm">
                                            Eliminar
                                        </button>

                                    @endif

                                </div>

                            </div>
                        </div>

                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>


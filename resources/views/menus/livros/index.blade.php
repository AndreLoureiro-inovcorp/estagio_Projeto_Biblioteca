<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($livros as $livro)
        <div class="card bg-base-100 shadow-sm">
            <figure>
                <img src="{{ $livro->imagem_capa ?? 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp' }}"
                    alt="{{ $livro->nome }}" class="h-48 w-full object-cover" />
            </figure>
            <div class="card-body">
                <h2 class="card-title">{{ $livro->nome }}</h2>
                
                <p class="text-sm text-gray-600">
                    <strong>ISBN:</strong> {{ $livro->isbn }}
                </p>
                
                <p class="text-sm text-gray-600">
                    <strong>Editora:</strong> {{ $livro->editora->nome ?? 'N/A' }}
                </p>
                
                <p class="text-sm text-gray-600">
                    <strong>Autores:</strong>
                    @forelse ($livro->autores as $autor)
                        {{ $autor->nome }}@if (!$loop->last)
                            ,
                        @endif
                    @empty
                        <span class="italic text-gray-400">Sem autores</span>
                    @endforelse
                </p>
                
                <p class="text-sm text-gray-600">
                    <strong>Preço:</strong> €{{ number_format($livro->preco, 2, ',', '.') }}
                </p>
                
                @if ($livro->bibliografia)
                    <p class="text-sm text-gray-600">
                        <strong>Bibliografia:</strong> {{ Str::limit($livro->bibliografia, 100) }}
                    </p>
                @endif
                
                <div class="card-actions justify-end mt-4">
                    <a href="#" class="btn btn-primary btn-sm">Ver Mais</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-8">
            <p class="text-gray-500">Nenhum livro encontrado.</p>
        </div>
    @endforelse
</div>

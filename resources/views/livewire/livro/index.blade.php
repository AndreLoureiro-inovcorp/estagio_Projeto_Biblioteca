<div>
    <h2 class="text-xl font-bold mb-4">Lista de Livros</h2>

    <ul>
        @foreach ($livros as $livro)
            <li>
                <strong>{{ $livro->titulo }}</strong>
                <br>
                <span>Editora: {{ $livro->editora->nome }}</span><br>
                <span>Autores: 
                    @foreach ($livro->autores as $autor)
                        {{ $autor->nome }}@if (!$loop->last), @endif
                    @endforeach
                </span>
            </li>
        @endforeach
    </ul>
</div>


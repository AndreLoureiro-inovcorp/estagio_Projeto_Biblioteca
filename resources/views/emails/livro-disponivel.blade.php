<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Livro Disponível</title>
</head>
<body>

    <h1>O Livro já está disponível</h1>

    <div>

        <p>Olá <strong>{{ $user->name }}</strong>,</p>

        <p>
            O livro <strong>{{ $livro->nome }}</strong> que pediste já está disponível para ser requisitado!
        </p>

        <div>
            <a href="{{ route('livros.show', $livro->id) }}">
                Requisitar Agora
            </a>
        </div>

        <hr>

        <p>
            Obrigado por usares a nossa Biblioteca!
        </p>

    </div>

</body>
</html>

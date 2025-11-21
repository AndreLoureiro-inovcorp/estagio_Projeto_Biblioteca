<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lembrete de Entrega</title>
</head>
<body>
    <h1>Lembrete de Entrega</h1>

    <p>Olá {{ $requisicao->user->name }},</p>

    <p>O Último dia para fazeres a entrega do livro é amanhã: <strong>{{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</strong>.</p>

    <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
    <p><strong>Editora:</strong> {{ $requisicao->livro->editora->nome }}</p>
    <p><strong>Autores:</strong> {{ $requisicao->livro->autores->pluck('nome')->join(', ') }}</p>

    <p><strong>Número da Requisição:</strong> {{ $requisicao->numero_requisicao }}</p>

    <hr>

    <p>Obrigado por utilizares a nossa biblioteca!</p>
</body>
</html>
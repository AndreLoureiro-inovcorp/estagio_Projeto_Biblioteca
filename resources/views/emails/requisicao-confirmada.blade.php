<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Requisição Confirmada</title>
</head>
<body>
    <h1>Requisição Confirmada!</h1>

    <p>Olá {{ $requisicao->user->name }},</p>

    <p>A tua requisição foi confirmada com sucesso.</p>

    <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
    <p><strong>Data de Requisição:</strong> {{ $requisicao->data_requisicao->format('d/m/Y') }}</p>
    <p><strong>Data Prevista de Entrega:</strong> {{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</p>

    <p>Número da Requisição: <strong>{{ $requisicao->numero_requisicao }}</strong></p>

    <hr>

    <p>Obrigado por utilizares a nossa biblioteca!</p>
</body>
</html>

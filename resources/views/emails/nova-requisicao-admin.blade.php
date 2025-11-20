<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Nova Requisição</title>
</head>
<body>
    <h1>Nova Requisição Criada</h1>

    <p><strong>Cidadão:</strong> {{ $requisicao->user->name }}</p>
    <p><strong>Email:</strong> {{ $requisicao->user->email }}</p>

    <hr>

    <p><strong>Livro:</strong> {{ $requisicao->livro->nome }}</p>
    <p><strong>Editora:</strong> {{ $requisicao->livro->editora->nome }}</p>
    <p><strong>Autores:</strong>
        {{ $requisicao->livro->autores->pluck('nome')->join(', ') }}
    </p>

    <p><strong>Data de Requisição:</strong> {{ $requisicao->data_requisicao->format('d/m/Y') }}</p>
    <p><strong>Data Prevista de Entrega:</strong> {{ $requisicao->data_prevista_entrega->format('d/m/Y') }}</p>

    <p><strong>Número:</strong> {{ $requisicao->numero_requisicao }}</p>

    <hr>

    <p>Confirma a entrega assim que o livro for devolvido.</p>
</body>
</html>

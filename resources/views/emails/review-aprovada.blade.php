<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Review Aprovada</title>
</head>
<body>
    <h1> A Tua Review Foi Aprovada!</h1>

    <p>Olá {{ $review->user->name }},</p>

    <p>Temos o prazer de informar que a tua review do livro <strong>{{ $review->livro->nome }}</strong> foi aprovada e já está visível para outros utilizadores!</p>

    <hr>

    <p>Obrigado! A tua opinião ajuda outros leitores a descobrir bons livros!</p>

</body>
</html>

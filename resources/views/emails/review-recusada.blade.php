<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Review Não Aprovada</title>
</head>
<body>
    <h1>A Tua Review Não Foi Aprovada</h1>

    <p>Olá {{ $review->user->name }},</p>

    <p>Lamentamos informar que a tua review do livro <strong>{{ $review->livro->nome }}</strong> não foi aprovada pela nossa equipa de moderação.</p>

    <hr>

    <h2>Porque foi recusada:</h2>
    
    <div>
        <p>{{ $review->justificacao_recusada }}</p>
    </div>

    <hr>

    <p>Podes submeter uma nova review tendo em conta o feedback fornecido.</p>

    <p>Agradecemos a tua compreensão!</p>

</body>
</html>
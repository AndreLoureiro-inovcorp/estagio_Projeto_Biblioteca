<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Nova Review Submetida</title>
</head>
<body>
    <h1>Nova Review Submetida!</h1>

    <p>Uma nova review foi submetida por <strong>{{ $review->user->name }}</strong> e aguarda aprovação.</p>

    <hr>

    <h2>Detalhes da Review:</h2>

    <p><strong>Livro:</strong> {{ $review->livro->nome }}</p>
    
    <p><strong>Classificação:</strong> {{ $review->classificacao }}/5 ⭐</p>
    
    <p><strong>Comentário:</strong></p>
    <blockquote>
        {{ $review->comentario }}
    </blockquote>

    <p><strong>Data de Submissão:</strong> {{ $review->created_at->format('d/m/Y H:i') }}</p>

    <hr>

    <p><strong>Utilizador:</strong> {{ $review->user->name }} ({{ $review->user->email }})</p>

    <hr>

    <p>Obrigado por utilizares a nossa biblioteca!</p>
</body>
</html>
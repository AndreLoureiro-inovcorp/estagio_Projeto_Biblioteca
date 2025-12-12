<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho Abandonado</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5;">

    <p>Olá <strong>{{ $user->name }}</strong>,</p>

    <p>
        Reparámos que adicionaste alguns livros ao carrinho, mas ainda não finalizaste a compra.
        Se precisares de ajuda ou tiveres alguma dúvida, estamos aqui para ajudar!
    </p>

    <p>
        Para voltares ao teu carrinho basta clicares no link abaixo:
    </p>

    <p>
        <a href="{{ route('carrinho.ver') }}">
            Ver Carrinho
        </a>
    </p>

    <p>
        Obrigado por usares a nossa Biblioteca!
    </p>

</body>
</html>

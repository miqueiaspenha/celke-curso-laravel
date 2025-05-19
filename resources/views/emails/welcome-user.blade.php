<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bem-vindo!</title>
</head>
<body>
    <p>Olá, {{ $user->name }},</p>

    <p>Seja bem-vindo ao nosso sistema.</p>

    <p>Seu login: {{ $user->email }}</p>
    <p>Sua senha: {{ $password }}</p>

    <p>Por favor, altere sua senha após o primeiro login.</p>
</body>
</html>

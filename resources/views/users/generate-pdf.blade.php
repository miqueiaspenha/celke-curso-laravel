<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalhes do Usuário</title>
</head>

<body>
    <div>
        <h1>Detalhes do Usuário</h1>
        <p><strong>ID:</strong> {{ $user->id }}</p>
        <p><strong>Nome:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Data de Criação:</strong> {{ $user->created_at->format('d/m/Y H:i:s') }}</p>
        <p><strong>Data de Atualização:</strong> {{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalhes dos Usuários</title>
</head>

<body style="font-size: 12px;">
    <div>
        <h1 style="text-align: center;">Detalhes dos Usuários</h1>

        <table style="border-collapse: collapse; width: 100%">
            <thead>
                <tr style="background-color: #adb5db;">
                    <th style="border: 1px solid #ccc">ID</th>
                    <th style="border: 1px solid #ccc">Nome</th>
                    <th style="border: 1px solid #ccc">E-mail</th>
                    <th style="border: 1px solid #ccc">Cadastrado em</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td style="border: 1px solid #ccc; border-top: none;">{{ $user->id }}</td>
                        <td style="border: 1px solid #ccc; border-top: none;">{{ $user->name }}</td>
                        <td style="border: 1px solid #ccc; border-top: none;">{{ $user->email }}</td>
                        {{-- <td style="border: 1px solid #ccc; border-top: none;">{{ $user->created_at->format('d/m/Y H:i:s') }}</td> --}}
                        <td style="border: 1px solid #ccc; border-top: none;">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td style="border: 1px solid #ccc; border-top: none;" colspan="4">Nenhum usuário encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>

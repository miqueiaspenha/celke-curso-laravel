<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite(['resources/css/app.css'])
</head>

<body>
    <div class="main-container">

        <header class="header">
            <div class="content-header">
                <div class="title-logo">
                    <a href="{{ route('dashboard') }}">Miqueias</a>
                </div>
                <ul class="list-nav-link">
                    <li>
                        <a href="{{ route('user.index') }}" class="nav-link">Listar Usuários</a>
                    </li>
                    <li>
                        <a href="{{ route('user.create') }}" class="nav-link">Cadastrar Usuários</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}" class="nav-link">Sair</a>
                    </li>
                </ul>
            </div>
        </header>
        
        @yield('content')
    </div>
</body>

</html>

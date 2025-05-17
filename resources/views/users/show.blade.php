@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Detalhes do Usuário</h1>
            <div>
                <a href="{{ route('user.index') }}" class="btn-info">Listar</a>
                <a href="{{ route('user.edit', ['user' => $user]) }}" class="btn-warning">Editar</a>
                <a href="{{ route('user.editPassword', ['user' => $user]) }}" class="btn-warning">Editar Senha</a>
            </div>
        </div>

        <x-alert />

        <div class="details-container">
            <h2 class="details-title">Informações do Usuário</h2>

            <div class="details-data">
                <span class="details-title-data">ID:</span>
                <span>{{ $user->id }}</span>
            </div>
            <div class="details-data">
                <span class="details-title-data">Nome:</span>
                <span>{{ $user->name }}</span>
            </div>
            <div class="details-data">
                <span class="details-title-data">E-mail:</span>
                <span>{{ $user->email }}</span>
            </div>
            <div class="details-data">
                <span class="details-title-data">Criado em:</span>
                <span>{{ $user->created_at->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="details-data">
                <span class="details-title-data">Atualizado em:</span>
                <span>{{ $user->updated_at->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>
    </div>
@endsection

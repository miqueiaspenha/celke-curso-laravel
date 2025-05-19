@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Detalhes do Usuário</h1>
            <div class="page-submenu">
                <a href="{{ route('user.generatePdf', ['user' => $user]) }}" class="btn-primary">Gerar PDF</a>
                <a href="{{ route('user.index') }}" class="btn-info">Listar</a>
                <a href="{{ route('user.edit', ['user' => $user]) }}" class="btn-warning">Editar</a>
                <a href="{{ route('user.editPassword', ['user' => $user]) }}" class="btn-warning">Editar Senha</a>
                <form id="delete-form-{{ $user->id }}" action="{{ route('user.destroy', ['user' => $user]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-danger"
                        onclick="confirmDelete({{ $user->id }})">Apagar</button>
                </form>
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
                <span>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="details-data">
                <span class="details-title-data">Atualizado em:</span>
                <span>{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>
    </div>
@endsection

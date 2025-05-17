@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Editar Senha</h1>
            <a href="{{ route('user.index') }}" class="btn-info">Listar</a>
        </div>

        <x-alert />

        <form action="{{ route('user.updatePassword', ['user' => $user->id]) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="new_password" class="form-label">Nova Senha</label>
                <input type="password" name="new_password" id="new_password" placeholder="Informe a nova senha" class="form-input">
            </div>

            <div class="mb-4">
                <label for="new_password_confirmation" class="form-label">Confirmação de senha</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirme a nova senha" class="form-input">
            </div>

            <button type="submit" class="btn-warning">Salvar</button>

        </form>
    </div>
@endsection

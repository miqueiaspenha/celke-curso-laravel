@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Bem-vindo a Miqueias!</h1>
            <a href="{{ route('user.create') }}" class="btn-primary">Cadastrar Usuário</a>
        </div>
    </div>
@endsection

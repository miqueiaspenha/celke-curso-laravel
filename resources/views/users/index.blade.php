@extends('layouts.admin')

@section('content')
    <div class="content">

        <div class="content-title">
            <h1 class="page-title">Listar Usuários</h1>
            <a href="{{ route('user.create') }}" class="btn-success">Cadastrar</a>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="table-header">
                        <th class="table-header">ID</th>
                        <th class="table-header">Nome</th>
                        <th class="table-header">Email</th>
                        <th class="table-header">Ações</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @forelse ($users as $user)
                        <tr class="table-row">
                            <td class="table-cell">{{ $user->id }}</td>
                            <td class="table-cell">{{ $user->name }}</td>
                            <td class="table-cell">{{ $user->email }}</td>
                            <td class="table-actions">
                                <a href="#" class="btn-primary">Visualizar</a>
                                <a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn-warning">Editar</a>
                                <a href="#" class="btn-danger">Apagar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>Nenhum usuário cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
@endsection

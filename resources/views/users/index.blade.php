@extends('layouts.admin')

@section('content')
    <div class="content">

        <div class="content-title">
            <h1 class="page-title">Listar Usuários</h1>
            <div>
                <a href="{{ route('user.create') }}" class="btn-success">Cadastrar</a>
            </div>
        </div>

        <x-alert />

        <form class="pb-2 grid xl:grid-cols-5 md:grid-cols-2 gap-2 items-end">
            <input type="text" name="name" id="name" class="form-input" placeholder="Informe o nome" value="{{ request('name') }}">
            <input type="text" name="email" id="email" class="form-input" placeholder="Informe o email" value="{{ request('email') }}">

            <div class="flex gap-1">
                <button type="submit" class="btn-primary">Pesquisar</button>
                <a href="{{ route('user.index') }}" class="btn-warning">Limpar</a>
            </div>
        </form>

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
                                <a href="{{ route('user.show', ['user' => $user]) }}" class="btn-primary">Visualizar</a>
                                <a href="{{ route('user.edit', ['user' => $user]) }}" class="btn-warning">Editar</a>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('user.destroy', ['user' => $user]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-danger" onclick="confirmDelete({{ $user->id }})">Apagar</button>
                                </form>
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

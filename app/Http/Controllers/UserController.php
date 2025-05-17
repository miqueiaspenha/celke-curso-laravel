<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderByDesc('id')->paginate(1);
        return view('users.index', ['users' => $users]);
    }
    
    public function create()
    {
        return view('users.create');
    }

    public function store(CreateUserRequest $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            return redirect()->route('user.create')->with('success', 'Usuário cadastrado com sucessso!');
        }
        catch(Exception $ex)
        {
            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }

    public function edit(User $user) {
        return view('users.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user) {

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            return redirect()->route('user.edit', ['user' => $user])->with('success', 'Usuário atualizado com sucesso.');
        }
        catch(Exception $ex)
        {
            return back()->withInput()->with('error', 'Usuário não editado!');
        }
    }
}

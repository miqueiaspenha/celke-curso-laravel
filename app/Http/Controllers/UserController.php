<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function index()
    {
        $users = User::orderByDesc('id')->paginate(3);
        return view('users.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    
    public function create()
    {
        return view('users.create');
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            return redirect()->route('user.show', ['user' => $user])->with('success', 'Usuário cadastrado com sucessso!');
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
            return redirect()->route('user.show', ['user' => $user])->with('success', 'Usuário atualizado com sucesso.');
        }
        catch(Exception $ex)
        {
            return back()->withInput()->with('error', 'Usuário não editado!');
        }
    }

    public function editPassword(User $user)
    {
        return view('users.edit_password', ['user' => $user]);
    }

    public function updatePassword(UpdateUserPasswordRequest $request, User $user)
    {
        try {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('user.show', ['user' => $user])->with('success', 'Senha alterada com sucesso.');
        }
        catch(Exception $ex)
        {
            return back()->with('error', 'Senha não alterada!');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Usuários deletado com sucesso.');
        }
        catch(Exception $ex)
        {
            return redirect()->route('user.index')->with('error', 'Usuário não excluído.');
        }
    }

    public function generatePdf(User $user)
    {
        try {
            $pdf = Pdf::loadView('users.generate_pdf', ['user' => $user]);
            $pdf->setPaper('A4', 'portrait');

            $pdfPath = storage_path('app/public/user_' . $user->id . '.pdf');
            $pdf->save($pdfPath);

            Mail::to($user->email)->send(new \App\Mail\UserPdfMail($pdfPath, $user));

            if(file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            return redirect()->route('user.show', ['user' => $user])->with('success', 'PDF enviado para o e-mail do usuário com sucesso.');
        }
        catch(Exception $ex)
        {
            dd($ex->getMessage());
            return redirect()->route('user.show', ['user' => $user])->with('error', 'Erro ao gerar o PDF.');
        }
    }
}

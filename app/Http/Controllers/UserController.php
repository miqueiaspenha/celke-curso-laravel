<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Svg\Tag\Rect;

class UserController extends Controller
{

    const ITENS_PAR_PAGE = 20;

    public function index(Request $request)
    {
        // $users = User::orderByDesc('id')->paginate(3);

        $users = User::when(
            $request->filled('name'),
            fn($query) =>
            $query->whereLike('name', '%' . $request->input('name') . '%')
        )
            ->when(
                $request->filled('email'),
                fn($query) =>
                $query->whereLike('email', '%' . $request->input('email') . '%')
            )
            ->when(
                $request->filled('start_date_registration'),
                fn($query) =>
                $query->where('created_at', '>=', \Carbon\Carbon::parse($request->input('start_date_registration')))
            )
            ->when(
                $request->filled('end_date_registration'),
                fn($query) =>
                $query->where('created_at', '<=', \Carbon\Carbon::parse($request->input('end_date_registration')))
            )
            ->orderByDesc('id')
            ->paginate(self::ITENS_PAR_PAGE)
            ->withQueryString();

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
        } catch (Exception $ex) {
            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            return redirect()->route('user.show', ['user' => $user])->with('success', 'Usuário atualizado com sucesso.');
        } catch (Exception $ex) {
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
        } catch (Exception $ex) {
            return back()->with('error', 'Senha não alterada!');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Usuários deletado com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('user.index')->with('error', 'Usuário não excluído.');
        }
    }

    public function generatePdf(User $user)
    {
        try {
            $pdf = Pdf::loadView('users.generate-pdf', ['user' => $user]);
            $pdf->setPaper('A4', 'portrait');

            $pdfPath = storage_path('app/public/user_' . $user->id . '.pdf');
            $pdf->save($pdfPath);

            Mail::to($user->email)->send(new \App\Mail\UserPdfMail($pdfPath, $user));

            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            return redirect()->route('user.show', ['user' => $user])->with('success', 'PDF enviado para o e-mail do usuário com sucesso.');
        } catch (Exception $ex) {
            return redirect()->route('user.show', ['user' => $user])->with('error', 'Erro ao gerar o PDF.');
        }
    }

    public function generatePdfUsers(Request $request)
    {
        try {
            $users = User::when(
                $request->filled('name'),
                fn($query) =>
                $query->whereLike('name', '%' . $request->input('name') . '%')
            )
                ->when(
                    $request->filled('email'),
                    fn($query) =>
                    $query->whereLike('email', '%' . $request->input('email') . '%')
                )
                ->when(
                    $request->filled('start_date_registration'),
                    fn($query) =>
                    $query->where('created_at', '>=', \Carbon\Carbon::parse($request->input('start_date_registration')))
                )
                ->when(
                    $request->filled('end_date_registration'),
                    fn($query) =>
                    $query->where('created_at', '<=', \Carbon\Carbon::parse($request->input('end_date_registration')))
                )
                ->orderByDesc('name')
                ->get();

            $pdf = Pdf::loadView('users.generate-pdf-users', ['users' => $users])
                ->setPaper('A4', 'portrait');

            $totalRecords = $users->count('id');
            $numbersRecordsAllowed = 10;

            if ($totalRecords > $numbersRecordsAllowed) {
                return redirect()->route('user.index', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'start_date_registration' => $request->start_date_registration,
                    'end_date_registration' => $request->end_date_registration,
                ])->with('error', "O limite máximo de registros por PDF é de {$numbersRecordsAllowed}. Diminua a quantidade de registros.");
            }

            return $pdf->download('listar_usuarios.pdf');
        } catch (Exception $ex) {
            // return redirect()->route('user.index', [
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'start_date_registration' => $request->start_date_registration,
            //     'end_date_registration' => $request->end_date_registration,
            // ])->with('error', 'Ocorreu um erro ao gerar o PDF');
            return back()->withInput()->with('error', 'Ocorreu um erro ao gerar o PDF');
        }
    }

    function generateCsvUsers(Request $request)
    {
        try {
            $users = User::when(
                $request->filled('name'),
                fn($query) =>
                $query->whereLike('name', '%' . $request->input('name') . '%')
            )
                ->when(
                    $request->filled('email'),
                    fn($query) =>
                    $query->whereLike('email', '%' . $request->input('email') . '%')
                )
                ->when(
                    $request->filled('start_date_registration'),
                    fn($query) =>
                    $query->where('created_at', '>=', \Carbon\Carbon::parse($request->input('start_date_registration')))
                )
                ->when(
                    $request->filled('end_date_registration'),
                    fn($query) =>
                    $query->where('created_at', '<=', \Carbon\Carbon::parse($request->input('end_date_registration')))
                )
                ->orderByDesc('name')
                ->get();

            $totalRecords = $users->count('id');
            $numbersRecordsAllowed = 2;

            if ($totalRecords > $numbersRecordsAllowed) {
                return redirect()->route('user.index', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'start_date_registration' => $request->start_date_registration,
                    'end_date_registration' => $request->end_date_registration,
                ])->with('error', "O limite máximo de registros por CSV é de {$numbersRecordsAllowed}. Diminua a quantidade de registros.");
            }

            $csvFileName = tempnam(sys_get_temp_dir(), 'csv_' . Str::ulid());

            $openFile = fopen($csvFileName, 'w');

            $header = ['Id', 'Nome', 'Email', 'Data de cadastro'];

            fputcsv($openFile, $header, ';');

            foreach($users as $user){
                $userArray = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->format('d/m/Y H:i:s'),
                ];
                fputcsv($openFile, $userArray, ';');
            }

            fclose($openFile);

            return response()->download($csvFileName, 'lista_usuarios' . Str::ulid() . '.csv');
        } catch (Exception $ex) {
            // return redirect()->route('user.index', [
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'start_date_registration' => $request->start_date_registration,
            //     'end_date_registration' => $request->end_date_registration,
            // ])->with('error', 'Ocorreu um erro ao gerar o PDF');
            return back()->withInput()->with('error', 'Ocorreu um erro ao gerar o CSV');
        }
    }
}

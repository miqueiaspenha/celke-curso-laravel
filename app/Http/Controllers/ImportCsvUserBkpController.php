<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportCsvUserController extends Controller
{
    public function importCsvUsers(Request $request)
    {
        try
        {
            $request->validate([
                'file' => ['required', 'mimes:csv,txt', 'max:2048']
            ],
            [
                'file.required' => 'O campo arquivo é obrigatório',
                'file.mimes' => 'Arquivo inválido, necessário enviar um arquivo CSV',
                'file.max' => 'O tamanho do arquivo execede :max Mb',
            ]);

            $headers = ['name', 'email', 'password'];

            $fileData = array_map('str_getcsv', file($request->file('file')));

            $separator = ';';

            $arrayValues = [];

            $duplicatedEmails = [];

            $numberRegisteredRecords = 0;

            foreach($fileData as $row) {
                $values = explode($separator, $row[0]);

                if(count($values) !== count($headers)) {
                    continue;
                }

                $userData = array_combine($headers, $values);

                $emailExists = User::where('email', $userData['email'])->exists();

                if($emailExists){
                    $duplicatedEmails[] = $userData['email'];
                    continue;
                }

                $arrayValues[] = [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make(Str::random(7), ['rounds' => 12]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $numberRegisteredRecords++;
            }

            if(!empty($duplicatedEmails)) {
                return back()->withInput()->with('error', 'Dados não importados. Existem e-mails já cadastrados: <br> ' . implode('<br>', $duplicatedEmails));
            }

            User::insert($arrayValues);

            return back()->withInput()->with('success', 'Dados insridos com sucesso. <br> Quantidade: ' . $numberRegisteredRecords);
        }
        catch(Exception $ex)
        {
            return back()->withInput()->with('error', 'Erro ao importar CSV');
        }
    }
}

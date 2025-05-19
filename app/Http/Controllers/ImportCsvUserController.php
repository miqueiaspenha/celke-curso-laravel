<?php

namespace App\Http\Controllers;

use App\Jobs\ImportCsvJob;
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

            $fileName = 'import-' . now()->format('Y-m-d-H-i-s') . '.csv';

            $path = $request->file('file')->storeAs('uploads', $fileName);

            ImportCsvJob::dispatch($path);

            return back()->withInput()->with('success', 'Os dados estão sendo importados.');
        }
        catch(Exception $ex)
        {
            return back()->withInput()->with('error', 'Erro ao importar CSV');
        }
    }
}

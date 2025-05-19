<?php

namespace App\Jobs;

use App\Mail\WelcomeUserMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use League\Csv\Reader;
use League\Csv\Statement;

class ImportCsvJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $filePath)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filePath = storage_path('app/private/' . $this->filePath);

        if (!file_exists($filePath)) {
            return;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $records = (new Statement())->process($csv);

        $delaySeconds = 0;

        // $batchInsert = [];

        foreach ($records as $record) {
            $email = $record['email'] ?? null;
            $name = $record['name'] ?? null;

            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            if (User::where('email', $email)->exists()) {
                continue;
            }

            $password = Str::random(7);

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            // Mail::to($email)->send(new WelcomeUserMail($user, $password));

            // Mail::to($email)->queue(new WelcomeUserMail($user, $password));

            Mail::to($email)->later(now()->addSeconds($delaySeconds), new WelcomeUserMail($user, $password));
            $delaySeconds += 10;

            // $batchInsert[] = [
            //     'name' => $name,
            //     'email' => $email,
            //     'password' => Hash::make(Str::random(7), ['rounds' => 12]),
            // ];

            // if (count($batchInsert) >= 50) {
            //     User::insert($batchInsert);
            //     $batchInsert = [];
            // }
        }

        // if (!empty($batchInsert)) {
        //     User::insert($batchInsert);
        //     $batchInsert = [];
        // }
    }
}

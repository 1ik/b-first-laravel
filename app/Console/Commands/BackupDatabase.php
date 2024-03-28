<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'By this command we keep backup of database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $backupFileName = 'backup_database.sql';
        $folder_dir = 'backup_sql';
        $fileLocation = $folder_dir.'/'.$backupFileName;

        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        if (!File::exists(storage_path('app/'.$folder_dir))) {
            File::makeDirectory(storage_path('app/'.$folder_dir));
        }
        
        $backupPath = storage_path('app/' . $fileLocation); 

        $command = "mysqldump --host={$host} --port={$port} --user={$username} --password={$password} {$database} > {$backupPath}";

        exec($command);

        $spaceDisk = Storage::disk('do_spaces')->put($fileLocation,file_get_contents($backupPath), 'public');

        //unlink($backupPath);

        Log::info("Database backup created and uploaded: $backupFileName");
    }
}

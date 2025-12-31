<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:sql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database as plain .sql file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $db = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $folder = storage_path('app/public/databaseBackups');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $path = $folder . '/backup_' . now()->format('Y-m-d_H-i-s') . '.sql';

        $command = "mysqldump -h {$host} -u {$user} --password=\"{$pass}\" {$db} > {$path}";
        exec($command, $output, $return_var);

        if ($return_var === 0) {
            $this->line($path);
        } else {
            $this->error("❌ Backup failed!");
        }
    }

}

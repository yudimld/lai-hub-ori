<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportMongoToJSON extends Command
{
    protected $signature = 'mongo:export';
    protected $description = 'Export MongoDB collections to JSON';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $collections = ['edc', 'users']; // Daftar koleksi MongoDB
        $db = 'lai-hub'; // Nama database
        $exportPath = storage_path('exports'); // Path penyimpanan file JSON

        // Buat folder jika belum ada
        if (!is_dir($exportPath)) {
            mkdir($exportPath, 0755, true);
        }

        foreach ($collections as $collection) {
            $filePath = $exportPath . '/' . $collection . '.json';

            // Jalankan perintah mongoexport
            $command = "mongoexport --db=$db --collection=$collection --out=$filePath";
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                $this->info("Exported $collection to $filePath");
            } else {
                $this->error("Failed to export $collection. Error: " . implode("\n", $output));
            }
        }
    }
}

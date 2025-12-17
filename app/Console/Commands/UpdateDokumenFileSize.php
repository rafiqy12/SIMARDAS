<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Dokumen;

class UpdateDokumenFileSize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dokumen:update-size {--force : Update all documents, including those with existing size}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update ukuran_file for all existing documents based on actual file size';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating document file sizes...');
        
        $query = Dokumen::query();
        
        // If not forced, only update documents with null ukuran_file
        if (!$this->option('force')) {
            $query->whereNull('ukuran_file');
        }
        
        $documents = $query->get();
        
        if ($documents->isEmpty()) {
            $this->info('No documents to update.');
            return 0;
        }
        
        $bar = $this->output->createProgressBar($documents->count());
        $bar->start();
        
        $updated = 0;
        $notFound = 0;
        
        foreach ($documents as $doc) {
            $path = storage_path('app/public/' . $doc->path_file);
            
            if (file_exists($path)) {
                $doc->ukuran_file = filesize($path);
                $doc->save();
                $updated++;
            } else {
                $notFound++;
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("Updated: {$updated} documents");
        if ($notFound > 0) {
            $this->warn("File not found: {$notFound} documents");
        }
        
        return 0;
    }
}

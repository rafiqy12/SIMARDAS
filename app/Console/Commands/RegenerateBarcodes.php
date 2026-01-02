<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Dokumen;
use App\Models\Barcode;

class RegenerateBarcodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'barcode:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate all barcodes from existing documents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $documents = Dokumen::all();
        $count = 0;

        foreach ($documents as $doc) {
            try {
                // Generate unique barcode code
                $barcodeCode = 'DOC' . str_pad($doc->id_dokumen, 7, '0', STR_PAD_LEFT);
                
                // Delete old barcode if exists
                Barcode::where('id_dokumen', $doc->id_dokumen)->delete();
                
                // Create new barcode
                Barcode::create([
                    'id_dokumen' => $doc->id_dokumen,
                    'kode_barcode' => $barcodeCode
                ]);
                
                $count++;
                $this->line("✓ Barcode generated for dokumen ID: {$doc->id_dokumen} - Code: {$barcodeCode}");
            } catch (\Exception $e) {
                $this->error("✗ Error generating barcode for dokumen ID {$doc->id_dokumen}: {$e->getMessage()}");
            }
        }

        $this->info("\n" . str_repeat('=', 50));
        $this->info("Total barcodes regenerated: {$count}");
        $this->info(str_repeat('=', 50));
    }
}

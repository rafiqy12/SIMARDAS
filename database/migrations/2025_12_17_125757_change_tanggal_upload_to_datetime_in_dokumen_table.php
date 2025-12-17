<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah kolom tanggal_upload dari DATE ke DATETIME
        DB::statement('ALTER TABLE dokumen MODIFY tanggal_upload DATETIME NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke DATE
        DB::statement('ALTER TABLE dokumen MODIFY tanggal_upload DATE NULL');
    }
};

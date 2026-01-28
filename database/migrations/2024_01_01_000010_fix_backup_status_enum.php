<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration fixes the backup status ENUM to include all valid values.
     * The original migration had ['pending', 'completed', 'failed'] but code was inserting 'success'.
     * We now support both 'success' (legacy) and 'completed' (new standard).
     */
    public function up(): void
    {
        // Alter ENUM to include 'success' for backwards compatibility
        // Also update any existing 'success' entries to 'completed'
        DB::statement("ALTER TABLE `backup` MODIFY COLUMN `status` ENUM('pending', 'completed', 'failed', 'success') DEFAULT 'pending'");
        
        // Update any legacy 'success' entries to 'completed' for consistency
        DB::statement("UPDATE `backup` SET `status` = 'completed' WHERE `status` = 'success'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First ensure all 'success' entries are converted to 'completed'
        DB::statement("UPDATE `backup` SET `status` = 'completed' WHERE `status` = 'success'");
        
        // Then revert to original ENUM
        DB::statement("ALTER TABLE `backup` MODIFY COLUMN `status` ENUM('pending', 'completed', 'failed') DEFAULT 'pending'");
    }
};

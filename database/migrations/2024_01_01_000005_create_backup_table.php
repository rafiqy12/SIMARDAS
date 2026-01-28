<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('backup', function (Blueprint $table) {
            $table->bigIncrements('id_backup');
            $table->unsignedBigInteger('id_user');
            $table->dateTime('tanggal_backup')->useCurrent();
            $table->string('lokasi_file', 255);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->bigInteger('ukuran_file')->nullable();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('user')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup');
    }
};

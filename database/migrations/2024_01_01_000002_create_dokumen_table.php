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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->bigIncrements('id_dokumen');
            $table->string('judul', 255);
            $table->text('deskripsi')->nullable();
            $table->string('kategori', 255)->nullable();
            $table->string('tipe_file', 50);
            $table->dateTime('tanggal_upload')->useCurrent();
            $table->string('path_file', 255);
            $table->bigInteger('ukuran_file')->nullable();
            $table->unsignedBigInteger('id_user');

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
        Schema::dropIfExists('dokumen');
    }
};

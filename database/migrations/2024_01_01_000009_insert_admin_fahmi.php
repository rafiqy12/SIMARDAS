<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('user')->insert([
            'nama' => 'fahmi',
            'username' => 'fahmi',
            'email' => 'fahmi@gmail.com',
            'password' => Hash::make('chaewon'),
            'role' => 'Admin',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('user')->where('username', 'fahmi')->delete();
    }
};

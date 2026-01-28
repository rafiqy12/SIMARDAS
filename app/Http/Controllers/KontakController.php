<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KontakController
{
    /**
     * Tampilkan halaman kontak
     */
    public function index()
    {
        return view('pages.public.kontak');
    }
}

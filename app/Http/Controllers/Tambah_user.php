<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Tambah_user
{
    function ShowTambahUserPage()
    {
        return view('pages.tambah_user');
    }
}

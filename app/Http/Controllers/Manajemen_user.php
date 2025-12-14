<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Manajemen_user
{
    public function ShowManajemenUserPage()
    {
        return view('pages.manajemen_user');
    }
}

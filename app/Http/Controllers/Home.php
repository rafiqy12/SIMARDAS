<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home
{
    public function ShowHomePage()
    {
        return view('pages.home');
    }
}

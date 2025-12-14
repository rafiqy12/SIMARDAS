<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Register
{
    public function ShowRegisterpage()
    {
        return view('pages.register');
    }
}

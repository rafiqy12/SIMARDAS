<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController
{
    public function showLoginPage()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        // Handle login logic here
    }
}

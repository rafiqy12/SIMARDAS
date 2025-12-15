<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Manajemen_user
{
    public function ShowManajemenUserPage()
    {
        $users = User::all();
        return view('pages.manajemen_user', compact('users'));
    }
}

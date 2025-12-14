<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard
{
    public function ShowDashboardPage()
    {
        return view('pages.dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Search
{
    public function ShowSearchPage()
    {
        return view('pages.search');
    }
}

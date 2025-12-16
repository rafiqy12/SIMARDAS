<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Edit_user
{
    function showEditUserPage()
    {
        return view('pages.edit_user');
    }
}

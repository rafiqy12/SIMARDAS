<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dokumen_detail
{
    public function ShowDokumenDetailPage()
    {
        return view('pages.dokumen_detail');
    }
}

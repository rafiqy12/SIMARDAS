<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Scan_dokumen
{
    public function ShowScanDokumenPage()
    {
        return view('pages.scan_dokumen');
    }
}

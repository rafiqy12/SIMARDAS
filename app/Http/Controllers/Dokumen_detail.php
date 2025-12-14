<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;

class Dokumen_detail
{
    public function ShowDokumenDetailPage($id)
    {
        $document = Dokumen::findOrFail($id);

        return view('pages.dokumen_detail', compact('document'));
    }
}

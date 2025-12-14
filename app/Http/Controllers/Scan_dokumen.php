<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\Support\Str;

class Scan_dokumen
{
    public function ShowScanDokumenPage()
    {
        return view('pages.scan_dokumen');
    }

    public function store(Request $request)
    {
        $request->validate([
            'scan_file' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string',
        ]);

        $file = $request->file('scan_file');
        $judulSlug = Str::slug($request->judul);
        $fileName = $judulSlug . '_' . time() . '.' . $file->getClientOriginalExtension();

        // simpan di folder public/documents
        $path = $file->storeAs('documents', $fileName, 'public');

        Dokumen::create([
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'kategori'       => $request->kategori,
            'tipe_file'      => $file->getClientOriginalExtension(),
            'tanggal_upload' => now(),
            'path_file'      => $path, // simpan path relatif storage
            'id_user'        => 2,
        ]);

        return redirect()
            ->route('scan_dokumen.page')
            ->with('success', 'Dokumen berhasil discan dan diupload');
    }
}

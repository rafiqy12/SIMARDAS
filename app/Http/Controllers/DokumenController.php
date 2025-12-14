<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;


class DokumenController
{

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|string',
            'file'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // nama file unik
        $file = $request->file('file');
        $fileName = Str::slug($request->judul) . '_' . time() . '.' . $file->getClientOriginalExtension();

        // simpan file
        $path = $file->storeAs('documents', $fileName);

        // simpan ke DB
        Dokumen::create([
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'kategori'       => $request->kategori,
            'tipe_file'      => $file->getClientOriginalExtension(),
            'tanggal_upload' => now(),
            'path_file'      => $path,
            'id_user'        => auth()->id() ?? 1,
        ]);

        return redirect()->route('dokumen.scan')
            ->with('success', 'Dokumen berhasil diupload');
    }
}

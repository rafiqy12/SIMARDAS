<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Dokumen_upload
{
    // TAMPILKAN HALAMAN UPLOAD
    public function showDokumenUploadPage()
    {
        return view('pages.dokumen_upload');
    }

    // PROSES UPLOAD
    public function store(Request $request)
    {
        $request->validate([
            'dokumen'  => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi'=> 'nullable|string'
        ]);

        $file = $request->file('dokumen');
        $ext  = $file->getClientOriginalExtension();

        // Nama file aman & konsisten
        $namaFile = \Str::slug($request->judul) . '_' . time() . '.' . $ext;

        $path = $file->storeAs('documents', $namaFile, 'public');

        Dokumen::create([
            'id_user'        => auth()->user()->id_user,
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'kategori'       => $request->kategori,
            'tipe_file'      => $ext,
            'tanggal_upload' => now()->toDateString(),
            'path_file'      => $path
        ]);

        // log aktivitas
        \DB::table('log_aktivitas')->insert([
            'id_user' => auth()->user()->id_user,
            'waktu_aktivitas' => now(),
            'jenis_aktivitas' => 'Upload Dokumen',
            'deskripsi' => 'Upload dokumen: ' . $request->judul
        ]);

        return back()->with('success', 'Dokumen berhasil diupload');
    }
}

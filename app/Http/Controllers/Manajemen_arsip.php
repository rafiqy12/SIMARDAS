<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class Manajemen_arsip
{
    /**
     * Tampilkan halaman manajemen arsip
     */
    public function index()
    {
        $dokumens = Dokumen::with('user')->orderBy('tanggal_upload', 'desc')->get();
        return view('pages.manajemen_arsip', compact('dokumens'));
    }

    /**
     * Tampilkan form edit dokumen
     */
    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('pages.edit_arsip', compact('dokumen'));
    }

    /**
     * Update dokumen
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $dokumen = Dokumen::findOrFail($id);
        $dokumen->judul = $request->judul;
        $dokumen->kategori = $request->kategori;
        $dokumen->deskripsi = $request->deskripsi;
        $dokumen->save();

        return redirect()->route('manajemen_arsip.page')->with('success', 'Dokumen berhasil diupdate');
    }

    /**
     * Hapus dokumen
     */
    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        // Hapus data terkait di tabel barcode terlebih dahulu
        DB::table('barcode')->where('id_dokumen', $id)->delete();

        // Hapus file dari storage
        if ($dokumen->path_file && Storage::disk('public')->exists($dokumen->path_file)) {
            Storage::disk('public')->delete($dokumen->path_file);
        }

        $dokumen->delete();

        return redirect()->route('manajemen_arsip.page')->with('success', 'Dokumen berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Dokumen;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;


class DokumenController
{
    /**
     * Halaman pencarian dokumen
     */
    public function search(Request $request)
    {
        $query = Dokumen::with('user');

        // Keyword (judul + deskripsi)
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->q . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
            });
        }

        // Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Tipe dokumen
        if ($request->filled('tipe')) {
            $query->where('tipe_file', strtolower($request->tipe));
        }

        // Diunggah oleh
        if ($request->filled('user')) {
            $query->where('id_user', $request->user);
        }

        // Filter tanggal
        if ($request->filled('start')) {
            $query->whereDate('tanggal_upload', '>=', $request->start);
        }

        if ($request->filled('end')) {
            $query->whereDate('tanggal_upload', '<=', $request->end);
        }

        $sort = $request->get('sort', 'desc');

        if ($sort === 'nama') {
            $query->orderBy('judul', 'asc');
        } else {
            $query->orderBy('tanggal_upload', $sort);
        }

        $documents = $query->get()->map(function ($doc) {
            return (object)[
                'id'           => $doc->id_dokumen,
                'title'        => $doc->judul,
                'description'  => $doc->deskripsi,
                'category'     => $doc->kategori,
                'type'         => strtoupper($doc->tipe_file),
                'uploaded_at'  => $doc->tanggal_upload,
                'uploaded_by'  => $doc->user->nama ?? '-',
                'file_size'    => '-'
            ];
        });

        $hasSearch = $request->hasAny(['q', 'kategori', 'tipe', 'user', 'start', 'end', 'sort']);

        $categories = Dokumen::whereNotNull('kategori')
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $types = Dokumen::select('tipe_file')
            ->distinct()
            ->orderBy('tipe_file')
            ->pluck('tipe_file');

        $users = User::whereIn('role', ['Admin', 'Petugas', 'Petugas Arsip'])
            ->orderBy('nama')
            ->get();

        return view('pages.public.search', compact(
            'documents',
            'hasSearch',
            'users',
            'types',
            'categories'
        ));
    }

    /**
     * Download dokumen
     */
    public function download($id)
    {
        $doc = Dokumen::findOrFail($id);

        $fullPath = storage_path(
            'app/public/documents/' . $doc->path_file
        );

        abort_if(!file_exists($fullPath), 404);

        return response()->download($fullPath, $doc->path_file);
    }

    /**
     * Detail dokumen
     */
    public function show($id)
    {
        $document = Dokumen::with('barcode')->findOrFail($id);
        return view('pages.public.dokumen_detail', compact('document'));
    }

    /**
     * Halaman isi dokumen
     */
    public function isi()
    {
        return view('pages.public.dokumen_isi');
    }

    /**
     * Halaman scan dokumen
     */
    public function scanPage()
    {
        return view('pages.public.scan_dokumen');
    }

    /**
     * Simpan hasil scan
     */
    public function scanStore(Request $request)
    {
        $request->validate([
            'scan_files'   => 'required|array|min:1',
            'scan_files.*' => 'image|mimes:jpg,jpeg,png|max:5120',
            'judul'        => 'required|string|max:255',
            'kategori'     => 'required|string',
        ]);

        $images = [];

        /** 1️⃣ Simpan gambar sementara */
        foreach ($request->file('scan_files') as $file) {
            $path = $file->store('temp_scan', 'public');
            $images[] = storage_path('app/public/' . $path);
        }

        /** 2️⃣ Nama PDF = judul */
        $pdfName = Str::slug($request->judul) . '.pdf';

        /** 3️⃣ Generate PDF */
        $pdf = Pdf::loadView('pdf.scan', [
            'images' => $images
        ])->setPaper('A4');

        /** 4️⃣ Simpan PDF */
        Storage::disk('public')->put(
            'documents/' . $pdfName,
            $pdf->output()
        );

        /** 5️⃣ Ambil ukuran PDF */
        $fileSize = Storage::disk('public')->size(
            'documents/' . $pdfName
        );

        /** 6️⃣ Simpan ke DB (HANYA NAMA FILE) */
        Dokumen::create([
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'kategori'       => $request->kategori,
            'tipe_file'      => 'pdf',
            'tanggal_upload' => now(),
            'path_file'      => $pdfName, // 🔥 PENTING
            'ukuran_file'    => $fileSize,
            'id_user'        => 2,
        ]);

        /** 7️⃣ Hapus file temp */
        Storage::disk('public')->deleteDirectory('temp_scan');

        return redirect()
            ->route('scan_dokumen.page')
            ->with('success', 'Dokumen berhasil dibuat menjadi PDF');
    }

    /**
     * Halaman upload dokumen (admin)
     */
    public function uploadPage()
    {
        return view('pages.admin.dokumen_upload');
    }

    /**
     * Proses upload dokumen
     */
    public function uploadStore(Request $request)
    {
        $request->validate([
            'dokumen'  => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        $file = $request->file('dokumen');
        $ext  = $file->getClientOriginalExtension();

        $namaFile = Str::slug($request->judul) . '_' . time() . '.' . $ext;

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

        DB::table('log_aktivitas')->insert([
            'id_user' => auth()->user()->id_user,
            'waktu_aktivitas' => now(),
            'jenis_aktivitas' => 'Upload Dokumen',
            'deskripsi' => 'Upload dokumen: ' . $request->judul
        ]);

        return back()->with('success', 'Dokumen berhasil diupload');
    }

    /**
     * Halaman manajemen arsip (admin)
     */
    public function index()
    {
        $dokumens = Dokumen::with('user')->orderBy('tanggal_upload', 'desc')->get();
        return view('pages.admin.manajemen_arsip', compact('dokumens'));
    }

    /**
     * Form edit dokumen
     */
    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('pages.admin.edit_arsip', compact('dokumen'));
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

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diupdate');
    }

    /**
     * Hapus dokumen
     */
    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        DB::table('barcode')->where('id_dokumen', $id)->delete();

        if ($dokumen->path_file && Storage::disk('public')->exists($dokumen->path_file)) {
            Storage::disk('public')->delete($dokumen->path_file);
        }

        $dokumen->delete();

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus');
    }
}

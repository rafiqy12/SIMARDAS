<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\User;

class Search
{
    public function ShowSearchPage(Request $request)
    {
        $query = Dokumen::with('user');

        // 🔍 Keyword (judul + deskripsi)
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->q . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
            });
        }

        // 📂 Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // 📄 Tipe dokumen
        if ($request->filled('tipe')) {
            $query->where('tipe_file', strtolower($request->tipe));
        }

        // 👤 Diunggah oleh
        if ($request->filled('user')) {
            $query->where('id_user', $request->user);
        }


        // 📅 Filter tanggal
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
        $hasSearch = $request->hasAny([
            'q',
            'kategori',
            'tipe',
            'user',
            'start',
            'end',
            'sort'
        ]);

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

        return view('pages.search', compact(
            'documents',
            'hasSearch',
            'users',
            'types',
            'categories'
        ));
    }



    public function download($id)
    {
        $document = Dokumen::findOrFail($id);

        // file disimpan di storage/app/public/documents
        $fullPath = storage_path('app/public/' . $document->path_file);

        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan');
        }

        // Bersihkan nama file dari karakter yang tidak valid
        $cleanFileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $document->judul);

        return response()->download(
            $fullPath,
            $cleanFileName . '.' . $document->tipe_file
        );
    }
}

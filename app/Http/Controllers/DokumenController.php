<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Dokumen;
use App\Models\User;
use App\Models\LogAktivitas;
use App\Models\Barcode;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;


class DokumenController
{
    /**
     * Halaman pencarian dokumen dengan sistem pencarian advanced
     */
    public function search(Request $request)
    {
        $searchQuery = $request->q;
        $documents = collect();
        $recommendations = collect();

        if ($request->filled('q')) {
            // Pecah query menjadi kata-kata individual
            $keywords = $this->parseSearchKeywords($searchQuery);

            // Dapatkan semua dokumen yang cocok dengan minimal satu kata
            $query = Dokumen::with('user');

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('judul', 'like', '%' . $keyword . '%')
                        ->orWhere('deskripsi', 'like', '%' . $keyword . '%')
                        ->orWhere('kategori', 'like', '%' . $keyword . '%');
                }
            });

            // Terapkan filter tambahan
            $this->applyFilters($query, $request);

            $results = $query->get();

            // Hitung skor relevansi untuk setiap dokumen
            $scoredResults = $results->map(function ($doc) use ($keywords, $searchQuery) {
                $score = $this->calculateRelevanceScore($doc, $keywords, $searchQuery);
                $doc->relevance_score = $score;
                return $doc;
            });

            // Urutkan berdasarkan skor relevansi (tertinggi dulu)
            $sortedResults = $scoredResults->sortByDesc('relevance_score');

            // Format hasil
            $documents = $sortedResults->map(function ($doc) {
                return (object)[
                    'id'              => $doc->id_dokumen,
                    'title'           => $doc->judul,
                    'description'     => $doc->deskripsi,
                    'category'        => $doc->kategori,
                    'type'            => strtoupper($doc->tipe_file),
                    'uploaded_at'     => $doc->tanggal_upload,
                    'uploaded_by'     => $doc->user->nama ?? '-',
                    'file_size'       => $doc->file_size ?? '-',
                    'relevance_score' => $doc->relevance_score
                ];
            });

            // Dapatkan rekomendasi berdasarkan kategori dari hasil teratas
            if ($documents->isNotEmpty()) {
                $topCategories = $documents->take(3)->pluck('category')->unique()->filter();

                $recommendations = Dokumen::with('user')
                    ->whereIn('kategori', $topCategories)
                    ->whereNotIn('id_dokumen', $documents->pluck('id')->toArray())
                    ->orderBy('tanggal_upload', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($doc) {
                        return (object)[
                            'id'          => $doc->id_dokumen,
                            'title'       => $doc->judul,
                            'description' => $doc->deskripsi,
                            'category'    => $doc->kategori,
                            'type'        => strtoupper($doc->tipe_file),
                            'uploaded_at' => $doc->tanggal_upload,
                            'uploaded_by' => $doc->user->nama ?? '-',
                            'file_size'   => $doc->file_size ?? '-'
                        ];
                    });
            }
        } else {
            // Jika tidak ada query, tampilkan berdasarkan filter saja
            $query = Dokumen::with('user');
            $this->applyFilters($query, $request);

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
                    'file_size'    => $doc->file_size ?? '-'
                ];
            });
        }

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
            'categories',
            'recommendations'
        ));
    }

    /**
     * Parse search keywords - memecah query menjadi kata-kata individual
     * dan memfilter kata-kata umum (stop words)
     */
    private function parseSearchKeywords(string $query): array
    {
        // Stop words dalam bahasa Indonesia yang tidak perlu dicari
        $stopWords = [
            'dan',
            'atau',
            'yang',
            'di',
            'ke',
            'dari',
            'untuk',
            'dengan',
            'pada',
            'adalah',
            'ini',
            'itu',
            'akan',
            'juga',
            'sudah',
            'telah',
            'bisa',
            'dapat',
            'harus',
            'dalam',
            'oleh',
            'sebagai',
            'seperti',
            'dokumen',
            'file',
            'arsip',
            'data',
            'surat',
            'berkas'
        ];

        // Bersihkan dan pecah query
        $query = strtolower(trim($query));
        $words = preg_split('/\s+/', $query);

        // Filter kata-kata pendek dan stop words
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            $word = trim($word);
            return strlen($word) >= 2 && !in_array($word, $stopWords);
        });

        // Jika semua kata terfilter, kembalikan kata asli
        if (empty($keywords)) {
            return array_filter($words, fn($w) => strlen(trim($w)) >= 2);
        }

        return array_values($keywords);
    }

    /**
     * Hitung skor relevansi dokumen berdasarkan keywords
     */
    private function calculateRelevanceScore(Dokumen $doc, array $keywords, string $originalQuery): int
    {
        $score = 0;
        $judul = strtolower($doc->judul ?? '');
        $deskripsi = strtolower($doc->deskripsi ?? '');
        $kategori = strtolower($doc->kategori ?? '');
        $originalQuery = strtolower($originalQuery);

        // Exact match pada judul (skor tertinggi)
        if (strpos($judul, $originalQuery) !== false) {
            $score += 100;
        }

        // Exact match pada deskripsi
        if (strpos($deskripsi, $originalQuery) !== false) {
            $score += 50;
        }

        // Hitung per kata kunci
        foreach ($keywords as $keyword) {
            // Keyword ada di judul
            if (strpos($judul, $keyword) !== false) {
                $score += 30;

                // Bonus jika keyword di awal judul
                if (strpos($judul, $keyword) === 0) {
                    $score += 10;
                }
            }

            // Keyword ada di kategori
            if (strpos($kategori, $keyword) !== false) {
                $score += 25;
            }

            // Keyword ada di deskripsi
            if (strpos($deskripsi, $keyword) !== false) {
                $score += 15;
            }
        }

        // Bonus jika semua keyword ditemukan
        $allFound = true;
        foreach ($keywords as $keyword) {
            if (strpos($judul . ' ' . $deskripsi . ' ' . $kategori, $keyword) === false) {
                $allFound = false;
                break;
            }
        }
        if ($allFound && count($keywords) > 1) {
            $score += 50;
        }

        return $score;
    }

    /**
     * Terapkan filter ke query
     */
    private function applyFilters($query, Request $request): void
    {
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
    }

    public function scanBarcodePage()
    {
        return view('pages.public.scan_barcode');
    }

    public function scanBarcodeProcess(Request $request)
    {
        try {
            $request->validate([
                'kode_barcode' => 'required|string'
            ]);
            \Log::info('BARCODE SCAN:', [
                'hasil_scan' => $request->kode_barcode
            ]);

            $kode = trim($request->kode_barcode);

            $barcode = Barcode::with('dokumen')
                ->where('kode_barcode', $kode)
                ->first();

            if (!$barcode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barcode tidak ditemukan'
                ]);
            }

            if (!$barcode->dokumen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barcode belum terhubung ke dokumen'
                ]);
            }

            return response()->json([
                'success' => true,
                'redirect' => route('dokumen.detail', $barcode->id_dokumen)
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'SERVER ERROR',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Download dokumen
     */
    public function download($id)
    {
        $doc = Dokumen::findOrFail($id);

        // path_file bisa berupa "documents/namafile.pdf" atau hanya "namafile.pdf"
        $pathFile = $doc->path_file;

        // Jika path sudah include "documents/", gunakan langsung
        if (str_starts_with($pathFile, 'documents/')) {
            $storagePath = $pathFile;
        } else {
            $storagePath = 'documents/' . $pathFile;
        }

        $fullPath = storage_path('app/public/' . $storagePath);

        abort_if(!file_exists($fullPath), 404, 'File tidak ditemukan');

        // Nama file saat diunduh (pakai judul dokumen)
        $ext = pathinfo($pathFile, PATHINFO_EXTENSION) ?: 'pdf';
        $downloadName = Str::slug($doc->judul) . '.' . $ext;

        return response()->download($fullPath, $downloadName);
    }


    /**
     * Detail dokumen
     */
    public function show($id)
    {
        $document = Dokumen::with('barcode', 'user')->findOrFail($id);

        // Rekomendasi arsip (3 dokumen relevan, exclude current)
        $recommendations = collect();
        if ($document) {
            // Ambil semua dokumen lain, exclude dokumen ini
            $docs = Dokumen::where('id_dokumen', '!=', $document->id_dokumen)->get();

            // Skor relevansi: gunakan judul dokumen ini sebagai query
            $keywords = array_filter(explode(' ', strtolower($document->judul)));
            $originalQuery = strtolower($document->judul);
            foreach ($docs as $doc) {
                $doc->relevance_score = $this->calculateRelevanceScore($doc, $keywords, $originalQuery);
            }

            // Filter hanya yang sangat relevan (skor >= 100)
            $filtered = $docs->filter(function ($doc) {
                return $doc->relevance_score >= 100;
            });
            $recommendations = $filtered->sortByDesc('relevance_score')->take(3);
        }

        return view('pages.public.dokumen_detail', compact('document', 'recommendations'));
    }

    /**
     * Halaman isi dokumen / Preview
     */
    public function preview($id)
    {
        $dokumen = Dokumen::with('user')->findOrFail($id);

        // path_file bisa berupa "documents/namafile.pdf" atau hanya "namafile.pdf"
        $pathFile = $dokumen->path_file;

        if (str_starts_with($pathFile, 'documents/')) {
            $storagePath = $pathFile;
        } else {
            $storagePath = 'documents/' . $pathFile;
        }

        if (!Storage::disk('public')->exists($storagePath)) {
            abort(404, 'File tidak ditemukan');
        }

        $ext = strtolower(pathinfo($pathFile, PATHINFO_EXTENSION));
        $previewableTypes = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
        $canPreview = in_array($ext, $previewableTypes);

        // Jika tidak bisa preview, redirect ke halaman detail
        if (!$canPreview) {
            return redirect()->route('dokumen.detail', $id);
        }

        // Jika bisa preview (PDF/gambar), tampilkan langsung
        $fullPath = storage_path('app/public/' . $storagePath);
        $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($pathFile) . '"'
        ]);
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
        $dokumen = Dokumen::create([
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'kategori'       => $request->kategori,
            'tipe_file'      => 'pdf',
            'tanggal_upload' => now(),
            'path_file'      => $pdfName,
            'ukuran_file'    => $fileSize,
            'id_user'        => 2,
        ]);

        $kodeBarcode = 'B' . str_pad($dokumen->id_dokumen, 5, '0', STR_PAD_LEFT);

        Barcode::create([
            'kode_barcode' => $kodeBarcode,
            'id_dokumen'   => $dokumen->id_dokumen,
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

        $dokumen = Dokumen::create([
            'id_user'        => auth()->user()->id_user,
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'kategori'       => $request->kategori,
            'tipe_file'      => $ext,
            'tanggal_upload' => now(),
            'path_file'      => $path,
            'ukuran_file'    => $file->getSize(),
        ]);
        $kodeBarcode = 'B' . str_pad($dokumen->id_dokumen, 5, '0', STR_PAD_LEFT);

        Barcode::create([
            'kode_barcode' => $kodeBarcode,
            'id_dokumen'   => $dokumen->id_dokumen,
        ]);


        LogAktivitas::create([
            'id_user' => auth()->user()->id_user,
            'waktu_aktivitas' => now(),
            'jenis_aktivitas' => 'Upload Arsip',
            'deskripsi' => 'Mengupload arsip: ' . $request->judul
        ]);

        return back()->with('success', 'Dokumen berhasil diupload');
    }
    public function downloadBarcode($id)
    {
        $dokumen = Dokumen::with('barcode')->findOrFail($id);
        abort_if(!$dokumen->barcode, 404);

        // Generate barcode (hitam transparan)
        $barcodeBase64 = DNS1D::getBarcodePNG(
            $dokumen->barcode->kode_barcode,
            'C128',
            3,
            100
        );

        $barcodeImage = imagecreatefromstring(base64_decode($barcodeBase64));

        // Ukuran barcode
        $bw = imagesx($barcodeImage);
        $bh = imagesy($barcodeImage);

        // Margin wajib (quiet zone)
        $marginX = 30;
        $marginY = 20;

        // Canvas putih
        $canvas = imagecreatetruecolor(
            $bw + ($marginX * 2),
            $bh + ($marginY * 2)
        );

        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);

        // Tempel barcode ke tengah
        imagecopy(
            $canvas,
            $barcodeImage,
            $marginX,
            $marginY,
            0,
            0,
            $bw,
            $bh
        );

        // Output
        ob_start();
        imagepng($canvas);
        $imageData = ob_get_clean();

        imagedestroy($barcodeImage);
        imagedestroy($canvas);

        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header(
                'Content-Disposition',
                'attachment; filename="barcode_' . $dokumen->barcode->kode_barcode . '.png"'
            );
    }
    /**
     * Halaman manajemen arsip (admin)
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search', '');

        $query = Dokumen::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $dokumens = $query->orderBy('tanggal_upload', 'desc')->paginate($perPage)->appends($request->query());

        return view('pages.admin.manajemen_arsip', compact('dokumens', 'search', 'perPage'));
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
        $judulLama = $dokumen->judul;
        $dokumen->judul = $request->judul;
        $dokumen->kategori = $request->kategori;
        $dokumen->deskripsi = $request->deskripsi;
        $dokumen->save();

        LogAktivitas::create([
            'id_user' => auth()->user()->id_user,
            'waktu_aktivitas' => now(),
            'jenis_aktivitas' => 'Update Arsip',
            'deskripsi' => 'Mengupdate arsip: ' . $request->judul
        ]);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diupdate');
    }

    /**
     * Hapus dokumen
     */
    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $judulDokumen = $dokumen->judul;

        DB::table('barcode')->where('id_dokumen', $id)->delete();

        if ($dokumen->path_file && Storage::disk('public')->exists($dokumen->path_file)) {
            Storage::disk('public')->delete($dokumen->path_file);
        }

        $dokumen->delete();

        LogAktivitas::create([
            'id_user' => auth()->user()->id_user,
            'waktu_aktivitas' => now(),
            'jenis_aktivitas' => 'Hapus Arsip',
            'deskripsi' => 'Menghapus arsip: ' . $judulDokumen
        ]);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus');
    }

    /**
     * Halaman arsip untuk user biasa (dengan layout navbar)
     * Diakses oleh Petugas dengan tampilan halaman biasa
     */
    public function publicIndex(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search', '');

        $query = Dokumen::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $dokumens = $query->orderBy('tanggal_upload', 'desc')->paginate($perPage)->appends($request->query());

        // Petugas bisa upload dan edit
        $user = auth()->user();
        $canUpload = $user && in_array($user->role, ['Admin', 'Petugas']);
        $canEdit = $user && in_array($user->role, ['Admin', 'Petugas']);

        return view('pages.public.arsip', compact('dokumens', 'search', 'perPage', 'canUpload', 'canEdit'));
    }
}

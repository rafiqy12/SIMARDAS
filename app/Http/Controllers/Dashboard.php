<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;

class Dashboard
{
    public function ShowDashboardPage()
    {
        // Total Arsip
        $totalArsip = Dokumen::count();

        // Total User
        $totalUser = User::count();

        // Arsip Bulan Ini
        $arsipBulanIni = Dokumen::whereMonth('tanggal_upload', now()->month)
            ->whereYear('tanggal_upload', now()->year)
            ->count();

        // Storage Used (dari kolom ukuran_file di tabel dokumen)
        $storageUsedBytes = Dokumen::sum('ukuran_file') ?? 0;
        $storageUsed = $this->formatFileSize($storageUsedBytes);

        // Storage Usage Percentage (asumsi total storage 500GB)
        $totalStorageBytes = 500 * 1024 * 1024 * 1024; // 500 GB
        $storagePercentage = $totalStorageBytes > 0 ? round(($storageUsedBytes / $totalStorageBytes) * 100, 2) : 0;

        // Aktivitas Terbaru dari log_aktivitas
        $aktivitasTerbaru = LogAktivitas::with('user')
            ->orderBy('waktu_aktivitas', 'desc')
            ->limit(8)
            ->get();

        // Statistik per kategori
        $statistikKategori = Dokumen::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->orderBy('total', 'desc')
            ->get();

        return view('pages.admin.dashboard', compact(
            'totalArsip',
            'totalUser',
            'arsipBulanIni',
            'storageUsed',
            'storagePercentage',
            'aktivitasTerbaru',
            'statistikKategori'
        ));
    }

    /**
     * Format bytes to human readable format
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}

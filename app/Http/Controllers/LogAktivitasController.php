<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user')->orderByDesc('waktu_aktivitas');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis_aktivitas', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', "%{$search}%")
                                ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan jenis aktivitas
        if ($request->filled('jenis')) {
            $query->where('jenis_aktivitas', $request->jenis);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('waktu_aktivitas', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('waktu_aktivitas', '<=', $request->tanggal_sampai);
        }

        $aktivitas = $query->paginate(20)->withQueryString();

        // Get distinct jenis aktivitas for filter dropdown
        $jenisAktivitas = LogAktivitas::distinct()->pluck('jenis_aktivitas');

        return view('pages.admin.log-aktivitas', compact('aktivitas', 'jenisAktivitas'));
    }
}

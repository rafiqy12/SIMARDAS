<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LogAktivitas;

class ProfileController
{
    /**
     * Tampilkan halaman profil user
     */
    public function index()
    {
        $user = Auth::user();
        return view('pages.public.profile', compact('user'));
    }

    /**
     * Update profil user
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        try {
            $user->nama = $request->nama;
            $user->email = $request->email;
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();

            // Log aktivitas
            LogAktivitas::create([
                'id_user' => $user->id_user,
                'waktu_aktivitas' => now(),
                'jenis_aktivitas' => 'Update Profil',
                'deskripsi' => 'Mengupdate profil akun'
            ]);

            return back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}

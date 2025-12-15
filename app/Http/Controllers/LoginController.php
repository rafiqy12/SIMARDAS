<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginPage()
    {
        return view('pages.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // VALIDASI INPUT
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // CARI USER
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan'
            ])->withInput();
        }

        // CEK PASSWORD (BCRYPT)
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah'
            ])->withInput();
        }

        // LOGIN
        Auth::login($user);

        // SIMPAN SESSION TAMBAHAN (OPSIONAL, TAPI BERGUNA)
        session([
            'id_user' => $user->id_user,
            'nama'    => $user->nama,
            'role'    => $user->role
        ]);

        // REDIRECT BERDASARKAN ROLE
        if ($user->role === 'Admin') {
            return redirect()->route('dashboard.page');
        }

        // ROLE SELAIN ADMIN
        return redirect()->route('home.page');
    }

    /**
     * Logout & hapus session
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // HAPUS SEMUA SESSION
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.page');
    }
}

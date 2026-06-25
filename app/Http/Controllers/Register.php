<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class Register
{
    public function ShowRegisterpage()
    {
        return view('pages.public.register');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            // Buat user baru dengan role default 'User'
            $user = User::create([
                'nama' => $request->name,
                'username' => strtolower(str_replace(' ', '', $request->name)) . rand(100, 999),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'Umum', // Default role untuk user biasa
            ]);

            // Auto login setelah register
            Auth::login($user);

            return redirect()->route('home.page')->with('success', 'Registrasi berhasil! Selamat datang di SIMARDAS.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.')->withInput();
        }
    }
}

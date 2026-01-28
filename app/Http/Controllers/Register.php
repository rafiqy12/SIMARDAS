<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register
{
    public function ShowRegisterpage()
    {
        return view('pages.public.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        try {
            // Generate username dari email (bagian sebelum @)
            $username = explode('@', $request->email)[0];
            
            // Cek jika username sudah ada, tambahkan angka random
            $baseUsername = $username;
            $counter = 1;
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }

            // Buat user baru dengan role 'User' (default untuk registrasi publik)
            User::create([
                'nama' => $request->name,
                'username' => $username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'User', // PENTING: Selalu set role User untuk registrasi publik
            ]);

            return redirect()->route('login.page')
                ->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }
}

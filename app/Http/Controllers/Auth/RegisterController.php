<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pendaki;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:8|confirmed',
            'no_telepon'            => 'required|string|max:20',
            'alamat'                => 'required|string',
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.unique'          => 'Email sudah terdaftar.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'no_telepon.required'   => 'Nomor telepon wajib diisi.',
            'alamat.required'       => 'Alamat wajib diisi.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pendaki',
        ]);

        Pendaki::create([
            'user_id'    => $user->id,
            'no_telepon' => $request->no_telepon,
            'alamat'     => $request->alamat,
        ]);

        Auth::login($user);

        return redirect()->route('pendaki.dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '.');
    }
}

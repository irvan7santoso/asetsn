<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index()
    {
        return view('login');
    }
    public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ],[
        'email.required' => 'Email wajib diisi!',
        'email.email' => 'Format email tidak valid!',
        'password.required' => 'Password wajib diisi!'
    ]);

    // Kredensial autentikasi
    $credentials = [
        'email' => $request->email,
        'password' => $request->password,
    ];

    // Coba login
    if (Auth::attempt($credentials)) {
        // Cek peran pengguna dan arahkan sesuai
        $user = Auth::user();
        if ($user->role == 'user') {
            return redirect('/dashboard');
        } elseif ($user->role == 'admin') {
            return redirect('/dashboard');
        } else {
            // Tangani kasus di mana peran pengguna bukan 'user' atau 'admin'
            return redirect('')->withErrors('Role pengguna tidak diketahui!')->withInput();
        }
    }

    // Jika autentikasi gagal
    return redirect('')->withErrors('Email dan Password tidak sesuai!')->withInput();
}
    function logout(){
        Auth::logout();
        return redirect('/');
    }
}

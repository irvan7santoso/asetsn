<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index()
    {
        return view('/dashboard');
    }

    function user()
    {
        return view('/dashboard');
    }

    function admin()
    {
        return redirect('/dashboard');
    }

    public function getUserInfo()
    {
        $user = Auth::user();
        return response()->json([
            'nama' => $user->nama,
            'nomor_hp' => $user->nomor_hp,
            'email'=> $user->email,
        ]);
    }
}

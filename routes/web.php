<?php

use App\Http\Middleware\UserAkses;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApproveController;
use App\Http\Controllers\AsettlsnController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['guest'])->group(function(){
    Route::get('/',[SesiController::class,'index'])->name('login');
    Route::post('/',[SesiController::class,'login']);
});

Route::middleware(['auth'])->group(function(){
    Route::get('/user',[UserController::class,'index']);
    Route::get('/user/user',[UserController::class,'user'])->middleware('userakses:user');
    Route::get('/user/admin',[UserController::class,'admin'])->middleware('userakses:admin');
    Route::get('/logout',[SesiController::class,'logout']);
});

Route::get('/home',function(){
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('/Asettlsn', AsettlsnController::class);

Route::get('/approve', [ApproveController::class, 'index'])->name('approve.index');
Route::get('/approve/{id}', [ApproveController::class, 'show'])->name('approve.show');
Route::post('/approve/{id}', [ApproveController::class, 'update'])->name('approve.update');


Route::middleware(['auth'])->group(function(){
    Route::get('/peminjaman', [PeminjamanController::class, 'index']);
    Route::post('/peminjaman', [PeminjamanController::class, 'store']);
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create']);
    Route::post('/peminjaman/create', [PeminjamanController::class, 'store']);
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/peminjaman/pending', function () {
    return view('peminjaman.pending');
});

Route::get('/akun', function () {
    return view('akun.akun');
});

Route::get('/semuanotifikasi', function () {
    return view('akun.semuanotifikasi');
});



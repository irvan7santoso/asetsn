<?php

use App\Http\Middleware\UserAkses;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ApproveController;
use App\Http\Controllers\AsettlsnController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\NotificationController;

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

Route::middleware(['auth', 'admin'])->group(function(){
    Route::resource('/Asettlsn', AsettlsnController::class);
    Route::get('/approve', [ApproveController::class, 'index'])->name('approve.index');
    Route::get('/approve/{id}', [ApproveController::class, 'show'])->name('approve.show');
    Route::post('/approve/{id}', [ApproveController::class, 'update'])->name('approve.update');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/home',function(){return redirect('/dashboard');});
    Route::get('/logout',[SesiController::class,'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/peminjamansaya', [ApproveController::class, 'userIndex'])->name('peminjaman.user');
    Route::get('/peminjaman/{id}/detail', [ApproveController::class, 'userShow'])->name('peminjaman.userShow');
    Route::post('/peminjaman/{id}/update', [ApproveController::class, 'userUpdate'])->name('peminjaman.userUpdate');
    Route::get('/peminjaman', [PeminjamanController::class, 'index']);
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create']);
    Route::post('/peminjaman/create', [PeminjamanController::class, 'store']);
    Route::get('/api/user-info', [UserController::class, 'getUserInfo']);
    Route::get('/akun', function () {return view('akun.akun');});
    Route::get('/semuanotifikasi', [NotificationController::class, 'allNotifications'])->name('notifications.all');
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::get('export', [AsettlsnController::class, 'asetexport'])->name('Asettlsn.asetexport');
    Route::get('/export-peminjaman', [ExportController::class, 'exportPeminjaman'])->name('export.peminjaman');

    Route::post('/update-cart-session', function (Illuminate\Http\Request $request) {
        session(['cart' => $request->cart]);
        return response()->json(['success' => true]);});   
});

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function allNotifications()
    {
        // Ambil semua notifikasi user yang sedang login, termasuk yang sudah dibaca
        $user = auth()->user();
        $unreadNotifications = $user->unreadNotifications;
        $readNotifications = $user->readNotifications;

        // Kirim notifikasi ke view
        return view('akun.semuanotifikasi', compact('unreadNotifications', 'readNotifications'));
    }
    
    public function markAsRead($notificationId)
    {
        // Temukan notifikasi berdasarkan ID
        $notification = auth()->user()->notifications()->find($notificationId);

        if ($notification) {
            // Tandai notifikasi sebagai terbaca
            $notification->markAsRead();

            // Redirect ke halaman detail peminjaman menggunakan URL dari data notifikasi
            return redirect($notification->data['url']);
        }

        return redirect()->back()->with('error', 'Notifikasi tidak ditemukan.');
    }

    public function markAllAsRead()
    {
        // Ambil semua notifikasi yang belum terbaca dari user yang sedang login
        $user = auth()->user();

        // Tandai semua notifikasi sebagai terbaca
        $user->unreadNotifications->markAsRead();

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai terbaca.');
    }
}

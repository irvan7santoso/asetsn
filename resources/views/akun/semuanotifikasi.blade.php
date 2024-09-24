@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-body">
                <div class="row">
                    <!-- Bagian Notifikasi Belum Dibaca -->
                    <div class="col-md-12">
                        <div class="metric">
                            <h3>Notifikasi Belum Dibaca</h3>
                            @if($unreadNotifications->isEmpty())
                                <p>Tidak ada notifikasi belum dibaca.</p>
                            @else
                                <ul class="list-group">
                                    @foreach($unreadNotifications as $notification)
                                        <li class="list-group-item unread-notification"> <!-- Tambahkan kelas khusus -->
                                            <a href="{{ route('notifications.read', $notification->id) }}">
                                                <strong>{{ $notification->data['message'] }}</strong>
                                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 5px;">
                        <div class="metric">
                            <h3>Notifikasi Sudah Dibaca</h3>
                            @if($readNotifications->isEmpty())
                                <p>Tidak ada notifikasi yang sudah dibaca.</p>
                            @else
                                <ul class="list-group">
                                    @foreach($readNotifications as $notification)
                                        <li class="list-group-item read-notification"> <!-- Kelas khusus untuk notifikasi sudah dibaca -->
                                            <a href="{{ $notification->data['url'] }}">
                                                {{ $notification->data['message'] }}
                                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .metric h3 {
        font-size: 1.5em;
        margin-bottom: 20px;
    }

    .list-group-item {
        padding: 10px 20px;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .list-group-item a {
        text-decoration: none;
    }

    .list-group-item a:hover {
        text-decoration: underline;
    }

    .text-muted {
        color: #6c757d !important;
    }

    /* Warna hijau muda untuk notifikasi belum dibaca */
    .unread-notification {
        color: #373737; /* Warna hijau muda */
    }

    .unread-notification a {
        color: #373737 !important; /* Warna hijau muda pada link */
    }

    .unread-notification a:hover {
        color: #00b728 !important; /* Warna hijau sedikit lebih gelap saat di-hover */
    }

    /* Warna abu-abu untuk notifikasi sudah dibaca */
    .read-notification {
        color: #6c757d; /* Warna abu-abu */
    }

    .read-notification a {
        color: #6c757d !important; /* Warna abu-abu pada link */
    }

    .read-notification a:hover {
        color: #495057 !important; /* Warna lebih gelap saat di-hover */
    }
</style>
@endsection

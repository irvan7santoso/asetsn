@extends('layouts.main')

@section('container')
    <div class="main-content">
        <div class="container-fluid">
            <div class="panel panel-profile">
                <div class="clearfix">
                    <!-- LEFT COLUMN -->
                    <div class="profile">
                        <!-- PROFILE HEADER -->
                        <div class="profile-header">
                            <div class="overlay"></div>
                            <div class="profile-main">
                                <img src="assets/img/user-medium.png" class="img-circle" alt="Avatar">
                                <h3 class="name">{{ Auth::user()-> nama}}</h3>
                                <span class="online-status status-available">Available</span>
                            </div>
                        </div>
                        <!-- END PROFILE HEADER -->
                        <!-- PROFILE DETAIL -->
                        <div class="profile-detail">
                            <div class="profile-info">
                                <h4 class="heading">Profil</h4>
                                <ul class="list-unstyled list-justify">
                                    <li>Nomor HP<span>{{ Auth::user()-> nomor_hp}}</span></li>
                                    <li>Email <span>{{ Auth::user()-> email}}</span></li>
                                    <li>Departemen <span>{{ Auth::user()-> departemen}}</span></li>
                                    <li>Jabatan <span>{{ Auth::user()-> jabatan}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <!-- END PROFILE DETAIL -->
                    </div>
                    <!-- END LEFT COLUMN -->
                </div>
            </div>
        </div>
    </div>
@endsection
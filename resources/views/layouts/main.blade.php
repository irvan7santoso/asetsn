<!doctype html>
<html lang="en">

<head>
	<title>Aplikasi Manajemen Aset - Satunama</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset ('assets/vendor/bootstrap/css/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset ('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset ('assets/vendor/linearicons/style.css') }}">
	<link rel="stylesheet" href="{{ asset ('assets/vendor/chartist/css/chartist-custom.css') }}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{ asset ('assets/css/main.css') }}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset ('assets/img/satunamalogo.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset ('assets/img/satunamalogo1.png') }}">

    <script src="{{ asset ('assets/vendor/jquery/jquery.min.js') }}"></script>
</head>
@if(Auth::user()->role=='admin')
<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="/dashboard"><img src="{{ asset ('assets/img/logo2.png') }}" alt="Satunama Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-chevron-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-success">5</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Aset Mobil harus dikembalikan pada tanggal 12 Desember 2023</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-danger"></span>Masa peminjaman aset melampaui batas!</a></li>
								<li><a href="/" class="notification-item"><span class="dot bg-success"></span>Peminjaman aset disetujui</a></li>
								<li><a href="/approvepeminjaman" class="notification-item"><span class="dot bg-info"></span>Permohonan peminjaman aset/alat baru</a></li>
								<li><a href="/" class="notification-item"><span class="dot bg-primary"></span>Aset sudah dikembalikan</a></li>
								<li><a href="/semuanotifikasi" class="more">Lihat semua notifikasi</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ asset ('assets/img/user.png') }}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()-> nama}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="/akun"><i class="lnr lnr-user"></i> <span>Akun</span></a></li>
								<li><a href="/logout"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li class="{{ Request::is('dashboard') ? 'active' : '' }}">
							<a href="/dashboard" class=""><i class="lnr lnr-home"></i> <span>Dashboard</span></a>
						</li>
						<li class="{{ Request::is('Asettlsn') ? 'active' : '' }}">
							<a href="/Asettlsn" class=""><i class="lnr lnr-apartment"></i> <span>Daftar Aset</span></a>
						</li>
						<li class="{{ Request::is('peminjaman') ? 'active' : '' }}">
							<a href="/peminjaman" class=""><i class="lnr lnr-laptop-phone"></i> <span>Peminjaman Aset</span></a>
						</li>
						<li class="{{ Request::is('approve') ? 'active' : '' }}">
							<a href="/approve" class=""><i class="lnr lnr-book"></i> <span>Daftar Permohonan Peminjaman Aset</span></a>
						</li>
						<li class="{{ Request::is('peminjamansaya') ? 'active' : '' }}">
							<a href="/peminjamansaya" class=""><i class="lnr lnr-book"></i> <span>Daftar Peminjaman Saya</span></a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<div class="main">
			@yield('container')
		</div>
		<div class="clearfix"></div>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="{{ asset ('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset ('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset ('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
	<script src="{{ asset ('assets/vendor/chartist/js/chartist.min.js') }}"></script>
	<script src="{{ asset ('assets/scripts/klorofil-common.js') }}"></script>
</body>
@endif
@if(Auth::user()->role=='user')
<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="/welcome"><img src="{{ asset ('assets/img/logo2.png') }}" alt="Satunama Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-chevron-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-success">5</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Aset Mobil harus dikembalikan pada tanggal 12 Desember 2023</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-danger"></span>Masa peminjaman aset melampaui batas!</a></li>
								<li><a href="/" class="notification-item"><span class="dot bg-success"></span>Peminjaman aset disetujui</a></li>
								<li><a href="/approvepeminjaman" class="notification-item"><span class="dot bg-info"></span>Permohonan peminjaman aset/alat baru</a></li>
								<li><a href="/" class="notification-item"><span class="dot bg-primary"></span>Aset sudah dikembalikan</a></li>
								<li><a href="/semuanotifikasi" class="more">Lihat semua notifikasi</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ asset ('assets/img/user.png') }}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()-> nama}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="/akun"><i class="lnr lnr-user"></i> <span>Akun</span></a></li>
								<li><a href="/logout"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li class="{{ Request::is('welcome') ? 'active' : '' }}">
							<a href="/welcome" class=""><i class="lnr lnr-home"></i> <span>Dashboard</span></a>
						</li>
						<li class="{{ Request::is('peminjaman') ? 'active' : '' }}">
							<a href="/peminjaman" class=""><i class="lnr lnr-laptop-phone"></i> <span>Peminjaman Aset</span></a>
						</li>
						<li class="{{ Request::is('peminjamansaya') ? 'active' : '' }}">
							<a href="/peminjamansaya" class=""><i class="lnr lnr-book"></i> <span>Daftar Peminjaman Saya</span></a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<div class="main">
			@yield('container')
		</div>
		<div class="clearfix"></div>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="{{ asset ('assets/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset ('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset ('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset ('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
	<script src="{{ asset ('assets/vendor/chartist/js/chartist.min.js') }}"></script>
	<script src="{{ asset ('assets/scripts/klorofil-common.js') }}"></script>
</body>
@endif
<style>
	button {
		color: #fff;
	}
	.navbar-default .navbar-nav > li > a {
 		color: #fff;
	}
	.navbar-default .navbar-nav > .open > a,
	.navbar-default .navbar-nav > .open > a:hover,
	.navbar-default .navbar-nav > .open > a:focus {
	  	color: #fff;
 	 	background-color: #327e33;
	}
	.navbar-default .navbar-nav > li > a:hover,
	.navbar-default .navbar-nav > li > a:focus {
  		color: #b5b5b5;
  		background-color: #327e33;
	}
	.sidebar .nav > li.active > a {
		color: #48ff00;
        background-color: #1b2d1f;
      	border-left-color: #41B314;
    }
</style>
</html>

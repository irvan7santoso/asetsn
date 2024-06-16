<!doctype html>
<html lang="en" class="fullscreen-bg">

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
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><img src="assets/img/satunamalogo1.png" alt="Satunama Logo"></div>
								<p class="lead">Login ke akun anda</p>
							</div>
							@if($errors->any())
								<div class="alert alert-danger text-center">
									<ul>
										@foreach ($errors->all() as $item)
											<li>{{ $item }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							<form class="form-auth-small" action="" method="post">
								@csrf
								<div class="form-group">
									<label for="email" class="control-label sr-only">Email</label>
									<input type="email" value="{{old('email')}}" name="email" class="form-control" placeholder="Email">
								</div>
								<div class="form-group">
									<label for="password" class="control-label sr-only">Password</label>
									<input type="password" class="form-control" name="password" value="" placeholder="Password">
								</div>
								<button type="submit" class="btn btn-success btn-lg btn-block">LOGIN</button>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">Aplikasi Manajemen Aset Yayasan Satunama</h1>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
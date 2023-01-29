<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Studio - Santri Baja Indonesia</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/logo.png?v='.filemtime(public_path('assets/images/logo.png'))) }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/logo.png?v='.filemtime(public_path('assets/images/logo.png'))) }}">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/linearicons/style.css') }}">
	<!-- Env Color -->
    <link rel="stylesheet" href="{{ asset('assets/css/envColor.css?v='.filemtime(public_path('assets/css/envColor.css'))) }}">
    <script src="{{ asset('assets/scripts/envColor.js?v='.filemtime(public_path('assets/scripts/envColor.js'))) }}"></script>
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v='.filemtime(public_path('assets/css/main.css'))) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v='.filemtime(public_path('assets/css/custom.css'))) }}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
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
								<div class="logo text-center"><img src="{{ asset('assets/images/logo.png?v='.filemtime(public_path('assets/images/logo.png'))) }}" class="login-logo"></div>
								<p class="lead">Login to your account</p>
							</div>
							<form class="form-auth-small" method="POST" action="/login-attempt">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="text" name="username" class="form-control" id="signin-email" value="{{ old('username') }}" placeholder="username">
									@if ($message = Session::get('failed'))
										<span class="login-failed-message"><i>Username and password doesn't match </i></span>
									@endif
								</div>
								
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" name="password" class="form-control" id="signin-password" value="{{ old('password') }}" placeholder="Password">
								</div>
								<div class="form-group clearfix">
								</div>
								<button type="submit" class="btn btn-primary btn-block btn-login">LOGIN</button>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">Studio Santri Baja Indonesia</h1>
							<p>By : <a href="https://defriant.com/" target="_blank">The Develovers</a></p>
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

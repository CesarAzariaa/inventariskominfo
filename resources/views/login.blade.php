<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Login Page</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['assets/css/fonts.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
	<!-- CSS Files -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/azzara.min.css">
</head>
<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">
			<form action="{{ route('login.proses') }}" method="POST">
				@csrf
			<h3 class="text-center">Silahkan Login</h3>
			<div class="login-form">
				<div class="form-group form-floating-label">
					<input id="username" name="username" type="username" class="form-control input-border-bottom" required>
					<label for="username" class="placeholder">Username</label>
					<div class="show-username">
					</div>
					@error('username')
						<small>{{ $message }}</small>
					@enderror
				</div>
				<div class="form-group form-floating-label">
					<input id="password" name="password" type="password" class="form-control input-border-bottom" required>
					<label for="password" class="placeholder">Password</label>
					<div class="show-password">
						<i class="flaticon-interface"></i>
					</div>
					@error('password')
						<small>{{ $message }}</small>
					@enderror
				</div>
				<div class="row form-sub m-0">
				</div>
				<div class="form-action mb-3">
					<button type="submit" class="btn btn-primary btn-rounded btn-login">Sign in</button>
				</div>
					<div class="login-account">
					<span class="msg">Don't have an account yet ?</span>
					<a href="register" id="show-signup" class="link">Sign Up</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script src="assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="assets/js/core/popper.min.js"></script>
	<script src="assets/js/core/bootstrap.min.js"></script>
	<script src="assets/js/ready.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	@if($message = Session::get('failed'))
		<script>
			Swal.fire({
  			icon: "error",
  			title: "Oops...",
  			text: "{{ $message }}"
			});
		</script>
	@endif

	@if($message = Session::get('success'))
		<script>
			Swal.fire({
  			icon: "success",
  			title: "Success",
  			text: "{{ $message }}"
			});
		</script>
	@endif

</body>
</html>


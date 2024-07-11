<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Register Page</title>
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">
			<form action="{{ route('register.proses') }}" method="POST">
				@csrf
				<h3 class="text-center">Silahkan Daftar</h3>
				<div class="login-form">
					<div class="form-group form-floating-label">
						<input id="nama" name="nama" type="text" class="form-control input-border-bottom" required value="{{ old('nama') }}">
						<label for="nama" class="placeholder">Nama Lengkap</label>
						@error('nama')
							<small>{{ $message }}</small>
						@enderror
					</div>

					<div class="form-group form-floating-label">
						<input id="username" name="username" type="text" class="form-control input-border-bottom" required value="{{ old('username') }}">
						<label for="username" class="placeholder">Username</label>
						@error('username')
							<small>{{ $message }}</small>
						@enderror
					</div>
					
					<div class="form-group form-floating-label">
						<input id="no_handphone" name="no_handphone" type="number" class="form-control input-border-bottom" required value="{{ old('no_handphone') }}">
						<label for="no_handphone" class="placeholder">Nomor Handphone</label>
						@error('no_handphone')
							<small>{{ $message }}</small>
						@enderror
					</div>

					<div class="form-group form-floating-label">
						<input id="asal_instansi" name="asal_instansi" type="text" class="form-control input-border-bottom" required value="{{ old('asal_instansi') }}">
						<label for="asal_instansi" class="placeholder">Asal Instansi</label>
						@error('asal_instansi')
							<small>{{ $message }}</small>
						@enderror
					</div>
						
					<div class="form-group form-floating-label position-relative">
						<input id="password" name="password" type="password" class="form-control input-border-bottom" required>
						<label for="password" class="placeholder">Password</label>
						<div class="show-password">
							<i class="flaticon-interface"></i>
						</div>
						@error('password')
							<small>{{ $message }}</small>
						@enderror
					</div>
					
					<div class="form-group form-floating-label position-relative">
						<input id="chat_id" name="chat_id" type="number" class="form-control input-border-bottom" required value="{{ old('chat_id') }}">
						<label for="chat_id" class="placeholder">Chat ID</label>
						<a href="" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%);" title="Untuk mendapatkan Chat ID Anda, kirim pesan ke bot Telegram kami dan ketikkan '/getid'. Anda akan menerima Chat ID Anda dari bot tersebut, Untuk Melakukan Peminjaman Aset."><i class="fas fa-info-circle"></i></a>
						@error('chat_id')
							<small>{{ $message }}</small>
						@enderror
					</div>
					
					<div class="form-group">
						<a href="https://t.me/userinfobot" target="_blank">Dapatkan Chat id</a>
					</div>
					
					<div class="form-action mb-3">
						<button type="submit" class="btn btn-primary btn-rounded btn-login">Sign Up</button>
					</div>
					<div class="login-account">
						<span class="msg">Sudah Memiliki Akun ?</span>
						<a href="{{ route('login') }}" id="show-signup" class="link">Sign in</a>
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

	<style>
    /* CSS untuk menghilangkan panah pada input type number */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .form-group.position-relative .input-border-bottom {
        padding-right: 40px;
    }

    .form-group.position-relative a {
        cursor: pointer;
    }
</style>

	<script>
		$(function () {
  			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>

</body>
</html>

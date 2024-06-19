<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Inventaris Barang Diskominfotik Bengkalis</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['../assets/css/fonts.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/azzara.min.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
</head>
<body>
	<div class="wrapper">
		<div class="main-header" data-background-color="blue">
			<!-- Logo Header -->
			<div class="logo-header">
				
				<a href="index.html" class="logo">
					<img src="assets/img/kominfo.png" alt="navbar brand" class="navbar-brand" width="65" height="auto">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="fa fa-bars"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
				<div class="navbar-minimize">
					<button class="btn btn-minimize btn-rounded">
						<i class="fa fa-bars"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg">   
				<div style="text-align: center;">
					<font color="white" alt="navbar-brand" class="navbar-brand">Dinas Komunikasi Informatika dan Statistik</font>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>
		<!-- Sidebar -->
		<div class="sidebar">
				<div class="sidebar-background"></div>
				<div class="sidebar-wrapper scrollbar-inner">
					<div class="sidebar-content">
						<div class="user">
							<div class="avatar-sm float-left mr-2">
								<img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
							</div>
							<div class="info">
								@if(Auth::check())
									<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
										<span>
											{{ Auth::user()->nama }}
											<span class="user-level">{{ Auth::user()->role }}</span>
										</span>
									</a>
								@endif
								<div class="clearfix"></div>
							</div>
						</div>
						<ul class="nav">
							<li class="nav-item active">
								<a href="home">
									<i class="fas fa-home"></i>
									<p>Dashboard</p>
								</a>
							</li>
							<li class="nav-section">
								<span class="sidebar-mini-icon">
									<i class="fa fa-ellipsis-h"></i>
								</span>
								<h4 class="text-section">Components</h4>
							</li>
							<li class="nav-item">
								<a data-toggle="collapse" href="#base">
									<i class="fas fa-layer-group"></i>
									<p>Data Master</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="base">
									<ul class="nav nav-collapse">
										<li>
											<a href="datauser">
												<span class="sub-item">Data User</span>
											</a>
										</li>
										<li>
											<a href="kategori">
												<span class="sub-item">Data Kategori</span>
											</a>
										</li>
									</ul>
								</div>
							</li>

							<li class="nav-item">
								<a href="{{ route('data_aset') }}">
									<i class="fas fa-box"></i>
									<p>Data Aset</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="{{ route('aset_keluar') }}">
									<i class="fas fa-truck"></i>
									<p>Data Aset Keluar</p>
								</a>
							</li>
							
							<li class="nav-item">
								<a data-toggle="collapse" href="#users">
									<i class="fas fa-users"></i>
									<p>Transaksi Peminjaman Aset</p>
								</a>
							</li>
							
							<li class="nav-item">
								<a data-toggle="collapse" href="#submenu">
									<i class="fa fa-print"></i>
									<p>Laporan Cetak</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="submenu">
									<ul class="nav nav-collapse">
										<li>
											<a data-toggle="collapse" href="#cetak">
												<span class="sub-item">Cetak Data Aset</span>
											</a>
										</li>
										<li>
											<a data-toggle="collapse" href="#subnav2">
												<span class="sub-item">Cetak QR Code</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="nav-item">
								<a href="{{ route('logout') }}" class="nav-link">
									<i class="fas fa-door-open"></i>
									<p>Logout</p>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			@yield('content')
			
		</div>
		<!--   Core JS Files   -->
		<script src="/assets/js/core/jquery.3.2.1.min.js"></script>
		<script src="/assets/js/core/popper.min.js"></script>
		<script src="/assets/js/core/bootstrap.min.js"></script>
		<!-- jQuery UI -->
		<script src="/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
		<script src="/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
		<!-- Bootstrap Toggle -->
		<script src="/assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
		<!-- jQuery Scrollbar -->
		<script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
		<!-- Datatables -->
		<script src="/assets/js/plugin/datatables/datatables.min.js"></script>
		<!-- Azzara JS -->
		<script src="/assets/js/ready.min.js"></script>
		<!-- Sweet Alert -->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		
		<script >
			$(document).ready(function() {
				$('#add-row').DataTable({
				});
			});
		</script>
			@if(session('success'))
			<script>
				Swal.fire({
					position: 'top-mid',
					icon: 'success',
					title: '{{ session('success') }}',
					showConfirmButton: false,
					timer: 1500
				});
			</script>
		@endif
		@if(session('error'))
		<script>
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: '{{ session('error') }}',
				footer: '<a href>Why do I have this issue?</a>'
			});
		</script>
		@endif
			</body>
		</html>
	</html>
</html>

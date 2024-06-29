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
					<font color="white" alt="navbar-brand" class="navbar-brand" style="font-weight: bold;">Diskominfotik Bengkalis</font>
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
							<a href="admin.home">
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
							<a href="{{ route('aset_user') }}">
								<i class="fas fa-box"></i>
								<p>Data Aset</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="{{ route('data_peminjaman') }}">
								<i class="fas fa-address-book"></i>
								<p>Data Peminjaman</p>
							</a>
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
		
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Dashboard</h4>
						<div class="btn-group btn-group-page-header ml-auto">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="card card-stats card-round">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-info bubble-shadow-small">
												<i class="flaticon-box-1"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Data Aset</p>
												<h4 class="card-title">{{ is_countable($data_aset) ? count($data_aset) : '0' }}</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="card card-stats card-round">
								<div class="card-body">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-warning bubble-shadow-small">
												<i class="flaticon-users"></i>
											</div>
										</div>
										<div class="col col-stats ml-3 ml-sm-0">
											<div class="numbers">
												<p class="card-category">Peminjaman Aset</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
					</head>
					  <div class="row">
						<div class="col-md-6">
						  <div class="card">
							<div class="card-header">
							  <div class="card-title">Jumlah Aset Masuk dan Aset Keluar</div>
							</div>
							<div class="card-body">
							  <div class="chart-container">
								<canvas id="barChart"></canvas>
							  </div>
							</div>
						  </div>
						</div>
						<div class="col-md-6">
						  <div class="card">
							<div class="card-header">
							  <div class="card-title">Persentase Aset Masuk dan Aset Keluar</div>
							</div>
							<div class="card-body">
							  <div class="chart-container">
								<canvas id="pieChart"></canvas>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					  <script>
						var dataAsetMasuk = @json($dataAsetMasuk);
						var dataAsetKeluar = @json($dataAsetKeluar);
						var tanggal = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
					
						// Mengisi data untuk chart
						var dataMasuk = tanggal.map(month => dataAsetMasuk[month] || 0);
						var dataKeluar = tanggal.map(month => dataAsetKeluar[month] || 0);
					
						var ctxBar = document.getElementById('barChart').getContext('2d');
						var barChart = new Chart(ctxBar, {
							type: 'bar',
							data: {
								labels: tanggal,
								datasets: [{
									label: 'Aset Masuk',
									backgroundColor: 'rgba(54, 162, 235, 0.5)',
									borderColor: 'rgba(54, 162, 235, 1)',
									borderWidth: 1,
									data: dataMasuk
								}, {
									label: 'Aset Keluar',
									backgroundColor: 'rgba(255, 99, 132, 0.5)',
									borderColor: 'rgba(255, 99, 132, 1)',
									borderWidth: 1,
									data: dataKeluar
								}]
							},
							options: {
								scales: {
									yAxes: [{
										ticks: {
											beginAtZero: true
										}
									}]
								}
							}
						});
					
						var totalAsetMasuk = dataMasuk.reduce((a, b) => a + b, 0);
						var totalAsetKeluar = dataKeluar.reduce((a, b) => a + b, 0);
					
						var ctxPie = document.getElementById('pieChart').getContext('2d');
						var pieChart = new Chart(ctxPie, {
							type: 'pie',
							data: {
								labels: ['Aset Masuk', 'Aset Keluar'],
								datasets: [{
									label: 'Persentase',
									backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)'],
									borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
									borderWidth: 1,
									data: [totalAsetMasuk, totalAsetKeluar]
								}]
							},
							options: {
								responsive: true,
								maintainAspectRatio: false
							}
						});
					</script>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--   Core JS Files   -->
<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>

<!-- jQuery UI -->
<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Moment JS -->
<script src="assets/js/plugin/moment/moment.min.js"></script>

<!-- Chart JS -->
<script src="assets/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="assets/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- Bootstrap Toggle -->
<script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
<script src="assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

<!-- Google Maps Plugin -->
<script src="assets/js/plugin/gmaps/gmaps.js"></script>

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Azzara JS -->
<script src="assets/js/ready.min.js"></script>

@if($message = Session::get('success'))
		<script>
			console.log("Pesan sukses: {{ $message }}"); 
			Swal.fire({
				position: "top-mid",
				icon: "success",
				title: "{{ $message }}",
				showConfirmButton: false,
				timer: 1500
			});
		</script>
	@endif

</body>
</html>
</html>
</html>
</html>
</html>
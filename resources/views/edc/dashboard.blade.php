<!DOCTYPE html>
<html lang="en">
@php
    $title = 'Dashboard EDC';
@endphp
@include('layouts.head')

<body>
	<div class="wrapper">
		<!-- Header -->
        @include('layouts.header')

        <!-- Sidebar -->
        @include('layouts.sidebar')

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">EDC Dashboard</h2>
								<h5 class="text-white op-7 mb-2">
								Engineering Development Center Project Data</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
									<div class="row">
										<div class="col-sm-6 col-md-3">
											<div class="card card-stats card-danger card-round">
												<div class="card-body">
													<div class="row">
														<div class="col-5">
															<div class="icon-big text-center">
																<i class="fas fa-exclamation"></i>
															</div>
														</div>
														<div class="col-7 col-stats">
															<div class="numbers">
																<p class="card-category">Open</p>
																<h4 class="card-title">{{ $openCount }}</h4>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="card card-stats card-warning card-round">
												<div class="card-body">
													<div class="row">
														<div class="col-5">
															<div class="icon-big text-center">
																<i class="fas fa-users"></i>
															</div>
														</div>
														<div class="col-7 col-stats">
															<div class="numbers">
																<p class="card-category">Assigned</p>
																<h4 class="card-title">{{ $assignCount }}</h4>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="card card-stats card-primary card-round">
												<div class="card-body ">
													<div class="row">
														<div class="col-5">
															<div class="icon-big text-center">
																<i class="fas fa-paper-plane"></i>
															</div>
														</div>
														<div class="col-7 col-stats">
															<div class="numbers">
																<p class="card-category">Request to Close</p>
																<h4 class="card-title">{{ $requestToCloseCount }}</h4>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-6 col-md-3">
											<div class="card card-stats card-success card-round">
												<div class="card-body ">
													<div class="row">
														<div class="col-5">
															<div class="icon-big text-center">
																<i class="fas fa-check"></i>
															</div>
														</div>
														<div class="col-7 col-stats">
															<div class="numbers">
																<p class="card-category">Close</p>
																<h4 class="card-title">{{ $closedCount }}</h4>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
										
									<div class="row">
										<!-- Pie Chart -->
										<div class="col-md-6">
											<div class="card">
												<div class="card-header">
													<div class="card-title">Project Category Percentage</div>
												</div>
												<div class="card-body">
													<div class="chart-container">
														<canvas id="pieChart" style="width: 100%; height: 300px;"></canvas>
													</div>
												</div>
											</div>
										</div>

										<!-- Bar Chart -->
										<div class="col-md-6">
											<div class="card">
												<div class="card-header">
													<div class="card-title">Total Tickets per Assignee</div>
												</div>
												<div class="card-body">
													<div class="chart-container">
														<canvas id="barChart" style="width: 100%; height: 300px;"></canvas>
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
		</div>
        <!-- Footer -->
        @include('layouts.footer')
	</div>

    <!--   Core JS Files   -->
    <script src="{{ asset('atlantis/js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ asset('atlantis/js/core/popper.min.js') }}"></script>
	<script src="{{ asset('atlantis/js/core/bootstrap.min.js') }}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('atlantis/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('atlantis//js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('atlantis/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>


	<!-- Chart JS -->
	<script src="{{ asset('atlantis/js/plugin/chart.js/chart.min.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>



	<!-- Chart Circle -->
	<script src="{{ asset('atlantis/js/plugin/chart-circle/circles.min.js') }}"></script>


	<!-- Datatables -->
	<script src="{{ asset('atlantis/js/plugin/datatables/datatables.min.js') }}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('atlantis/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('atlantis/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('atlantis/js/atlantis.min.js') }}"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			var pieChartCtx = document.getElementById('pieChart').getContext('2d');

			// Data untuk Pie Chart
			var pieData = {
				labels: @json($categories), // Label kategori
				datasets: [{
					data: @json($percentages), // Persentase kategori
					backgroundColor: ['#72b4eb', '#113367'], // Warna segmen
					hoverBackgroundColor: ['#0056b3', '#c82333'] // Warna hover
				}]
			};

			// Opsi untuk Pie Chart
			var pieOptions = {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: true,
						position: 'bottom', // Legend di bawah chart
						labels: {
							font: {
								size: 12 // Ukuran font legend
							},
							boxWidth: 20, // Lebar kotak warna di legend
							padding: 15 // Padding antar item legend
						}
					},
					tooltip: {
						callbacks: {
							label: function (context) {
								const label = context.label || '';
								const value = context.raw || 0;
								return `${label}: ${value}%`; // Format tooltip
							}
						}
					},
					datalabels: {
						color: '#fff', // Warna teks persentase
						formatter: function (value) {
							return value + '%'; // Format teks persentase di dalam chart
						},
						font: {
							size: 14,
							weight: 'bold'
						},
						anchor: 'center',
						align: 'center'
					}
				}
			};

			// Buat Pie Chart
			new Chart(pieChartCtx, {
				type: 'pie',
				data: pieData,
				options: pieOptions,
				plugins: [ChartDataLabels] // Aktifkan plugin datalabels
			});
		});
	</script>



	<script>
		document.addEventListener("DOMContentLoaded", function () {
			var barChartCtx = document.getElementById('barChart').getContext('2d');

			// Data untuk Bar Chart
			var barData = {
				labels: @json($assignees), // Nama assignees
				datasets: [{
					label: 'Total Tickets', // Label data
					data: @json($ticketCounts), // Jumlah ticket per assignee
					backgroundColor: '#007bff', // Warna bar
					hoverBackgroundColor: '#0056b3' // Warna bar saat hover
				}]
			};

			// Opsi untuk Bar Chart
			var barOptions = {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: true, // Tampilkan legend
						position: 'top', // Legend di atas chart
						labels: {
							font: {
								size: 12
							},
							padding: 10
						}
					},
					tooltip: {
						callbacks: {
							label: function (tooltipItem) {
								return `Total Tickets: ${tooltipItem.raw}`; // Format tooltip
							}
						}
					}
				},
				scales: {
					x: {
						title: {
							display: true,
							text: 'Assignees', // Label sumbu X
							font: {
								size: 14
							}
						},
						ticks: {
							autoSkip: false // Tidak lewati label jika banyak
						}
					},
					y: {
						beginAtZero: true,
						title: {
							display: true,
							text: 'Total Tickets', // Label sumbu Y
							font: {
								size: 14
							}
						}
					}
				}
			};

			// Buat Bar Chart
			new Chart(barChartCtx, {
				type: 'bar',
				data: barData,
				options: barOptions
			});
		});
	</script>






</body>
</html>
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
										<!-- Bagian kiri: SPK Priority per Assignee -->
										<div class="col-md-6">
											<div class="card">
												<div class="card-header">
													<div class="card-title">SPK Priority per Assignee</div>
												</div>
												<div class="card-body">
													<div class="chart-container">
														<canvas id="priorityBarChart" style="width: 100%; height: 300px;"></canvas>
													</div>
													
												</div>
											</div>
										</div>

										<!-- Bagian kanan: Total Amount of Fee per Assignee -->
										<div class="col-md-6">
											<div class="card">
												<div class="card-header">
													<h5>Total Cost Project per Assignee</h5>
												</div>
												<div class="card-body">
													@foreach ($assigneeNames as $index => $name)
														<div class="mb-3">
															<div class="d-flex justify-content-between">
																<span>{{ $name }}</span>
																<span>{{ number_format($assigneeFees[$index], 0, ',', '.') }} IDR</span>
															</div>
															<div class="progress">
																<div class="progress-bar bg-primary" role="progressbar"
																	style="width: {{ ($assigneeFees[$index] / max($assigneeFees)) * 100 }}%;"
																	aria-valuenow="{{ $assigneeFees[$index] }}" aria-valuemin="0"
																	aria-valuemax="{{ max($assigneeFees) }}">
																</div>
															</div>
														</div>
													@endforeach

												</div>
											</div>
											<div class="card mt-3">
												<div class="card-header">
													<h5>Total SPK per Assignee</h5>
												</div>
												<div class="card-body">
													@php
														$totalSPK = array_sum(array_values($totalSPKByAssignee));
													@endphp

													@foreach ($totalSPKByAssignee as $assignee => $count)
														<div class="mb-3">
															<div class="d-flex justify-content-between">
																<span>{{ $assignee }}</span>
																<span>{{ $count }} SPK</span>
															</div>
															<div class="progress">
																<div 
																	class="progress-bar bg-primary" 
																	role="progressbar" 
																	style="width: {{ ($totalSPK > 0) ? ($count / $totalSPK) * 100 : 0 }}%;" 
																	aria-valuenow="{{ $count }}" 
																	aria-valuemin="0" 
																	aria-valuemax="{{ $totalSPK }}">
																	{{ round(($totalSPK > 0) ? ($count / $totalSPK) * 100 : 0, 2) }}%
																</div>
															</div>
														</div>
													@endforeach
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


	<!-- chart spk priority -->
	<script>
    	document.addEventListener("DOMContentLoaded", function () {
			var ctx = document.getElementById('priorityBarChart').getContext('2d');

			// Data untuk bar chart
			var priorityData = {
				labels: @json($assignees), // Nama assignees
				datasets: [
					{
						label: 'Major Projects',
						data: @json($majorChartData), // Data proyek major
						backgroundColor: 'rgba(255, 99, 132, 0.6)',
						borderColor: 'rgba(255, 99, 132, 1)',
						borderWidth: 1
					},
					{
						label: 'Minor Projects',
						data: @json($minorChartData), // Data proyek minor
						backgroundColor: 'rgba(54, 162, 235, 0.6)',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1
					}
				]
			};

			// Opsi untuk bar chart
			var priorityOptions = {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: true,
						position: 'top',
					},
					tooltip: {
						callbacks: {
							label: function (tooltipItem) {
								return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
							}
						}
					}
				},
				scales: {
					x: {
						title: {
							display: true,
							text: 'Assignees',
						}
					},
					y: {
					beginAtZero: true,
					title: {
						display: true,
						text: 'Number of Projects',
					},
					ticks: {
						stepSize: 1, // Menampilkan hanya bilangan bulat
						callback: function(value) {
							return Math.floor(value); // Memastikan hanya bilangan bulat ditampilkan
						}
					}
					}
				}
			};

			// Buat chart
			new Chart(ctx, {
				type: 'bar',
				data: priorityData,
				options: priorityOptions
			});
		});
	</script>

	<!-- horizontal chart total spk -->
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			var totalSPKCtx = document.getElementById('totalSPKChart').getContext('2d');

			var totalSPKData = {
				labels: @json(array_keys($totalSPKByAssignee)), // Nama assignees
				datasets: [{
					label: 'Total SPK',
					data: @json(array_values($totalSPKByAssignee)), // Jumlah SPK per assignee
					backgroundColor: '#007bff',
					hoverBackgroundColor: '#0056b3'
				}]
			};

			var totalSPKOptions = {
				responsive: true,
				maintainAspectRatio: false,
				indexAxis: 'y', // Membuat chart horizontal
				scales: {
					x: {
						beginAtZero: true,
						title: {
							display: true,
							text: 'Number of SPK',
						}
					},
					y: {
						title: {
							display: true,
							text: 'Assignees',
						}
					}
				},
				plugins: {
					legend: {
						display: false // Sembunyikan legenda
					},
					tooltip: {
						callbacks: {
							label: function (tooltipItem) {
								return `Total SPK: ${tooltipItem.raw}`;
							}
						}
					}
				}
			};

			// Buat Horizontal Bar Chart
			new Chart(totalSPKCtx, {
				type: 'bar',
				data: totalSPKData,
				options: totalSPKOptions
			});
		});
	</script>

	<!-- bar chart kompetisi amount of fee -->
	<script>
    	document.addEventListener("DOMContentLoaded", function () {
			const ctx = document.getElementById('horizontalBarChart').getContext('2d');

			const data = {
				labels: @json($assigneeNames), // Nama assignee
				datasets: [{
					label: 'Total Amount of Fee (IDR)',
					data: @json($totalFees), // Total fee
					backgroundColor: 'rgba(75, 192, 192, 0.6)',
					borderColor: 'rgba(75, 192, 192, 1)',
					borderWidth: 1
				}]
			};

			const options = {
				responsive: true,
				maintainAspectRatio: false,
				indexAxis: 'y', // Horizontal bar
				scales: {
					x: {
						beginAtZero: true,
						title: {
							display: true,
							text: 'Total Amount of Fee (IDR)',
							font: { size: 14 }
						}
					},
					y: {
						title: {
							display: true,
							text: 'Assignees',
							font: { size: 14 }
						}
					}
				},
				plugins: {
					legend: {
						display: true,
						position: 'top'
					},
					tooltip: {
						callbacks: {
							label: function (context) {
								return `Total Fee: IDR ${context.raw.toLocaleString()}`;
							}
						}
					}
				}
			};

			new Chart(ctx, {
				type: 'bar',
				data: data,
					options: options
				});
		});
	</script>







</body>
</html>
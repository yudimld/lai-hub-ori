<!DOCTYPE html>
<html lang="en">
@php
    $title = 'Create SPK';
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
								<h2 class="text-white pb-2 fw-bold">CREATE SPK</h2>
								<h5 class="text-white op-7 mb-0">Create SPK to pass to Production</h5>
							</div>
						</div>
					</div>
				</div>

				<div class="page-inner mt--5">
					<div class="row">
						<!-- Form Container -->
						<div class="col-md-8" id="form-container">
							<div class="card">
								<div class="card-body">
									<h2 class="text-center mb-4">Form Input</h2>
									<form id="materialForm" action="{{ route('ppic.store-spk') }}" method="POST">
										@csrf <!-- Tambahkan ini jika menggunakan Laravel untuk keamanan -->

										<!-- Input Material Number -->
										<div class="form-group">
											<label for="material_number">Material Number</label>
											<input type="text" id="material_number" name="material_number" class="form-control" placeholder="Enter Material Number" required>
										</div>

										<!-- Input Order Type -->
										<div class="form-group">
											<label for="order_type">Order Type</label>
											<input type="text" id="order_type" name="order_type" class="form-control" placeholder="Enter Order Type" required>
										</div>

										<!-- Input Production Plant -->
										<div class="form-group">
											<label for="production_plant">Production Plant</label>
											<input type="text" id="production_plant" name="production_plant" class="form-control" placeholder="Enter Production Plant" required>
										</div>

										<!-- Submit Button -->
										<div class="text-center">
											<button type="button" class="btn btn-round btn-success" id="btn-step-1">
												<i class="fas fa-check"></i> Submit
											</button>
										</div>
									</form>
								</div>
							</div>
							<!-- Bypass Button -->
							<div class="text-center mt-3">
								<button type="button" class="btn btn-primary" id="btn-bypass">
									<i class="fas fa-arrow-right"></i> Bypass to Next Step
								</button>
							</div>
						</div>

						<!-- Next Step Container -->
						<div class="col-md-12" id="next-step-container" style="display: none;">
							<div class="card">
								<div class="card-body">
									<div class="card-header">
										<h5 class="card-title" id="dynamic-card-title">Create Process Order : General Data</h5>
									</div>
									<div class="card-body">
										<ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
											<li class="nav-item submenu">
												<a class="nav-link active show" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="false" data-title="Create Process Order : General Data">
													<i class="fas fa-info-circle"></i> General Data
												</a>
											</li>
											<li class="nav-item submenu">
												<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" data-title="Create Process Order : Operation">
													<i class="fas fa-cogs"></i> Operation
												</a>
											</li>
											<li class="nav-item submenu">
												<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="true" data-title="Create Process Order : Materials">
													<i class="fas fa-box"></i> Materials
												</a>
											</li>
										</ul>

										<div class="tab-content mt-2 mb-3" id="pills-tabContent">
											<!-- general Data -->
											<div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
												<form>
													<!-- General Data -->
													<div class="row mb-3">
														<div class="col-md-6">
															<label for="material" class="form-label">Material</label>
															<div class="input-group">
																<input type="text" class="form-control bg-light" id="material" placeholder="1100019677" readonly>
																<span class="input-group-text bg-light">BOOSTER CT 220</span>
															</div>
														</div>
														<div class="col-md-6">
															<label for="process_order" class="form-label">Process Order</label>
															<div class="input-group">
																<input type="text" class="form-control bg-light" id="process_order" placeholder="000000000001" readonly>
															</div>
														</div>
													</div>

													<div class="row mb-3">
														<div class="col-md-6">
															<label for="status" class="form-label">Status</label>
															<div class="input-group">
																<input type="text" class="form-control bg-light" id="status" placeholder="CRTD BCRQ MANC SETC" readonly>
																<span class="input-group-text bg-light">
																	<i class="fas fa-info-circle"></i>
																</span>
															</div>
														</div>
														<div class="col-md-3">
															<label for="type" class="form-label">Type</label>
															<input type="text" class="form-control bg-light" id="type" placeholder="ZPNP" readonly>
														</div>
														<div class="col-md-3">
															<label for="plant" class="form-label">Plant</label>
															<input type="text" class="form-control bg-light" id="plant" placeholder="1811" readonly>
														</div>
													</div>

													<!-- Garis Biru -->
													<div class="border-bottom border-primary mb-3"></div>

													<!-- Quantities Section -->
													<div class="row mb-3">
														<div class="col-md-12">
															<h6 class="text-primary">Quantities</h6>
														</div>
														<div class="col-md-4">
															<label for="total_qty" class="form-label">Total Qty</label>
															<div class="input-group">
																<input type="text" class="form-control" id="total_qty" placeholder="50.000">
																<span class="input-group-text bg-light">KG</span>
															</div>
														</div>
													</div>

													<!-- Garis Biru -->
													<div class="border-bottom border-primary mb-3"></div>

													<!-- Dates Section -->
													<div class="row mb-3">
														<div class="col-md-12">
															<h6 class="text-primary">Dates</h6>
														</div>
														<!-- Basic Dates -->
														<div class="col-md-2">
															<label class="form-label">Basic Dates</label>
														</div>
														<div class="col-md-3">
															<label for="basic_end" class="form-label">End</label>
															<div class="input-group">
																<input type="text" class="form-control bg-light" id="basic_end" placeholder="16.12.2024">
																<input type="text" class="form-control bg-light" placeholder="11:00:00">
															</div>
														</div>
														<div class="col-md-4">
															<label for="basic_start" class="form-label">Start</label>
															<div class="input-group">
																<input type="date" class="form-control bg-light" id="basic_start" placeholder="04.12.2024">
																<input type="time" class="form-control bg-light" placeholder="07:00:00">
															</div>
														</div>
														<div class="col-md-2">
															<label for="basic_release" class="form-label">Release</label>
															<input type="text" class="form-control bg-light" id="basic_release" placeholder="04.12.2024">
														</div>

														<!-- Scheduled Dates -->
														<div class="col-md-2 mt-3">
															<label class="form-label">Scheduled</label>
														</div>
														<div class="col-md-3 mt-3">
															<label for="scheduled_end" class="form-label">End</label>
															<div class="input-group">
																<input type="text" class="form-control bg-light" id="scheduled_end" placeholder="16.12.2024">
																<input type="text" class="form-control bg-light" placeholder="11:00:00">
															</div>
														</div>
														<div class="col-md-3 mt-3">
															<label for="scheduled_start" class="form-label">Start</label>
															<div class="input-group">
																<input type="text" class="form-control bg-light" id="scheduled_start" placeholder="04.12.2024" readonly>
																<input type="text" class="form-control bg-light" placeholder="07:00:00">
															</div>
														</div>

														
													</div>
												</form>
											</div>

											<!-- end general data -->

											<!-- Operations -->
											<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
												<!-- Tabel Checklist -->
												<div class="table-responsive">
														<table class="table table-bordered table-hover">
															<thead class="thead-grey">
																<tr>
																	<th class="text-center">Action</th>
																	<th class="text-center">Resource</th>
																	<th class="text-center">Short Text</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td class="text-center"><input type="checkbox"></td>
																	<td>18110018</td>
																	<td>BOOSTER CT 220</td>
																</tr>
																<tr>
																	<td class="text-center"><input type="checkbox"></td>
																	<td>18110018</td>
																	<td>BOOSTER CT 220</td>
																</tr>
																<tr>
																	<td class="text-center"><input type="checkbox"></td>
																	<td>18110018</td>
																	<td>BOOSTER CT 220</td>
																</tr>
															</tbody>
														</table>
													</div>
											</div>
											<!-- End Operation -->

											<!-- Materials -->
											<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
												<!-- Tabel Data -->
												<div class="table-responsive">
													<table class="table table-bordered table-hover">
														<thead class="thead-grey">
															<tr>
																<th class="text-center">Item</th>
																<th class="text-center">Material</th>
																<th class="text-center">Material Description</th>
																<th class="text-center">Qty</th>
																<th class="text-center">UOM</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>1</td>
																<td>Material A</td>
																<td>High-quality raw material</td>
																<td>100</td>
																<td>KG</td>
															</tr>
															<tr>
																<td>2</td>
																<td>Material B</td>
																<td>Durable industrial material</td>
																<td>250</td>
																<td>L</td>
															</tr>
															<tr>
																<td>3</td>
																<td>Material C</td>
																<td>Advanced polymer compound</td>
																<td>50</td>
																<td>PCS</td>
															</tr>
															<tr>
																<td>4</td>
																<td>Material D</td>
																<td>Heat-resistant alloy</td>
																<td>75</td>
																<td>TON</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<!-- End Materials -->
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

	<!-- Datatables -->
	<script src="{{ asset('atlantis/js/plugin/datatables/datatables.min.js') }}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('atlantis/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('atlantis/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('atlantis/js/atlantis.min.js') }}"></script>

	<!-- step 1 -->
	<script>
		document.getElementById('btn-step-1').addEventListener('click', function () {
			// Ambil nilai input
			const materialNumber = document.getElementById('material_number').value.trim();
			const orderType = document.getElementById('order_type').value.trim();
			const productionPlant = document.getElementById('production_plant').value.trim();

			// Validasi input
			if (!materialNumber || !orderType || !productionPlant) {
				Swal.fire({
					title: 'Error!',
					text: 'Please fill out all fields before submitting.',
					icon: 'error',
					confirmButtonText: 'OK'
				});
				return;
			}

			// Konfirmasi SweetAlert
			Swal.fire({
				title: 'Are you sure?',
				text: "Do you want to create this SPK?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, submit it!'
			}).then((result) => {
				if (result.isConfirmed) {
					// Kirim data ke server dengan AJAX
					fetch("{{ route('ppic.store-spk') }}", {
						method: "POST",
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
						},
						body: JSON.stringify({
							material_number: materialNumber,
							order_type: orderType,
							production_plant: productionPlant
						})
					})
					.then(response => {
						if (response.ok) {
							return response.json();
						} else {
							throw new Error('Failed to save data');
						}
					})
					.then(data => {
						// Jika sukses, tampilkan SweetAlert sukses
						Swal.fire({
							title: 'Success!',
							text: 'SPK has been successfully created. Continue to the next step.',
							icon: 'success',
							confirmButtonText: 'OK'
						}).then(() => {
							// Sembunyikan form input
							document.getElementById('form-container').style.display = 'none';

							// Tampilkan konten "Tes Ganti Tampilan"
							document.getElementById('next-step-container').style.display = 'block';
						});
					})
					.catch(error => {
						// Jika gagal, tampilkan SweetAlert error
						Swal.fire({
							title: 'Error!',
							text: 'There was an issue saving the SPK.',
							icon: 'error',
							confirmButtonText: 'OK'
						});
					});
				}
			});
		});
	</script>

	<!-- JS Ubah judul header step 2,3,4 -->
	<script>
		document.querySelectorAll('#pills-tab .nav-link').forEach(tab => {
			tab.addEventListener('click', function () {
				// Ambil judul dari atribut data-title
				const newTitle = this.getAttribute('data-title');

				// Ubah teks card-title
				document.getElementById('dynamic-card-title').textContent = newTitle;
			});
		});
	</script>


<script>
    // Tombol Bypass
    document.getElementById('btn-bypass').addEventListener('click', function () {
        // Sembunyikan form-container
        document.getElementById('form-container').style.display = 'none';

        // Tampilkan next-step-container
        document.getElementById('next-step-container').style.display = 'block';
    });
</script>




</body>
</html>
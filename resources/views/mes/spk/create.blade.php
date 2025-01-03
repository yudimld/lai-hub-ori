<!DOCTYPE html>
<html lang="en">
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
								<h2 class="text-white pb-2 fw-bold">Create SPK</h2>
								<h5 class="text-white op-7 mb-2">Tambahkan SPK sesuai kebutuhan</h5>
							</div>
						</div>
					</div>
				</div>
                <div class="page-inner mt--5" id="pageContent">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Create Process Order : Initial Screen</div>
                                </div>
                                <div class="card-body">
                                    <div class="row" style="background-color: #f0f0f0;">
                                        <div class="col-md-12 col-lg-8">
                                            <!-- Material Number -->
                                            <div class="form-group row" style="border-bottom: 0.5px solid #000; padding-bottom: 0px; margin-right:10px;">
                                                <label for="materialNumber"  class="col-md-4 col-form-label text-right">Material Number :</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="materialNumber">
                                                        <option>1100019677</option>
                                                        <option>1100019676</option>
                                                        <option>1100019675</option>
                                                        <option>1100019674</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Production Plant -->
                                            <div class="form-group row" style="border-bottom: 0.5px solid #000; padding-bottom: 0px; margin-right:10px;">
                                                <label for="productionPlant" class="col-md-4 col-form-label text-right">Production Plant :</label>
                                                <div class="col-md-8" >
                                                    <select class="form-control" id="productionPlant">
                                                        <option>1811</option>
                                                        <option>1812</option>
                                                        <option>1810</option>
                                                        <option>1813</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Planning Plant -->
                                            <div class="form-group row" style="border-bottom: 0.5px solid #000; padding-bottom: 0px; margin-right:10px;">
                                                <label for="planningPlant" class="col-md-4 col-form-label text-right">Planning Plant :</label>
                                                <div class="col-md-8">
                                                    <select class="form-control bg-light" id="planningPlant" style="pointer-events: none;">
                                                        <option selected></option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Process Order Type -->
                                            <div class="form-group row" style="border-bottom: 0.5px solid #000; padding-bottom: 0px; margin-right:10px;">
                                                <label for="orderType" class="col-md-4 col-form-label text-right">Process Order Type :</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="orderType">
                                                        <option>ZPNP</option>
                                                        <option>ZPNP</option>
                                                        <option>ZPNP</option>
                                                        <option>ZPNP</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Process Order -->
                                            <div class="form-group row" style="border-bottom: 0.5px solid #000; padding-bottom: 0px; margin-right:10px;">
                                                <label for="processOrder" class="col-md-4 col-form-label text-right">Process Order :</label>
                                                <div class="col-md-8">
                                                    <select class="form-control" id="processOrder" style="pointer-events: none;">
                                                        <option>1</option>
                                                        <option selected></option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Menambahkan flexbox untuk memposisikan tombol -->
                                    <div class="card-action d-flex justify-content-end">
                                        <button class="btn btn-success mr-2" id="submitBtn">Submit</button>
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

	<!-- jQuery Sparkline -->
	<script src="{{ asset('atlantis/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('atlantis/js/plugin/chart-circle/circles.min.js') }}"></script>


	<!-- Datatables -->
	<script src="{{ asset('atlantis/js/plugin/datatables/datatables.min.js') }}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('atlantis/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ asset('atlantis/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
	<script src="{{ asset('atlantis/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('atlantis/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('atlantis/js/atlantis.min.js') }}"></script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
@php
    $title = 'Monitoring Status SPK';
@endphp
@include('layouts.head')
<style>
    
    /* Responsiveness for tables with scroll */
    .table-responsive {
    width: 100% !important;
    overflow-x: auto; /* Enable horizontal scrolling */
    overflow-y: hidden; /* Hide vertical scrollbar */
    -webkit-overflow-scrolling: touch; /* Smooth scrolling for touch devices */
    white-space: nowrap !important; /* Prevent text from wrapping in table cells */
    }

    /* Default table layout */
    .table {
    table-layout: auto; /* Columns adjust based on content */
    width: 100%; /* Make table take full width */
    margin-bottom: 1rem;
    border-collapse: collapse; /* Remove extra spacing between cells */
    }

    /* Table cell and header styling */
    .table > thead > tr > th, .table > tbody > tr > td {
    text-align: center; /* Center-align content */
    vertical-align: middle; /* Vertically center content */
    padding: 8px; /* Adjust padding for better readability */
    white-space: nowrap; /* Prevent text wrapping in cells */
    }

    /* Table hover and striped rows */
    .table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8f9fa; /* Add alternating row color */
    }

    .table-hover tbody tr:hover {
    background-color: #e9ecef; /* Highlight row on hover */
    }

    /* Header styling */
    .table > thead > tr > th {
    font-size: 14px;
    font-weight: 600;
    background-color: #f8f9fa; /* Light background for headers */
    color: #343a40; /* Dark text for contrast */
    border-bottom: 2px solid #dee2e6;
    }

    /* Cell borders */
    .table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6 !important;
    }

    /* Badges for status */
    .badge {
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 12px;
    }

    .badge-success {
    background-color: #31ce36; /* Green for assigned */
    color: #fff;
    }

    .badge-warning {
    background-color: #ffad46; /* Orange for open */
    color: #fff;
    }

    /* Scrollable container adjustments */
    @media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto; /* Ensure horizontal scrolling for small screens */
    }

    .table {
        font-size: 12px; /* Reduce font size for compact view */
    }

    .badge {
        font-size: 10px; /* Reduce badge size on smaller screens */
        padding: 3px 7px;
    }
    }

</style>

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
								<h2 class="text-white pb-2 fw-bold">List of SPK</h2>
								<h5 class="text-white op-7 mb-2">List SPK untuk PPIC Yang sudah Dibuat</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
					<div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="ppic-data-table" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Details</th>
                                                    <th>Status</th>
                                                    <th>No. PO</th>
                                                    <th>Request Date</th>
                                                    <th>Incoterm</th>
                                                    <th>Customer</th>
                                                    <th>Material</th>
                                                    <th>Nama Barang Asli</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <!-- Modal Detail -->
                                <div class="modal fade" id="detailModalPpic" tabindex="-1" role="dialog" aria-labelledby="detailModalPpicLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="detailModalPpicLabel">Detail Opportunity</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                           
                                            <div class="modal-body">
                                                 <!-- Tambahkan Customer Accept dan Revision Date -->
                                                 <div class="row mb-3" id="revisionInfoSection">
                                                    <div class="col-md-12 text-center">
                                                        <h2 style="font-size: 1.5rem; font-weight: bold;">Customer Accept for Revision Date</h4>
                                                    </div>                                                
                                                    
                                                    <div class="col-md-6">
                                                        <label><strong>Revision Date:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalRevisionDate" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><strong>Reason for Revision:</strong></label>
                                                        <textarea class="form-control bg-light" id="modalReasonRevision" readonly rows="3"></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label><strong>No. PO:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalNoPo" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><strong>Incoterm:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalIncoterm" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label><strong>Customer:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalCustomer" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><strong>Material:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalMaterial" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label><strong>Nama Barang Asli:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalNamaBarangAsli" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><strong>Nama Barang Jual:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalNamaBarangJual" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label><strong>Quantity:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalQty" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><strong>Unit of Measure:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalUom" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label><strong>Alamat Kirim:</strong></label>
                                                        <textarea class="form-control bg-light" id="modalAlamatKirim" readonly rows="3"></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><strong>Kemasan:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalKemasan" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label><strong>Gudang Pengambilan:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalGudangPengambilan" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><strong>Tanggal Tiba:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalTanggalTiba" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label><strong>Products:</strong></label>
                                                        <ul id="modalProductList" class="list-group">
                                                            <!-- Produk akan dimasukkan melalui JavaScript -->
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round btn-sm" data-dismiss="modal">Close</button>
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

	<!-- Datatables -->
	<script src="{{ asset('atlantis/js/plugin/datatables/datatables.min.js') }}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('atlantis/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>


	<!-- Sweet Alert -->
	<script src="{{ asset('atlantis/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('atlantis/js/atlantis.min.js') }}"></script>



</body>
</html>
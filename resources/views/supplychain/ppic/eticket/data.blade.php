<!DOCTYPE html>
<html lang="en">
@php
    $title = 'Data SPK';
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

                            <!-- Modal Preparing -->
                            <div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="acceptModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="acceptModalLabel">Update Status to Preparing</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="acceptForm">
                                            <div class="modal-body">
                                                <input type="hidden" id="modalPoNo">
                                                <div class="form-group">
                                                    <label for="loadingDate">Confirmation Agree with Loading Date*</label>
                                                    <input type="date" class="form-control" id="loadingDate" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="arrivingDate">Confirmation Agree with Arriving Date*</label>
                                                    <input type="date" class="form-control" id="arrivingDate" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="salesOrderType">Type of Sales Order*</label>
                                                    <select class="form-control" id="salesOrderType" required>
                                                        <option value="">Select</option>
                                                        <option value="Domestic">Domestic</option>
                                                        <option value="3rd Party">3rd Party</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Reason -->
                            <div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #dc3545; color: #fff;">
                                            <h5 class="modal-title" id="reasonModalLabel">Provide a Reason</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="reasonForm">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="reasonInput">Reason for Not Accepting</label>
                                                    <textarea class="form-control" id="reasonInput" name="reason" rows="4" required></textarea>
                                                </div>
                                                <input type="hidden" id="hiddenPoNo" name="no_po"> <!-- Field untuk No. PO -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round btn-sm" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger btn-round btn-sm">Submit</button>
                                            </div>
                                        </form>
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

    <!-- tabel dan detail -->
	<!-- <script>
        $(document).ready(function () {
            $('#ppic-data-table').DataTable({
                ajax: {
                    url: '/ppic-eticket/ppic/requests', // API endpoint
                    dataSrc: '', // Data berasal dari root JSON
                },
                columns: [
                    {
                        data: null,
                        defaultContent: '<button class="btn btn-link btn-info btn-lg" data-toggle="modal" data-target="#detailModalPpic"><i class="fa fa-eye"></i></button>',
                        orderable: false,
                    },
                    {
                        data: 'status',
                        render: function (data) {
                            // Menampilkan badge status
                            if (data === 'open') return '<span class="badge badge-danger">Open</span>';
                            if (data === 'assigned') return '<span class="badge badge-warning">Assigned</span>';
                            if (data === 'preparing') return '<span class="badge badge-success">Preparing</span>';
                            if (data === 'reject') return '<span class="badge badge-secondary">Reject</span>';
                            return '<span class="badge badge-info">Unknown</span>';
                        },
                    },
                    { data: 'no_po' },
                    { 
                        data: 'created_at',
                        render: function (data) {
                            return data ? new Date(data).toISOString().split('T')[0] : 'N/A';
                        },
                    },
                    { data: 'incoterm' },
                    { data: 'customer' },
                    { data: 'material' },
                    { data: 'nama_barang_asli' },
                    {
                        data: 'status',
                        orderable: false,
                        render: function (data, type, row) {
                            if (data === 'open') {
                                return `
                                    <button class="btn btn-success btn-round accept-icon btn-sm" style="margin-right: 10px;">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button class="btn btn-default btn-round btn-sm" style="margin-right: 10px;">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                    <button class="btn btn-danger btn-round not-accept-icon btn-sm">
                                        <i class="fa fa-times"></i>
                                    </button>
                                `;
                            } else {
                                return `
                                    <button class="btn btn-default btn-round revision-date-btn btn-sm" data-po="${row.no_po}">
                                        <i class="fa fa-calendar"></i> Revision Date
                                    </button>
                                `;
                            }
                        },
                    },
                ],
                pageLength: 10,
                responsive: true,
            });

            // Event untuk tombol detail
            $('#ppic-data-table').on('click', 'button', function () {
                var table = $('#ppic-data-table').DataTable();
                var data = table.row($(this).parents('tr')).data();

                // Isi data ke dalam modal
                $('#modalNoPo').val(data.no_po);
                $('#modalIncoterm').val(data.incoterm);
                $('#modalCustomer').val(data.customer);
                $('#modalMaterial').val(data.material);
                $('#modalNamaBarangAsli').val(data.nama_barang_asli);
                $('#modalNamaBarangJual').val(data.nama_barang_jual);
                $('#modalQty').val(data.qty);
                $('#modalUom').val(data.uom);
                $('#modalAlamatKirim').val(data.alamat_kirim);
                $('#modalKemasan').val(data.kemasan);
                $('#modalGudangPengambilan').val(data.gudang_pengambilan);
                $('#modalTanggalTiba').val(data.tanggal_tiba);

                // Tampilkan modal
                $('#detailModalPpic').modal('show');
            });

            $('#detailModalPpic').on('hidden.bs.modal', function () {
                $('.modal-backdrop').remove();
            });

            // Event untuk ikon Accept
            $('#ppic-data-table').on('click', '.accept-icon', function () {
                var table = $('#ppic-data-table').DataTable();
                var data = table.row($(this).parents('tr')).data();

                // SweetAlert konfirmasi
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to accept this request?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, accept it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim permintaan ke server untuk mengubah status
                        $.ajax({
                            url: '/ppic-eticket/update-status-ok',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Tambahkan token CSRF
                            },
                            data: {
                                no_po: data.no_po, // Kirim data no_po
                            },
                            success: function (response) {
                                // SweetAlert sukses
                                Swal.fire({
                                    title: 'Accepted!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    table.ajax.reload(); // Reload data tabel
                                });
                            },
                            error: function (xhr) {
                                // SweetAlert error
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON.message || 'Something went wrong. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });

            // Event untuk tombol Revision Date
            $('#ppic-data-table').on('click', '.revision-date-btn', function () {
                const poNo = $(this).data('po');

                // Tampilkan modal untuk memilih tanggal
                Swal.fire({
                    title: 'Set Revision Date',
                    html: `
                        <input type="date" id="revisionDateInput" class="form-control" />
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const date = document.getElementById('revisionDateInput').value;
                        if (!date) {
                            Swal.showValidationMessage('Please select a date.');
                        }
                        return date;
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        const revisionDate = result.value;

                        // Kirim data ke server untuk menyimpan revision date
                        $.ajax({
                            url: '/ppic-eticket/ppic/revision-date',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                no_po: poNo,
                                revision_date: revisionDate,
                            },
                            success: function (response) {
                                Swal.fire('Success!', 'Revision date updated.', 'success');
                                $('#ppic-data-table').DataTable().ajax.reload();
                            },
                            error: function (xhr) {
                                console.error(xhr.responseText);
                                Swal.fire('Error!', 'Failed to update revision date.', 'error');
                            },
                        });
                    }
                });
            });

            // Event untuk ikon Not Accept
            $(document).ready(function () {
                $('#ppic-data-table').on('click', '.not-accept-icon', function () {
                    var table = $('#ppic-data-table').DataTable();
                    var data = table.row($(this).parents('tr')).data();

                    // Set No. PO ke modal
                    $('#hiddenPoNo').val(data.no_po);

                    // Tampilkan modal Reason
                    $('#reasonModal').modal('show');
                });

                // Event untuk submit form Reason
                $('#reasonForm').on('submit', function (e) {
                    e.preventDefault(); // Cegah form dari reload halaman

                    var reason = $('#reasonInput').val();
                    var poNo = $('#hiddenPoNo').val();

                    if (!reason.trim()) {
                        Swal.fire('Error!', 'Please provide a valid reason.', 'error');
                        return;
                    }

                    // SweetAlert konfirmasi
                    Swal.fire({
                        title: 'Are you sure?',
                        text: `Submit reason for PO ${poNo}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, submit it!',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim data ke server (AJAX POST)
                            $.ajax({
                                url: '/ppic-eticket/ppic/not-accept', // URL sesuai dengan route:list
                                method: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    no_po: poNo,
                                    reason: reason,
                                },
                                success: function (response) {
                                    // SweetAlert sukses
                                    Swal.fire({
                                        title: 'Submitted!',
                                        text: 'Reason successfully submitted.',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                    }).then(() => {
                                        $('#reasonModal').modal('hide');
                                        $('#ppic-data-table').DataTable().ajax.reload(null, false);
                                    });
                                },
                                error: function (xhr) {
                                    console.error(xhr.responseText);
                                    // SweetAlert error
                                    Swal.fire('Error!', 'Failed to submit reason. Please try again.', 'error');
                                },
                            });
                        }
                    });
                });
            });

        });
    </script> -->
    <script>
        $(document).ready(function () {
            const table = $('#ppic-data-table').DataTable({
                ajax: {
                    url: '/ppic-eticket/ppic/requests',
                    dataSrc: '',
                },
                columns: [
                    {
                        data: null,
                        defaultContent: `
                            <button class="btn btn-link btn-info btn-lg btn-detail" data-toggle="modal" data-target="#detailModalPpic">
                                <i class="fa fa-eye"></i>
                            </button>
                        `,
                        orderable: false,
                    },
                    {
                        data: 'status',
                        render: function (data) {
                            if (data === 'open') return '<span class="badge badge-danger">Open</span>';
                            if (data === 'revision') return '<span class="badge badge-info">Revision Date</span>';
                            if (data === 'preparing') return '<span class="badge badge-warning">Preparing</span>';
                            if (data === 'reject') return '<span class="badge badge-secondary">Reject</span>';
                            return '<span class="badge badge-default">Unknown</span>';
                        },
                    },
                    { data: 'no_po' },
                    {
                        data: 'created_at',
                        render: function (data) {
                            return data ? new Date(data).toISOString().split('T')[0] : 'N/A';
                        },
                    },
                    { data: 'incoterm' },
                    { data: 'customer' },
                    { data: 'material' },
                    { data: 'nama_barang_asli' },
                    {
                        data: 'status',
                        orderable: false,
                        render: function (data, type, row) {
                            if (data === 'open') {
                                return `
                                    <button class="btn btn-success btn-round accept-icon btn-sm" style="margin-right: 10px;">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button class="btn btn-default btn-round revision-date-btn btn-sm" style="margin-right: 10px;" data-po="${row.no_po}">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                    <button class="btn btn-danger btn-round not-accept-icon btn-sm">
                                        <i class="fa fa-times"></i>
                                    </button>
                                `;
                            } else {
                                return `
                                    
                                `;
                            }
                        },
                    },
                ],
                pageLength: 10,
                responsive: true,
            });

            // Event untuk tombol detail
            $('#ppic-data-table').on('click', '.btn-detail', function () {
                const data = table.row($(this).parents('tr')).data();

                // Isi data ke modal detail
                $('#modalNoPo').val(data.no_po);
                $('#modalIncoterm').val(data.incoterm);
                $('#modalCustomer').val(data.customer);
                $('#modalMaterial').val(data.material);
                $('#modalNamaBarangAsli').val(data.nama_barang_asli);
                $('#modalNamaBarangJual').val(data.nama_barang_jual);
                $('#modalQty').val(data.qty);
                $('#modalUom').val(data.uom);
                $('#modalAlamatKirim').val(data.alamat_kirim);
                $('#modalKemasan').val(data.kemasan);
                $('#modalGudangPengambilan').val(data.gudang_pengambilan);
                $('#modalTanggalTiba').val(data.tanggal_tiba);

                // Render daftar produk ke dalam modal
                const productList = $('#modalProductList'); // Elemen daftar produk di modal
                productList.empty(); // Kosongkan daftar produk sebelumnya
                if (data.products && data.products.length > 0) {
                    data.products.forEach(product => {
                        productList.append(`<li class="list-group-item">${product}</li>`);
                    });
                } else {
                    productList.append('<li class="list-group-item text-muted">No products available</li>');
                }
                

            });

            // Event untuk tombol Accept
            $('#ppic-data-table').on('click', '.accept-icon', function () {
                const data = table.row($(this).parents('tr')).data();

                // Isi data ke dalam modal
                $('#modalPoNo').val(data.no_po);
                $('#acceptModal').modal('show');
            });

            // Submit form di modal Accept
            $('#acceptForm').on('submit', function (e) {
                e.preventDefault();

                const poNo = $('#modalPoNo').val();
                const loadingDate = $('#loadingDate').val();
                const arrivingDate = $('#arrivingDate').val();
                const salesOrderType = $('#salesOrderType').val();

                if (!loadingDate || !arrivingDate || !salesOrderType) {
                    Swal.fire('Error!', 'All fields are required!', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will update the status to Preparing.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/ppic-eticket/update-status-preparing',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                no_po: poNo,
                                loading_date: loadingDate,
                                arriving_date: arrivingDate,
                                sales_order_type: salesOrderType,
                                status: 'preparing',
                            },
                            success: function (response) {
                                Swal.fire('Success!', 'Status updated to Preparing.', 'success').then(() => {
                                    $('#acceptModal').modal('hide');
                                    table.ajax.reload();
                                });
                            },
                            error: function (xhr) {
                                const response = xhr.responseJSON;
                                Swal.fire('Error!', response?.message || 'Failed to update status.', 'error');
                            },
                        });
                    }
                });
            });


            // Event untuk tombol Revision Date
            $('#ppic-data-table').on('click', '.revision-date-btn', function () {
                const poNo = $(this).data('po');

                Swal.fire({
                    title: 'Set Revision Date',
                    html: `<input type="date" id="revisionDateInput" class="form-control" />`,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const date = document.getElementById('revisionDateInput').value;
                        if (!date) {
                            Swal.showValidationMessage('Please select a date.');
                        }
                        return date;
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        const revisionDate = result.value;

                        $.ajax({
                            url: '/ppic-eticket/ppic/revision-date',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: { no_po: poNo, revision_date: revisionDate },
                            success: function (response) {
                                Swal.fire('Success!', 'Revision date updated.', 'success');
                                table.ajax.reload();
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', 'Failed to update revision date.', 'error');
                            },
                        });
                    }
                });
            });

            // Event untuk ikon Not Accept
            $('#ppic-data-table').on('click', '.not-accept-icon', function () {
                const data = table.row($(this).parents('tr')).data();

                $('#hiddenPoNo').val(data.no_po);
                $('#reasonModal').modal('show');
            });

            // Event untuk submit form Reason
            $('#reasonForm').on('submit', function (e) {
                e.preventDefault();

                const reason = $('#reasonInput').val();
                const poNo = $('#hiddenPoNo').val();

                if (!reason.trim()) {
                    Swal.fire('Error!', 'Please provide a valid reason.', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Submit reason for PO ${poNo}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/ppic-eticket/ppic/not-accept',
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                no_po: poNo,
                                reason: reason,
                            },
                            success: function (response) {
                                Swal.fire('Submitted!', 'Reason successfully submitted.', 'success').then(() => {
                                    $('#reasonModal').modal('hide');
                                    table.ajax.reload();
                                });
                            },
                            error: function () {
                                Swal.fire('Error!', 'Failed to submit reason. Please try again.', 'error');
                            },
                        });
                    }
                });
            });
        });
    </script>

</body>
</html>
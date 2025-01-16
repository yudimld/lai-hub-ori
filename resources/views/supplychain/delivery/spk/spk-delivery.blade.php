<!DOCTYPE html>
<html lang="en">
@php
    $title = 'Data SPK Delivery';
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
								<h2 class="text-white pb-2 fw-bold">List of Delivery Data</h2>
								<h5 class="text-white op-7 mb-2">List SPK untuk Delivery Yang sudah Dibuat</h5>
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
                                        <div class="table-responsive">
                                            <table id="delivery-data-table" class="display table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Detail</th>
                                                        <th>Status</th>
                                                        <th>PO Number</th>
                                                        <th>SO Number</th>
                                                        <th>Customer</th>
                                                        <th>Material</th>
                                                        <th>Nama Barang</th>
                                                        <th>Qty</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Detail -->
                                <!-- <div class="modal fade" id="detailModalPpic" tabindex="-1" role="dialog" aria-labelledby="detailModalPpicLabel" aria-hidden="true">
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
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round btn-sm" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
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

                            <!-- modal detail -->
                            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                            <h5 class="modal-title fw-bold" id="detailModalLabel" style="text-align: center; flex: 1;">Detail Delivery</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <!-- Row 1 -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">PO Number:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="po-number">-</p>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">SO Number:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="so-number">-</p>
                                                    </div>
                                                </div>

                                                <!-- Row 2 -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Tanggal Tiba:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="tanggal-tiba">-</p>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Customer:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="customer">-</p>
                                                    </div>
                                                </div>

                                                <!-- Row 3 -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Material:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="material">-</p>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Nama Barang Asli:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="nama-barang-asli">-</p>
                                                    </div>
                                                </div>

                                                <!-- Row 4 -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Nama Barang Jual:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="nama-barang-jual">-</p>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Quantity:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="qty">-</p>
                                                    </div>
                                                </div>

                                                <!-- Row 5 -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">UOM:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="uom">-</p>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Alamat Kirim:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="alamat-kirim">-</p>
                                                    </div>
                                                </div>

                                                <!-- Row 6 -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Kemasan:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="kemasan">-</p>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Gudang Pengambilan:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="gudang-pengambilan">-</p>
                                                    </div>
                                                </div>

                                                <!-- Row 7 -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Status:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="status">-</p>
                                                    </div>
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <strong style="width: 40%;">Attachments File:</strong>
                                                        <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="file-link">No file available</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
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

    <!-- tabel dan detail -->
    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable
            $('#delivery-data-table').DataTable({
                processing: true,
                ajax: {
                    url: '{{ route('delivery.requests') }}', // Endpoint API
                    type: 'GET',
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-link btn-info detail-btn" data-toggle="modal" data-target="#detailModal">
                                    <i class="fa fa-eye"></i>
                                </button>`;
                        }
                    },
                    {
                        data: 'status',
                        render: function (data) {
                            if (!data) return '<span class="badge badge-info">Unknown</span>';
                            if (data.toLowerCase() === 'open') return '<span class="badge badge-danger">Open</span>';
                            if (data.toLowerCase() === 'assigned') return '<span class="badge badge-warning">Assigned</span>';
                            if (data.toLowerCase() === 'delivery') return '<span class="badge badge-success">Delivery</span>';
                            if (data.toLowerCase() === 'close') return '<span class="badge badge-secondary">Close</span>';
                            return '<span class="badge badge-info">Unknown</span>';
                        },
                    },
                    { data: 'po_number' },
                    { data: 'so_number' },
                    { data: 'customer' },
                    { data: 'material' },
                    { data: 'nama_barang_asli' },
                    { data: 'qty' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            // Render tombol berdasarkan status
                            if (row.status.toLowerCase() === 'open') {
                                return `
                                    <button class="btn btn-success btn-sm accept-icon" title="Accept">
                                        <i class="fa fa-check"></i>
                                    </button>`;
                            } else if (row.status.toLowerCase() === 'delivery') {
                                return `
                                    <button class="btn btn-primary btn-sm close-icon" title="Close">
                                        <i class="fa fa-times-circle"></i>
                                    </button>`;
                            }
                            return ''; // Tidak ada tombol jika status bukan 'open' atau 'delivery'
                        },
                        orderable: false
                    }
                ]
            });

            // Event klik tombol "Detail"
            $('#delivery-data-table').on('click', '.detail-btn', function () {
                // Ambil data baris terkait
                var data = $('#delivery-data-table').DataTable().row($(this).parents('tr')).data();

                // Isi modal dengan data lainnya
                $('#po-number').text(data.po_number || '-');
                $('#so-number').text(data.so_number || '-');
                $('#tanggal-tiba').text(data.tanggal_tiba || '-');
                $('#customer').text(data.customer || '-');
                $('#material').text(data.material || '-');
                $('#nama-barang-asli').text(data.nama_barang_asli || '-');
                $('#nama-barang-jual').text(data.nama_barang_jual || '-');
                $('#qty').text(data.qty || '-');
                $('#uom').text(data.uom || '-');
                $('#alamat-kirim').text(data.alamat_kirim || '-');
                $('#kemasan').text(data.kemasan || '-');
                $('#gudang-pengambilan').text(data.gudang_pengambilan || '-');
                $('#status').text(data.status || '-');

                // Isi link file
                if (data.file_path) {
                    const fileUrl = `/storage/${data.file_path}`; // Pastikan path sesuai dengan konfigurasi Laravel
                    $('#file-link').html(`<a href="${fileUrl}" target="_blank">${data.file_name || 'Download File'}</a>`);
                } else {
                    $('#file-link').html(`<span>No file available</span>`);
                }
            });


            // Event untuk ikon Accept (Status Open)
            $('#delivery-data-table').on('click', '.accept-icon', function () {
                var table = $('#delivery-data-table').DataTable();
                var data = table.row($(this).parents('tr')).data();

                // SweetAlert konfirmasi
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to accept this delivery?',
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
                            url: '{{ route("delivery.update-status-delivery") }}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                po_number: data.po_number,
                            },
                            success: function (response) {
                                Swal.fire({
                                    title: 'Accepted!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    table.ajax.reload(); // Reload tabel
                                });
                            },
                            error: function (xhr) {
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

            // Event untuk ikon Close (Status Delivery)
            $('#delivery-data-table').on('click', '.close-icon', function () {
                var table = $('#delivery-data-table').DataTable();
                var data = table.row($(this).parents('tr')).data();

                // SweetAlert dengan input alasan
                Swal.fire({
                    title: 'Provide a Reason',
                    text: `Why do you want to close delivery for PO: ${data.po_number}?`,
                    input: 'textarea', // Tipe input textarea
                    inputLabel: 'Reason for Closing',
                    inputPlaceholder: 'Enter your reason here...',
                    inputAttributes: {
                        'aria-label': 'Enter your reason here' // Aksesibilitas
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'You need to provide a reason!'; // Validasi input kosong
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika alasan dikonfirmasi, kirim data ke server
                        $.ajax({
                            url: '{{ route("delivery.close") }}', // Endpoint untuk close delivery
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                po_number: data.po_number, // Nomor PO
                                reason: result.value,      // Alasan dari input
                            },
                            success: function (response) {
                                Swal.fire({
                                    title: 'Closed!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                }).then(() => {
                                    table.ajax.reload(null, false); // Reload tabel tanpa reset pagination
                                });
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON.message || 'Failed to close the delivery. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>

</body>
</html>
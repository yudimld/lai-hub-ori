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

                            <!-- Modal Deliver -->
                            <div class="modal fade" id="deliverModal" tabindex="-1" role="dialog" aria-labelledby="deliverModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title" id="deliverModalLabel">Set Delivery and Arriving Date</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="deliverForm">
                                            <div class="modal-body">
                                                <!-- Revision Notes -->
                                                <div id="revisionNotes" style="display: none; margin-bottom: 15px;">
                                                    <div class="alert alert-info">
                                                        <strong>Revision Details:</strong><br>
                                                        <span id="revisionDateNote">Revision Date: -</span><br>
                                                        <span id="reasonNote">Reason: -</span>
                                                    </div>
                                                </div>
                                                <!-- Delivery Date -->
                                                <div class="form-group">
                                                    <label for="deliveryDateInput">Delivery Date</label>
                                                    <input type="date" class="form-control" id="deliveryDateInput" name="delivery_date" required>
                                                </div>
                                                <!-- Arriving Date -->
                                                <div class="form-group">
                                                    <label for="arrivingDateInput">Arriving Date</label>
                                                    <input type="date" class="form-control" id="arrivingDateInput" name="arriving_date" required>
                                                </div>
                                                <input type="hidden" id="hiddenPoNumber" name="po_number">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success btn-round">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Revision Date -->
                            <div class="modal fade" id="revisionModal" tabindex="-1" role="dialog" aria-labelledby="revisionModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark text-white">
                                            <h5 class="modal-title" id="revisionModalLabel">Revision Details</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="revisionForm">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="revisionDateInput">Revision Date</label>
                                                    <input type="date" class="form-control" id="revisionDateInput" name="revision_date" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="revisionReasonInput">Reason</label>
                                                    <textarea class="form-control" id="revisionReasonInput" name="reason_revision" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning btn-round">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Reject -->
                            <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="rejectModalLabel">Reject Delivery</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="rejectForm">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="rejectReasonInput">Reason for Rejection</label>
                                                    <textarea class="form-control" id="rejectReasonInput" name="reason" rows="4" required></textarea>
                                                </div>
                                                <input type="hidden" id="rejectPoNumber" name="po_number"> <!-- Hidden field for PO Number -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round btn-sm" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger btn-round btn-sm">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Arriving -->
                            <div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="attachmentModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title" id="attachmentModalLabel">Upload Attachment</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="attachmentForm" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="attachmentInput">Select Attachment File</label>
                                                    <input type="file" class="form-control" id="attachmentInput" name="file" required>
                                                </div>
                                                <input type="hidden" id="hiddenPoNumberAttachment" name="po_number"> <!-- Field untuk PO Number -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round btn-sm" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success btn-round btn-sm">Upload</button>
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
                            if (data.toLowerCase() === 'deliver') return '<span class="badge badge-warning">Deliver</span>';
                            if (data.toLowerCase() === 'revision') return '<span class="badge badge-default">Revision Date</span>'; // hitam
                            if (data.toLowerCase() === 'arriving') return '<span class="badge badge-success">Arriving</span>';
                            if (data.toLowerCase() === 'rejected') return '<span class="badge badge-secondary">Reject</span>';
                            return '<span class="badge badge-secondary">Unknown</span>';
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
                                    <button class="btn btn-warning btn-round btn-sm deliver-btn" title="Deliver">
                                        <i class="fa fa-truck"></i> 
                                    </button>
                                    <button class="btn btn-dark btn-round btn-sm revision-btn" 
                                                    title="Revision"
                                                    data-revision-date="${row.revision_date || ''}"
                                                    data-reason="${row.reason || ''}">
                                                    <i class="fa fa-calendar"></i>
                                    </button>
                                    <button class="btn btn-danger btn-round btn-sm reject-btn" title="Reject">
                                        <i class="fa fa-times"></i> 
                                    </button>`;
                            } else if (row.status.toLowerCase() === 'deliver') {
                                return `
                                    <button class="btn btn-success btn-round btn-sm close-icon" title="Close">
                                        <i class="fa fa-plane-arrival"></i>
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

        });
    </script>

    <!-- tombol deliver -->
    <script>
        $(document).ready(function () {
            // Event untuk tombol Deliver
            $('#delivery-data-table').on('click', '.deliver-btn', function () {
                // Ambil data dari baris terkait
                var data = $('#delivery-data-table').DataTable().row($(this).parents('tr')).data();

                // Isi hidden input dengan nomor PO
                $('#hiddenPoNumber').val(data.po_number);

                // Reset form
                $('#deliveryDateInput').val('');
                $('#arrivingDateInput').val('');

                // Tampilkan Revision Notes hanya jika data tersedia
                if (data.revision_date || data.reason) {
                    $('#revisionNotes').show();
                    $('#revisionDateNote').text(`Revision Date: ${data.revision_date || '-'}`);
                    $('#reasonNote').text(`Reason: ${data.reason || '-'}`);
                } else {
                    $('#revisionNotes').hide();
                }

                // Tampilkan modal
                $('#deliverModal').modal('show');
            });

            // Event Submit Form Deliver
            $('#deliverForm').on('submit', function (e) {
                e.preventDefault();

                // Ambil data dari form
                var poNumber = $('#hiddenPoNumber').val();
                var deliveryDate = $('#deliveryDateInput').val();
                var arrivingDate = $('#arrivingDateInput').val();

                // Validasi input
                if (!deliveryDate || !arrivingDate) {
                    Swal.fire('Error!', 'Delivery Date and Arriving Date are required!', 'error');
                    return;
                }

                // Konfirmasi sebelum submit
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Set delivery and arriving dates for PO: ${poNumber}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim permintaan ke server
                        $.ajax({
                            url: '{{ route("delivery.update-status-delivery") }}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                po_number: poNumber,
                                delivery_date: deliveryDate,
                                arriving_date: arrivingDate,
                            },
                            success: function (response) {
                                Swal.fire('Success!', response.message, 'success').then(() => {
                                    // Reload DataTable setelah berhasil
                                    $('#delivery-data-table').DataTable().ajax.reload(null, false);
                                    // Tutup modal
                                    $('#deliverModal').modal('hide');
                                });
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to update status.', 'error');
                            },
                        });
                    }
                });
            });
        });
    </script>


    <!-- button revision date -->
    <script>
        $(document).ready(function () {
            // Event untuk tombol Revision
            $('#delivery-data-table').on('click', '.revision-btn', function () {
                const data = $('#delivery-data-table').DataTable().row($(this).parents('tr')).data();

                if (!data) {
                    Swal.fire('Error!', 'Failed to retrieve data for revision.', 'error');
                    return;
                }

                // Isi form dengan data jika ada
                $('#revisionDateInput').val(data.revision_date || '');
                $('#revisionReasonInput').val(data.reason_revision || ''); // Ubah ke reason_revision

                $('#revisionModal').data('row-data', data);
                $('#revisionModal').modal('show');
            });

            // Event Submit Form Revision
            $('#revisionForm').on('submit', function (e) {
                e.preventDefault();

                const revisionDate = $('#revisionDateInput').val();
                const reason_revision = $('#revisionReasonInput').val(); // Ubah ke reason_revision

                if (!revisionDate || !reason_revision) {
                    Swal.fire('Error!', 'Revision Date and Reason are required!', 'error');
                    return;
                }

                const rowData = $('#revisionModal').data('row-data');

                if (!rowData || !rowData.id) {
                    Swal.fire('Error!', 'Invalid data for submission.', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to set revision details.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/delivery-spk/revision/${rowData.id}`,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                revision_date: revisionDate,
                                reason_revision: reason_revision, // Ubah ke reason_revision
                            },
                            success: function (response) {
                                Swal.fire('Success!', response.message, 'success').then(() => {
                                    $('#delivery-data-table').DataTable().ajax.reload(null, false);
                                    $('#revisionModal').modal('hide');
                                });
                            },
                            error: function (xhr) {
                                const errorMessage = xhr.responseJSON?.message || 'Failed to update revision.';
                                Swal.fire('Error!', errorMessage, 'error');
                            },
                        });
                    }
                });
            });
        });
    </script>

    <!-- button reject -->
    <script>
        $(document).ready(function () {
            // Event klik untuk tombol Reject
            $('#delivery-data-table').on('click', '.reject-btn', function () {
                // Ambil data baris terkait
                var data = $('#delivery-data-table').DataTable().row($(this).parents('tr')).data();

                // Pastikan data tersedia
                if (!data) {
                    Swal.fire('Error!', 'Failed to retrieve data for rejection.', 'error');
                    return;
                }

                // Isi hidden input dengan nomor PO
                $('#rejectPoNumber').val(data.po_number);

                // Kosongkan alasan sebelumnya (jika ada)
                $('#rejectReasonInput').val('');

                // Tampilkan modal Reject
                $('#rejectModal').modal('show');
            });

            // Event Submit Form Reject
            $('#rejectForm').on('submit', function (e) {
                e.preventDefault();

                // Ambil data dari form
                var poNumber = $('#rejectPoNumber').val();
                var reason = $('#rejectReasonInput').val();

                // Validasi input
                if (!reason) {
                    Swal.fire('Error!', 'Reason for rejection is required!', 'error');
                    return;
                }

                // Konfirmasi sebelum submit
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Reject delivery for PO: ${poNumber}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, reject it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim permintaan ke server
                        $.ajax({
                            url: `/delivery-spk/reject/${poNumber}`, // Endpoint untuk Reject
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: { reason: reason },
                            success: function (response) {
                                Swal.fire('Rejected!', response.message, 'success').then(() => {
                                    // Reload DataTable setelah berhasil
                                    $('#delivery-data-table').DataTable().ajax.reload(null, false);
                                    // Tutup modal
                                    $('#rejectModal').modal('hide');
                                });
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to reject delivery.', 'error');
                            },
                        });
                    }
                });
            });
        });
    </script>

    <!-- button arriving -->
    <script>
        $(document).ready(function () {
            // Event untuk tombol Upload Attachment
            $('#delivery-data-table').on('click', '.close-icon', function () {
                // Ambil data dari baris terkait
                var data = $('#delivery-data-table').DataTable().row($(this).parents('tr')).data();

                // Pastikan data tersedia
                if (!data) {
                    Swal.fire('Error!', 'Failed to retrieve data for attachment upload.', 'error');
                    return;
                }

                // Isi hidden input dengan nomor PO
                $('#hiddenPoNumberAttachment').val(data.po_number);

                // Reset form
                $('#attachmentInput').val('');

                // Tampilkan modal attachment
                $('#attachmentModal').modal('show');
            });

            // Event Submit Form Attachment
            $('#attachmentForm').on('submit', function (e) {
                e.preventDefault();

                // Ambil data form
                var formData = new FormData(this);
                var poNumber = $('#hiddenPoNumberAttachment').val();

                // Debug file input
                console.log('File Input:', $('#attachmentInput').val());
                console.log('FormData:', formData.get('file'));

                // Validasi input file
                if (!formData.get('file')) {
                    Swal.fire('Error!', 'File is required!', 'error');
                    return;
                }

                // Konfirmasi sebelum submit
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Upload attachment for PO: ${poNumber}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, upload it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim permintaan ke server
                        $.ajax({
                            url: `/delivery-spk/upload-attachment/${poNumber}`,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                Swal.fire('Success!', response.message, 'success').then(() => {
                                    // Reload DataTable setelah berhasil
                                    $('#delivery-data-table').DataTable().ajax.reload(null, false);
                                    // Tutup modal
                                    $('#attachmentModal').modal('hide');
                                });
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to upload attachment.', 'error');
                            },
                        });
                    }
                });
            });


        });
    </script>







</body>
</html>
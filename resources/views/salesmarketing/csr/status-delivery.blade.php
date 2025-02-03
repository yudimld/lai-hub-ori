<!DOCTYPE html>
<html lang="en">

@php
    $title = 'List of SO Number';
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
                                <h2 class="text-white pb-2 fw-bold">Status SO</h2>
                                <h5 class="text-white op-7 mb-2">Status List SO Number on Delivery</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-inner mt--5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="fw-bold">Status Data on Delivery</h1>
                                    <hr>
                                    <div class="table-responsive">
                                        <table id="delivery-status-table" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Detail</th>
                                                    <th>Status</th>
                                                    <th>PO Number</th>
                                                    <th>SO Number</th>
                                                    <th>Tanggal Tiba</th>
                                                    <th>Customer</th>
                                                    <th>Nama Barang Jual</th>
                                                    <th>File</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data akan diisi secara otomatis oleh DataTables -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Modal edit status Delivery -->
                                <div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- Header Modal -->
                    
                                            <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <h5 class="modal-title" style="flex: 1; text-align: center;" id="editFileModalLabel">Edit Delivery Details</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- Body Modal -->
                                            <div class="modal-body">
                                                <form id="editFileForm">
                                                    <input type="hidden" id="editFileId">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>No. PO</label>
                                                            <input type="text" class="form-control" id="editFilePoNumber" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>SO Number</label>
                                                            <input type="text" class="form-control" id="editFileSoNumber" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Tanggal Tiba</label>
                                                            <input type="text" class="form-control" id="editFileTanggalTiba" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Customer</label>
                                                            <input type="text" class="form-control" id="editFileCustomer" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Material</label>
                                                            <input type="text" class="form-control" id="editFileMaterial" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Nama Barang Asli</label>
                                                            <input type="text" class="form-control" id="editFileNamaBarangAsli" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Nama Barang Jual</label>
                                                            <input type="text" class="form-control" id="editFileNamaBarangJual" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Qty</label>
                                                            <input type="text" class="form-control" id="editFileQty" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>UoM</label>
                                                            <input type="text" class="form-control" id="editFileUom" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Alamat Kirim</label>
                                                            <input type="text" class="form-control" id="editFileAlamatKirim" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Upload File</label>
                                                            <input type="file" class="form-control" id="editFileInput">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Footer Modal -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary btn-round" id="saveFileChangesButton">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- modal show detail -->
                                <div class="modal fade" id="deliveryStatusModal" tabindex="-1" role="dialog" aria-labelledby="deliveryStatusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- Header Modal -->
                                            <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <h5 class="modal-title" style="flex: 1; text-align: center;" id="deliveryStatusModalLabel">Detail Delivery Status</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            </div>
                                            <!-- Body Modal -->
                                            <div class="modal-body">
                                                <!-- Judul Feedback -->
                                                <div class="col-md-12 text-center">
                                                    <h2 id="feedbackSectionTitle" style="font-size: 1.5rem; font-weight: bold; display: none;"></h2>
                                                </div>

                                                <!-- Feedback Delivery Section -->
                                                <div id="deliveryFeedbackSection" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Delivery Date:</label>
                                                            <input type="date" class="form-control" id="modalDeliveryDate" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Arriving Date:</label>
                                                            <input type="date" class="form-control" id="modalArrivingDate" readonly>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>

                                                <!-- Feedback Revision Section -->
                                                <div id="revisionFeedbackSection" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Revision Date:</label>
                                                            <input type="text" class="form-control" id="modalRevisionDate" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Reason:</label>
                                                            <textarea class="form-control" id="modalReason" rows="2" readonly></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>

                                                <!-- Feedback Rejection Section -->
                                                <div id="modalReasonRejectSection" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Reason Reject:</label>
                                                            <textarea class="form-control" id="modalReasonReject" rows="2" readonly></textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>

                                                <!-- Feedback Arriving Section -->
                                                <div id="arrivingFeedbackSection" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Arriving File:</label>
                                                            <a id="modalArrivingFileLink" href="#" class="form-control text-primary" target="_blank">No File</a>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>

                                                <form id="deliveryStatusForm">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>PO Number:</label>
                                                            <input type="text" class="form-control" id="modalPoNumber" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>SO Number:</label>
                                                            <input type="text" class="form-control" id="modalSoNumber" readonly>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Tanggal Tiba:</label>
                                                            <input type="text" class="form-control" id="modalTanggalTiba" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Customer:</label>
                                                            <input type="text" class="form-control" id="modalCustomer" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Nama Barang Jual:</label>
                                                            <input type="text" class="form-control" id="modalNamaBarangJual" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Status:</label>
                                                            <input type="text" class="form-control" id="modalStatus" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Material:</label>
                                                            <input type="text" class="form-control" id="modalMaterial" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Nama Barang Asli:</label>
                                                            <input type="text" class="form-control" id="modalNamaBarangAsli" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Qty:</label>
                                                            <input type="text" class="form-control" id="modalQty" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>UoM:</label>
                                                            <input type="text" class="form-control" id="modalUom" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Alamat Kirim:</label>
                                                            <input type="text" class="form-control" id="modalAlamatKirim" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Kemasan:</label>
                                                            <input type="text" class="form-control" id="modalKemasan" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Gudang Pengambilan:</label>
                                                            <input type="text" class="form-control" id="modalGudangPengambilan" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>File:</label>
                                                            <a id="modalFileLink" href="#" class="form-control text-primary" target="_blank">No File</a>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Updated At:</label>
                                                            <input type="text" class="form-control" id="modalUpdatedAt" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Created At:</label>
                                                            <input type="text" class="form-control" id="modalCreatedAt" readonly>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Footer Modal -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
                                                <!-- Tombol Customer Accept -->
                                                <button id="customerAcceptButton" type="button" class="btn btn-success btn-round" style="display: none;">Customer Accept</button>
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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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
    
    <!-- tabel status delivery -->
    <script>
        $(document).ready(function () {    
            // Inisialisasi DataTable
            var deliveryStatusTable = $('#delivery-status-table').DataTable({
                "processing": true,
                "serverSide": false,
                "ajax": {
                    "url": "/salesmarketing/csr/status-delivery", 
                    "type": "GET",
                    "dataSrc": "data",
                },
                "order": [
                    [7, "desc"], // Kolom updated_at (diurutkan menurun)
                    [8, "desc"], // Kolom created_at (diurutkan menurun)
                ],
                "columns": [
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return `
                                <button class="btn btn-link btn-lg btn-show-detail" 
                                    data-toggle="modal" 
                                    data-target="#deliveryStatusModal"
                                    data-po-number="${row.po_number}"
                                    data-so-number="${row.so_number}"
                                    data-tanggal-tiba="${row.tanggal_tiba}"
                                    data-customer="${row.customer}"
                                    data-nama-barang-jual="${row.nama_barang_jual}"
                                    data-status="${row.status}"
                                    data-material="${row.material || ''}"
                                    data-nama-barang-asli="${row.nama_barang_asli || ''}"
                                    data-qty="${row.qty || ''}"
                                    data-uom="${row.uom || ''}"
                                    data-alamat-kirim="${row.alamat_kirim || ''}"
                                    data-kemasan="${row.kemasan || ''}"
                                    data-gudang-pengambilan="${row.gudang_pengambilan || ''}"
                                    data-delivery-date="${row.delivery_date || ''}"
                                    data-arriving-date="${row.arriving_date || ''}"
                                    data-revision-date="${row.revision_date || ''}" 
                                    data-reason="${row.reason || ''}" 
                                    data-updated-at="${row.updated_at || ''}"
                                    data-created-at="${row.created_at || ''}"
                                    data-file-name="${row.file_name || ''}"
                                    data-file-arriving="${row.file_arriving || ''}"
                                    data-file-name-delivery="${row.file_name_delivery || ''}"
                                    data-file-pendukung-delivery="${row.file_pendukung_delivery || ''}" 
                                    data-reason-revision="${row.reason_revision || ''}" 
                                    data-reason-reject="${row.reason_reject || ''}">
                                    <i class="fa fa-eye"></i>
                                </button>`;
                        }
                    },
                    {
                        data: 'status',
                        render: function (data) {
                            if (!data) return '<span class="badge badge-info">Unknown</span>';
                            if (data.toLowerCase() === 'open') return '<span class="badge badge-danger">Open</span>'; // Merah
                            if (data.toLowerCase() === 'deliver') return '<span class="badge badge-warning">Deliver</span>'; // Biru
                            if (data.toLowerCase() === 'revision') return '<span class="badge badge-default">Revision Date</span>'; // Biru
                            if (data.toLowerCase() === 'arriving') return '<span class="badge badge-success">Arriving</span>'; // Hijau
                            if (data.toLowerCase() === 'rejected') return '<span class="badge badge-secondary">Reject</span>'; // Hijau
                            return '<span class="badge badge-primary">Unknown</span>';
                        }
                    },
                    { "data": "po_number" },
                    { "data": "so_number" },
                    {
                        data: 'tanggal_tiba',
                        render: function (data, type, row) {
                            if (data) {
                                const date = new Date(data); // Konversi ke objek Date
                                return date.toLocaleDateString('en-CA'); // Format YYYY-MM-DD
                            }
                            return 'N/A'; // Jika data kosong
                        }
                    },
                    { "data": "customer" },
                    { "data": "nama_barang_jual" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            if (row.file_pendukung_delivery) { // Menggunakan file_pendukung_delivery
                                return `
                                    <a href="${row.file_pendukung_delivery}" target="_blank" class="text-primary">
                                        <i class="fa fa-download"></i> ${row.file_name_delivery || 'Download File'}
                                    </a>`;
                                    // console.log('File Pendukung Delivery URL:', row.file_pendukung_delivery);

                            } else {
                                return `<span class="text-muted">No file uploaded</span>`;
                            }
                        }
                    },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            // Tampilkan tombol hanya untuk status 'open'
                            if (row.status.toLowerCase() === 'open') {
                                return `
                                    <div class="d-flex justify-content-center">
                                        <!-- Icon Edit -->
                                        <button class="btn btn-link text-primary edit-btn" 
                                            data-toggle="modal" 
                                            data-target="#editFileModal"
                                            data-id="${row.id}" 
                                            data-po-number="${row.po_number}" 
                                            data-so-number="${row.so_number}" 
                                            data-tanggal-tiba="${row.tanggal_tiba}" 
                                            data-customer="${row.customer}" 
                                            data-material="${row.material || ''}" 
                                            data-nama-barang-asli="${row.nama_barang_asli || ''}" 
                                            data-nama-barang-jual="${row.nama_barang_jual}" 
                                            data-qty="${row.qty || ''}" 
                                            data-uom="${row.uom || ''}" 
                                            data-alamat-kirim="${row.alamat_kirim || ''}" 
                                            data-kemasan="${row.kemasan || ''}" 
                                            data-gudang-pengambilan="${row.gudang_pengambilan || ''}" 
                                            data-status="${row.status || ''}" 
                                            data-file-delivery="${row.file_pendukung_delivery || ''}" 
                                            data-file-name="${row.file_name || ''}" 
                                            data-file-name-delivery="${row.file_name_delivery || ''}"
                                            data-file-pendukung-delivery="${row.file_pendukung_delivery || ''}" 
                                            data-updated-at="${row.updated_at || ''}" 
                                            data-created-at="${row.created_at || ''}">        
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <!-- Tombol Delete -->
                                        <button class="btn btn-link text-danger btn-delete" data-id="${row.id}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>`;
                            } else {
                                // Kosongkan kolom untuk status selain 'open'
                                return `<span class="text-muted"></span>`;
                            }
                        }
                    }
                ]
            });
        });
    </script>

    <!-- JS show detail modal -->
    <script>
        // Event klik untuk tombol detail menggunakan event delegation
        $('#delivery-status-table').on('click', '.btn-show-detail', function () {
            // Ambil data dari atribut tombol
            const poNumber = $(this).data('po-number');
            const soNumber = $(this).data('so-number');
            const tanggalTiba = $(this).data('tanggal-tiba');
            const customer = $(this).data('customer');
            const namaBarangJual = $(this).data('nama-barang-jual');
            const status = $(this).data('status');
            const material = $(this).data('material');
            const namaBarangAsli = $(this).data('nama-barang-asli');
            const qty = $(this).data('qty');
            const uom = $(this).data('uom');
            const alamatKirim = $(this).data('alamat-kirim');
            const kemasan = $(this).data('kemasan');
            const gudangPengambilan = $(this).data('gudang-pengambilan');
            const deliveryDate = $(this).data('delivery-date');
            const arrivingDate = $(this).data('arriving-date');
            const revisionDate = $(this).data('revision-date');
            const reason = $(this).data('reason');
            const updatedAt = $(this).data('updated-at');
            const createdAt = $(this).data('created-at');
            const filePendukungDelivery = $(this).data('file-pendukung-delivery'); 
            const fileName = $(this).data('file-name');
            const fileNameDelivery = $(this).data('file-name-delivery');
            const fileArriving = $(this).data('file-arriving');
            const reasonReject = $(this).data('reason-reject');
            const reasonRevision = $(this).data('reason-revision');
            console.log('File Arriving:', fileArriving);

            // Isi data lain di modal
            $('#modalPoNumber').val(poNumber);
            $('#modalSoNumber').val(soNumber);
            $('#modalTanggalTiba').val(tanggalTiba);
            $('#modalCustomer').val(customer);
            $('#modalNamaBarangJual').val(namaBarangJual);
            $('#modalStatus').val(status);
            $('#modalMaterial').val(material);
            $('#modalNamaBarangAsli').val(namaBarangAsli);
            $('#modalQty').val(qty);
            $('#modalUom').val(uom);
            $('#modalAlamatKirim').val(alamatKirim);
            $('#modalKemasan').val(kemasan);
            $('#modalGudangPengambilan').val(gudangPengambilan);
            $('#modalUpdatedAt').val(updatedAt);
            $('#modalCreatedAt').val(createdAt);
            
            if (filePendukungDelivery) {
                $('#modalFileLink')
                    .attr('href', filePendukungDelivery)
                    .text(fileNameDelivery || 'Download File')
                    .removeClass('text-muted')
                    .addClass('text-primary');
            } else {
                $('#modalFileLink')
                    .attr('href', '#')
                    .text('No File')
                    .removeClass('text-primary')
                    .addClass('text-muted');
            }


             // Reset dan sembunyikan semua bagian modal
            $('#deliveryFeedbackSection').hide();
            $('#revisionFeedbackSection').hide();
            $('#arrivingFeedbackSection').hide();
            $('#modalReasonRejectSection').hide();
            $('#feedbackSectionTitle').text('').hide();

            // Bersihkan nilai input sebelum menampilkan data
            $('#modalDeliveryDate').val('');
            $('#modalArrivingDate').val('');
            $('#modalRevisionDate').val('');
            $('#modalReason').val('');
            $('#modalArrivingFileLink')
                .attr('href', '#')
                .text('No File')
                .removeClass('text-primary')
                .addClass('text-muted');
            $('#modalReasonReject').val('');

            // Tampilkan data sesuai status
            if (status && status.toLowerCase() === 'rejected') {
                $('#modalReasonRejectSection').show();
                $('#modalReasonReject').val(reasonReject);
                $('#feedbackSectionTitle').text('Feedback Delivery: Reason for Rejection').show();
            } else if (status && status.toLowerCase() === 'revision') {
                $('#revisionFeedbackSection').show();
                $('#modalRevisionDate').val(revisionDate);
                $('#modalReason').val(reasonRevision);
                $('#feedbackSectionTitle').text('Feedback Delivery: Revision Details').show();
            } else if (status && status.toLowerCase() === 'deliver') {
                $('#deliveryFeedbackSection').show();
                $('#modalDeliveryDate').val(deliveryDate);
                $('#modalArrivingDate').val(arrivingDate);
                $('#feedbackSectionTitle').text('Feedback Delivery: Delivery Details').show();
            } else if (status && status.toLowerCase() === 'arriving') {
                $('#arrivingFeedbackSection').show();
                    if (fileArriving) {
                        $('#modalArrivingFileLink')
                            .attr('href', fileArriving) // Set href ke fileArriving
                            .text('Download Arriving File') // Tampilkan teks "Download Arriving File"
                            .removeClass('text-muted')
                            .addClass('text-primary');
                    } else {
                        $('#modalArrivingFileLink')
                            .text('No File') // Tampilkan teks "No File"
                            .removeClass('text-primary')
                            .addClass('text-muted');
                    }

                $('#feedbackSectionTitle').text('Feedback Delivery: Arriving File').show();
            } else if (status && status.toLowerCase() === 'open') {
                // Jangan tampilkan feedbackSectionTitle untuk status open
                $('#feedbackSectionTitle').hide();
            } else {
                $('#feedbackSectionTitle').text('Feedback Delivery: No Details Available').show();
            }        
            // Logika menampilkan tombol Customer Accept
            if (status && status.toLowerCase() === 'revision') {
                $('#customerAcceptButton').show(); // Tampilkan tombol
            } else {
                $('#customerAcceptButton').hide(); // Sembunyikan tombol
            }

            // Tampilkan modal
            $('#deliveryStatusModal').modal('show');
        });
    </script>


    <!-- js btn delete  -->
    <script>
        // Button Delete
        $('#delivery-status-table').on('click', '.btn-delete', function () {
            const id = $(this).data('id'); // Ambil ID dari atribut data-id
            console.log('Delete ID:', id); // Debugging ID

            if (!id) {
                Swal.fire({
                    title: 'Error!',
                    text: 'No valid ID found for this record.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
                return;
            }

            // Konfirmasi sebelum menghapus
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won’t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan penghapusan jika dikonfirmasi
                    fetch(`/salesmarketing/csr/delivery/delete/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, // CSRF token
                        },
                    })
                        .then((response) => {
                            if (!response.ok) throw new Error('Failed to delete data');
                            return response.json();
                        })
                        .then((responseData) => {
                            Swal.fire({
                                title: 'Deleted!',
                                text: responseData.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then(() => {
                                // Reload tabel setelah data dihapus
                                $('#delivery-status-table').DataTable().ajax.reload(null, false);
                            });
                        })
                        .catch((error) => {
                            console.error('Error:', error); // Debugging
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to delete data. Please try again later.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        });
                }
            });
        });
    </script>

    <!-- js btn edit  -->
    <script>
        // Button Edit
        $('#delivery-status-table').on('click', '.edit-btn', function () {
            // Ambil data dari atribut tombol
            const id = $(this).data('id');
            const poNumber = $(this).data('po-number');
            const soNumber = $(this).data('so-number');
            const tanggalTiba = $(this).data('tanggal-tiba');
            const customer = $(this).data('customer');
            const material = $(this).data('material');
            const namaBarangAsli = $(this).data('nama-barang-asli');
            const namaBarangJual = $(this).data('nama-barang-jual');
            const qty = $(this).data('qty');
            const uom = $(this).data('uom');
            const alamatKirim = $(this).data('alamat-kirim');
            const kemasan = $(this).data('kemasan');
            const gudangPengambilan = $(this).data('gudang-pengambilan');
            const filePendukungDelivery = $(this).data('file-pendukung-delivery'); 
            const fileName = $(this).data('file-name');
            const fileNameDelivery = $(this).data('file-name-delivery');
            const updatedAt = $(this).data('updated-at');
            const createdAt = $(this).data('created-at');

            // Isi modal dengan data
            $('#editFileId').val(id);
            $('#editFilePoNumber').val(poNumber);
            $('#editFileSoNumber').val(soNumber);
            $('#editFileTanggalTiba').val(tanggalTiba);
            $('#editFileCustomer').val(customer);
            $('#editFileMaterial').val(material);
            $('#editFileNamaBarangAsli').val(namaBarangAsli);
            $('#editFileNamaBarangJual').val(namaBarangJual);
            $('#editFileQty').val(qty);
            $('#editFileUom').val(uom);
            $('#editFileAlamatKirim').val(alamatKirim);
            $('#editFileKemasan').val(kemasan);
            $('#editFileGudangPengambilan').val(gudangPengambilan);
            $('#editFileStatus').val(status);
            $('#editFileUpdatedAt').val(updatedAt);
            $('#editFileCreatedAt').val(createdAt);

            if (filePendukungDelivery) {
                $('#editFileLink')
                    .attr('href', filePendukungDelivery)
                    .text(fileNameDelivery || 'Download File')
                    .removeClass('text-muted')
                    .addClass('text-primary');
            } else {
                $('#editFileLink')
                    .attr('href', '#')
                    .text('No file uploaded')
                    .removeClass('text-primary')
                    .addClass('text-muted');
            }

            // Tampilkan modal
            $('#editFileModal').modal('show');
        });

        // Event untuk tombol Save Changes
        $('#saveFileChangesButton').on('click', function () {
            // Ambil ID dari input hidden
            const id = $('#editFileId').val();

            // Periksa apakah file diunggah
            const fileInput = $('#editFileInput')[0].files[0];
            if (!fileInput) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select a file to upload.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
                return;
            }

            // Buat objek FormData
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}'); // Tambahkan CSRF token
            formData.append('file', fileInput);

            // Kirim data ke server
            $.ajax({
                url: `/salesmarketing/csr/delivery/upload-file/${id}`, // URL untuk request
                method: 'POST',
                data: formData,
                processData: false, // Jangan proses data
                contentType: false, // Jangan tetapkan Content-Type secara otomatis
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'File successfully uploaded.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        // Tutup modal
                        $('#editFileModal').modal('hide');

                        // Reset form di dalam modal
                        $('#editFileForm')[0].reset();

                        // Reload DataTable
                        $('#delivery-status-table').DataTable().ajax.reload(null, false);
                        
                        // Pastikan urutan tetap
                        $('#delivery-status-table').DataTable().order([[7, 'desc'], [8, 'desc']]).draw();
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to upload file. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                    console.error('Error:', xhr.responseText); // Debugging
                },
            });
        });
    </script>

    <!-- Btn Customer Accept -->
     <script>
        $('#customerAcceptButton').on('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to accept the revision?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, accept it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan ke server
                    const id = $('#modalPoNumber').val(); // Ambil PO Number atau ID data
                    $.ajax({
                        url: `/delivery-spk/customer-accept/${id}`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            Swal.fire('Accepted!', response.message, 'success').then(() => {
                                // Tutup modal dan reload tabel
                                $('#deliveryStatusModal').modal('hide');
                                $('#delivery-status-table').DataTable().ajax.reload(null, false);
                            });
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to accept revision.', 'error');
                        },
                    });
                }
            });
        });

     </script>
</body>
</html>
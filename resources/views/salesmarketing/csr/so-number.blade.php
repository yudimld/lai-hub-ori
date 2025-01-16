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
                                <h2 class="text-white pb-2 fw-bold">Sales Order Number</h2>
                                <h5 class="text-white op-7 mb-2">List SO Number dengan status Ready Stock</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-inner mt--5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="fw-bold">List SO Number</h1>
                                    <hr>
                                    <div class="table-responsive">
                                        <table id="dummy-data-table" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Detail</th>
                                                    <th>No.PO</th>
                                                    <th>SO Number</th>
                                                    <th>Tanggal Tiba</th>
                                                    <th>Customer</th>
                                                    <th>Nama Barang Jual</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($data))
                                                    @foreach ($data as $spk)
                                                    <tr>
                                                        <td>
                                                            <!-- Ikon mata untuk tombol detail -->
                                                            <button class="btn btn-link btn-lg" data-bs-toggle="modal" data-bs-target="#soNumberModal"
                                                                data-po="{{ $spk['po_number'] }}"
                                                                data-so="{{ $spk['so_number'] }}"
                                                                data-tanggal="{{ $spk['tanggal_tiba'] }}"
                                                                data-customer="{{ $spk['customer'] }}"
                                                                data-material="{{ $spk['material'] }}"
                                                                data-nama-barang-asli="{{ $spk['nama_barang_asli'] }}"
                                                                data-nama-barang-jual="{{ $spk['nama_barang_jual'] }}"
                                                                data-qty="{{ $spk['qty'] }}"
                                                                data-uom="{{ $spk['uom'] }}"
                                                                data-alamat-kirim="{{ $spk['alamat_kirim'] }}"
                                                                data-kemasan="{{ $spk['kemasan'] }}"
                                                                data-gudang-pengambilan="{{ $spk['gudang_pengambilan'] }}">
                                                                <i class="fa fa-eye"></i> <!-- Ikon Mata -->
                                                            </button>
                                                        </td>
                                                        <td>{{ $spk['po_number'] }}</td>
                                                        <td>{{ $spk['so_number'] }}</td>
                                                        <td>{{ $spk['tanggal_tiba'] }}</td>
                                                        <td>{{ $spk['customer'] }}</td>
                                                        <td>{{ $spk['nama_barang_jual'] }}</td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Modal for Detail -->
                                <div class="modal fade" id="soNumberModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <h5 class="modal-title" id="detailModalLabel" style="flex: 1; text-align: center;">Detail Sales Order</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="deliveryForm" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <!-- Tabel untuk Detail dengan lebih terstruktur -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label><strong>No. PO:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalPoNumber" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><strong>SO Number:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalSoNumber" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label><strong>Tanggal Tiba:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalTanggalTiba" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><strong>Customer:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalCustomer" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label><strong>Material:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalMaterial" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><strong>Nama Barang Asli:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalNamaBarangAsli" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label><strong>Nama Barang Jual:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalNamaBarangJual" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><strong>Qty:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalQty" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label><strong>UoM:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalUoM" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><strong>Alamat Kirim:</strong></label>
                                                            <textarea class="form-control bg-light" id="modalAlamatKirim" readonly rows="5"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label><strong>Kemasan:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalKemasan" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label><strong>Gudang Pengambilan:</strong></label>
                                                            <input type="text" class="form-control bg-light" id="modalGudangPengambilan" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label><strong>Upload File Pendukung(Max: 3MB):</strong></label>
                                                            <input type="file" class="form-control" id="modalFileUpload" name="file" accept=".jpg,.jpeg,.bmp,.png,.xls,.xlsx,.doc,.docx,.pdf,.txt,.ppt,.pptx">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary btn-round" id="requestToDeliveryButton"><i class="fa fa-paper-plane"></i> Request to Delivery</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                                <!-- Modal Detail status Delivery -->
                                <div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <!-- Header Modal -->
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="editFileModalLabel">Edit Delivery Details</h5>
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
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="saveFileChangesButton">Save Changes</button>
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
    
    <!-- Datatables -->
    <script src="{{ asset('atlantis/js/plugin/datatables/datatables.min.js') }}"></script>

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

    <!-- tabel so number -->
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#dummy-data-table').DataTable();

        });
    </script>

    <!-- details button -->
    <script>
        $(document).ready(function() {
            // Ketika tombol detail di klik
            $('#dummy-data-table').on('click', '.btn-link', function() {
                // Ambil data dari tombol
                var poNumber = $(this).data('po');
                var soNumber = $(this).data('so');
                var tanggalTiba = $(this).data('tanggal');
                var customer = $(this).data('customer');
                var material = $(this).data('material');
                var namaBarangAsli = $(this).data('nama-barang-asli');
                var namaBarangJual = $(this).data('nama-barang-jual');
                var qty = $(this).data('qty');
                var uom = $(this).data('uom');
                var alamatKirim = $(this).data('alamat-kirim');
                var kemasan = $(this).data('kemasan');
                var gudangPengambilan = $(this).data('gudang-pengambilan');

                // Masukkan data ke dalam modal
                $('#modalPoNumber').val(poNumber);
                $('#modalSoNumber').val(soNumber);
                $('#modalTanggalTiba').val(tanggalTiba);
                $('#modalCustomer').val(customer);
                $('#modalMaterial').val(material);
                $('#modalNamaBarangAsli').val(namaBarangAsli);
                $('#modalNamaBarangJual').val(namaBarangJual);
                $('#modalQty').val(qty);
                $('#modalUoM').val(uom);
                $('#modalAlamatKirim').val(alamatKirim);
                $('#modalKemasan').val(kemasan);
                $('#modalGudangPengambilan').val(gudangPengambilan);

                // Tampilkan modal
                $('#soNumberModal').modal('show');
            });
        });
    </script>

    <!-- send request delivery button -->
    <script>
        $(document).ready(function() {
            $('#requestToDeliveryButton').on('click', function() {
                // Buat objek FormData
                var formData = new FormData();

                // Ambil data dari modal dan tambahkan ke FormData
                formData.append('_token', '{{ csrf_token() }}'); // CSRF token
                formData.append('po_number', $('#modalPoNumber').val());
                formData.append('so_number', $('#modalSoNumber').val());
                formData.append('tanggal_tiba', $('#modalTanggalTiba').val());
                formData.append('customer', $('#modalCustomer').val());
                formData.append('material', $('#modalMaterial').val());
                formData.append('nama_barang_asli', $('#modalNamaBarangAsli').val());
                formData.append('nama_barang_jual', $('#modalNamaBarangJual').val());
                formData.append('qty', $('#modalQty').val());
                formData.append('uom', $('#modalUoM').val());
                formData.append('alamat_kirim', $('#modalAlamatKirim').val());
                formData.append('kemasan', $('#modalKemasan').val());
                formData.append('gudang_pengambilan', $('#modalGudangPengambilan').val());

                // Ambil file dari input file dan tambahkan ke FormData
                var fileInput = $('#modalFileUpload')[0].files[0];
                if (fileInput) {
                    formData.append('file', fileInput);
                }

                // Tampilkan konfirmasi SweetAlert sebelum mengirim data
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin mengirim data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, kirim!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim data ke backend menggunakan AJAX
                        $.ajax({
                            url: '/salesmarketing/csr/request-to-delivery', // Gantilah dengan URL yang sesuai
                            method: 'POST',
                            data: formData,
                            processData: false, // Jangan memproses data (karena menggunakan FormData)
                            contentType: false, // Jangan menetapkan header Content-Type secara otomatis
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Data berhasil disimpan untuk Delivery!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Menutup modal
                                    $('#soNumberModal').modal('hide');

                                    // Reset semua input dalam modal
                                    $('#deliveryForm')[0].reset();

                                    // Reload tabel status delivery
                                    $('#delivery-status-table').DataTable().ajax.reload(null, false);
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Terjadi kesalahan:', xhr.responseText); // Debugging error
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menyimpan data: ' + error,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    <!-- tabel status delivery -->
    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable
            $('#delivery-status-table').DataTable({
                "processing": true,
                "ajax": {
                    "url": "/salesmarketing/csr/delivery/status", 
                    "type": "GET",
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
                                <button class="btn btn-link btn-lg" 
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
                                    data-updated-at="${row.updated_at || ''}"
                                    data-created-at="${row.created_at || ''}"
                                    data-file-name="${row.file_name || ''}"
                                    data-file-path="${row.file_path || ''}">
                                    <i class="fa fa-eye"></i>
                                </button>`;
                        }
                    },
                    {
                        data: 'status',
                        render: function (data) {
                            if (!data) return '<span class="badge badge-info">Unknown</span>';
                            if (data.toLowerCase() === 'open') return '<span class="badge badge-danger">Open</span>'; // Merah
                            if (data.toLowerCase() === 'delivery') return '<span class="badge badge-info">Delivery</span>'; // Biru
                            if (data.toLowerCase() === 'close') return '<span class="badge badge-success">Close</span>'; // Hijau
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
                            if (row.file_path) {
                                return `
                                    <a href="${row.file_path}" target="_blank" class="text-primary">
                                        <i class="fa fa-download"></i> ${row.file_name || 'Download File'}
                                    </a>`;
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
                                            data-file-path="${row.file_path || ''}" 
                                            data-file-name="${row.file_name || ''}" 
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

            // Event show.bs.modal untuk mengisi data ke modal
            $('#deliveryStatusModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);

                // Isi data ke modal
                $('#modalStatusPoNumber').val(button.data('po-number'));
                $('#modalStatusSoNumber').val(button.data('so-number'));
                $('#modalStatusTanggalTiba').val(button.data('tanggal-tiba'));
                $('#modalStatusCustomer').val(button.data('customer'));
                $('#modalStatusMaterial').val(button.data('material'));
                $('#modalStatusNamaBarangAsli').val(button.data('nama-barang-asli'));
                $('#modalStatusNamaBarangJual').val(button.data('nama-barang-jual'));
                $('#modalStatusQty').val(button.data('qty'));
                $('#modalStatusUoM').val(button.data('uom'));
                $('#modalStatusAlamatKirim').val(button.data('alamat-kirim'));
                $('#modalStatusKemasan').val(button.data('kemasan'));
                $('#modalStatusGudangPengambilan').val(button.data('gudang-pengambilan'));
                $('#modalStatusUpdatedAt').val(button.data('updated-at'));
                $('#modalStatusCreatedAt').val(button.data('created-at'));

                // Tampilkan file jika ada
                var filePath = button.data('file-path');
                var fileName = button.data('file-name');

                if (filePath) {
                    $('#modalStatusFileLink')
                        .attr('href', filePath)
                        .text(fileName || 'Download File')
                        .removeClass('text-muted')
                        .addClass('text-primary');
                } else {
                    $('#modalStatusFileLink')
                        .attr('href', '#')
                        .text('No file uploaded')
                        .removeClass('text-primary')
                        .addClass('text-muted');
                }
            });

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
                const status = $(this).data('status');
                const filePath = $(this).data('file-path');
                const fileName = $(this).data('file-name');
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

                if (filePath) {
                    $('#editFileLink')
                        .attr('href', filePath)
                        .text(fileName || 'Download File')
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
        });
    </script>




</body>
</html>

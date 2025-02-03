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

</body>
</html>
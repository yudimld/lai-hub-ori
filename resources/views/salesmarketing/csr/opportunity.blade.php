<!DOCTYPE html>
<html lang="en">
@php
    $title = 'List of Opportunity';
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
								<h2 class="text-white pb-2 fw-bold">Opportunity List</h2>
								<h5 class="text-white op-7 mb-2">List Quotes dengan status Approved</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                <h1 class="fw-bold">List Opportunity Approved</h1>
                                <hr>
                                    <div class="table-responsive">
                                    <div class="d-flex justify-content-end align-items-center gap-2 mb-3">
                                            <!-- Filter Start Date -->
                                            <div class="me-2">
                                                <label for="filterStartDate" class="form-label">Start Date</label>
                                                <input type="date" id="filterStartDate" class="form-control" />
                                            </div>

                                            <!-- Separator (-) -->
                                            <div class="me-2" style="font-weight: bold; margin-top: 2%; margin-left: 1%; margin-right: 1%;"> - </div>

                                            <!-- Filter End Date -->
                                            <div class="me-2">
                                                <label for="filterEndDate" class="form-label">End Date</label>
                                                <input type="date" id="filterEndDate" class="form-control" />
                                            </div>

                                            <!-- Clear Filter Button -->
                                            <div style="margin-left: 1%;">
                                                <label class="form-label d-block" style="visibility: hidden;">Clear</label>
                                                <button id="clearFilter" class="btn btn-default btn-round">Clear Filter</button>
                                            </div>
                                        </div>
                                        <table id="dummy-data-table" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No. PO</th>
                                                    <th>Incoterm</th>
                                                    <th>Customer</th>
                                                    <th>Nama Barang Jual</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <h5 class="modal-title" id="detailModalLabel" style="flex: 1; text-align: center;" >Detail Opportunity</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Tabel untuk Detail dengan lebih terstruktur -->
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
                                                        <label><strong>Qty:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalQty" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><strong>UoM:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalUom" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label><strong>Alamat Kirim:</strong></label>
                                                        <textarea class="form-control bg-light" id="modalAlamatKirim" readonly rows="5"></textarea>
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
                                                        <label><strong>Tanggal Kirim:</strong></label>
                                                        <input type="text" class="form-control bg-light" id="modalTanggalTiba" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="modalProducts"><strong>Products:</strong></label>
                                                        <select class="form-control" id="modalProducts" multiple>
                                                            <!-- Options akan diisi melalui JavaScript -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary btn-round" id="requestToPpicButton"><i class="fa fa-paper-plane"></i> Request to PPIC</button>
                                                <button type="button" class="btn btn-warning btn-round" id="saveToDraftButton"><i class="fa fa-save"></i> Save to Draft</button>
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


    <!-- menampilkan data dummy api -->
    <script>
        $(document).ready(function () {
            var dummyTable = $('#dummy-data-table').DataTable({
                ajax: {
                    url: '/api/dummy-data',
                    dataSrc: '',
                },
                columns: [
                    { data: 'no_po' },
                    { data: 'incoterm' },
                    { data: 'customer' },
                    { data: 'nama_barang_jual' },
                    {
                        data: null,
                        defaultContent:
                            '<button class="btn btn-link btn-info btn-lg" data-toggle="modal" data-target="#detailModal"><i class="fa fa-eye"></i></button>',
                        orderable: false,
                    },
                ],
                responsive: true,
                pageLength: 5,
                order: [[0, 'desc']],
            });

            $('#modalProducts').select2({
                placeholder: 'Select one or more products',
                allowClear: true,
                width: '100%',
                closeOnSelect: false,
            });

            $('#dummy-data-table').on('click', 'button', function () {
                var rowData = dummyTable.row($(this).parents('tr')).data();

                // Reset modal
                $('#modalNoPo').val('');
                $('#modalIncoterm').val('');
                $('#modalCustomer').val('');
                $('#modalMaterial').val('');
                $('#modalNamaBarangAsli').val('');
                $('#modalNamaBarangJual').val('');
                $('#modalQty').val('');
                $('#modalUom').val('');
                $('#modalAlamatKirim').val('');
                $('#modalKemasan').val('');
                $('#modalGudangPengambilan').val('');
                $('#modalTanggalTiba').val('');
                $('#modalProducts').empty().trigger('change');

                // Isi data ke modal
                $('#modalNoPo').val(rowData.no_po);
                $('#modalIncoterm').val(rowData.incoterm);
                $('#modalCustomer').val(rowData.customer);
                $('#modalMaterial').val(rowData.material);
                $('#modalNamaBarangAsli').val(rowData.nama_barang_asli);
                $('#modalNamaBarangJual').val(rowData.nama_barang_jual);
                $('#modalQty').val(rowData.qty);
                $('#modalUom').val(rowData.uom);
                $('#modalAlamatKirim').val(rowData.alamat_kirim);
                $('#modalKemasan').val(rowData.kemasan);
                $('#modalGudangPengambilan').val(rowData.gudang_pengambilan);
                $('#modalTanggalTiba').val(rowData.tanggal_tiba);

                // Tambahkan opsi produk
                var products = [];
                if (rowData.product_1) products.push(rowData.product_1);
                if (rowData.product_2) products.push(rowData.product_2);
                if (rowData.product_3) products.push(rowData.product_3);
                if (rowData.product_4) products.push(rowData.product_4);
                if (rowData.product_5) products.push(rowData.product_5);

                products.forEach(function (product) {
                    $('#modalProducts').append(`<option value="${product}">${product}</option>`);
                });

                $('#modalProducts').trigger('change');
            });
        });

    </script>

    <!-- button request to ppic -->
    <script>
        $('#requestToPpicButton').on('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to send this request to PPIC?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, send it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ambil data dari modal
                    let selectedProducts = $('#modalProducts').val();
                    selectedProducts = [...new Set(selectedProducts)]; // Hapus duplikasi produk

                    const data = {
                        no_po: document.getElementById('modalNoPo').value,
                        incoterm: document.getElementById('modalIncoterm').value,
                        customer: document.getElementById('modalCustomer').value,
                        material: document.getElementById('modalMaterial').value,
                        nama_barang_asli: document.getElementById('modalNamaBarangAsli').value,
                        nama_barang_jual: document.getElementById('modalNamaBarangJual').value,
                        qty: document.getElementById('modalQty').value,
                        uom: document.getElementById('modalUom').value,
                        alamat_kirim: document.getElementById('modalAlamatKirim').value,
                        kemasan: document.getElementById('modalKemasan').value,
                        gudang_pengambilan: document.getElementById('modalGudangPengambilan').value,
                        tanggal_tiba: document.getElementById('modalTanggalTiba').value,
                        products: selectedProducts,
                    };

                    // Kirim data ke server
                    fetch('/salesmarketing/csr/request-to-ppic', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(data),
                    })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error('Failed to save data');
                            }
                            return response.json();
                        })
                        .then((responseData) => {
                            Swal.fire({
                                title: 'Success!',
                                text: responseData.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then(() => {
                                // Tutup modal
                                $('#detailModal').modal('hide');

                                // Reload DataTable
                                statusTable.ajax.reload(null, false); // Reload tanpa reset halaman
                            });
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to save data. Please try again later.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        });
                }
            });
        });

    </script>

    <!-- save to draft -->
    <script>
        $('#saveToDraftButton').on('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to save this data to draft?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    const data = {
                        no_po: $('#modalNoPo').val(),
                        incoterm: $('#modalIncoterm').val(),
                        customer: $('#modalCustomer').val(),
                        material: $('#modalMaterial').val(),
                        nama_barang_asli: $('#modalNamaBarangAsli').val(),
                        nama_barang_jual: $('#modalNamaBarangJual').val(),
                        qty: $('#modalQty').val(),
                        uom: $('#modalUom').val(),
                        alamat_kirim: $('#modalAlamatKirim').val(),
                        kemasan: $('#modalKemasan').val(),
                        gudang_pengambilan: $('#modalGudangPengambilan').val(),
                        tanggal_tiba: $('#modalTanggalTiba').val(),
                        products: $('#modalProducts').val(),
                    };

                    console.log('Mengirim data:', data);

                    fetch('/salesmarketing/csr/save-to-draft', {
                        
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(data),
                    })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error('Failed to save data to draft');
                            }
                            return response.json();
                        })
                        .then((responseData) => {
                            console.log('Respons dari server:', responseData);
                            Swal.fire({
                                title: 'Success!',
                                text: responseData.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then(() => {
                                $('#detailModal').modal('hide');
                                // Refresh tabel setelah data disimpan
                                $('#status-request-table').DataTable().ajax.reload(null, false);
                            });
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to save data to draft. Please try again later.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        });
                }
            });
        });
    </script>





</body>
</html>
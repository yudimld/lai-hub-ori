<!DOCTYPE html>
<html lang="en">
@php
    $title = 'Approval Reject';
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
								<h2 class="text-white pb-2 fw-bold">Rejected Request</h2>
								<h5 class="text-white op-7 mb-2">Data Project yang Sudah di Reject</h5>
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

                                        <table id="approval-reject-table" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>No. SPK</th>
                                                    <th>Request Date</th>
                                                    <th>Subject</th>
                                                    <th>Deskripsi</th>
                                                    <th>Attachments</th>
                                                    <th>Reason</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($spkList as $item)
                                                    <tr>
                                                        <td>
                                                            <span class="badge badge-danger">{{ $item->status ?? '-' }}</span>
                                                        </td>
                                                        <td>{{ $item->spkNumber ?? '-' }}</td>
                                                        <td>{{ $item->requestDate ?? '-' }}</td>
                                                        <td>{{ $item->subject ?? '-' }}</td>
                                                        <td>{{ $item->deskripsi ?? '-' }}</td>
                                                        <td>
                                                            @if (!empty($item->attachments))
                                                            <ul style="list-style-type: none; padding: 0; margin: 0;">
                                                                @foreach ($item->attachments as $attachment)
                                                                <li>
                                                                    <a href="{{ asset('storage/' . $attachment['path']) }}" target="_blank">
                                                                        {{ $attachment['originalName'] ?? 'Attachment' }}
                                                                    </a>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->reason ?? 'No reason provided' }}</td>
                                                        <td>
                                                            <button 
                                                                class="btn btn-danger btn-sm btn-round reject-button" 
                                                                data-id="{{ $item->id }}" 
                                                                data-status="{{ $item->status }}">
                                                                <i class="fa fa-times"></i> Reject
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No data available for Request to Close</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
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

	<!-- Datatables -->
	<script src="{{ asset('atlantis/js/plugin/datatables/datatables.min.js') }}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('atlantis/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('atlantis/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('atlantis/js/atlantis.min.js') }}"></script>

    <!-- filter date to date  -->
    <script>
        $(document).ready(function () {
            // Inisialisasi DataTables
            var table = $('#approval-reject-table').DataTable({
                scrollX: true, // Mendukung scroll horizontal
                pageLength: 10, // Jumlah baris per halaman
                order: [[3, 'desc']], // Urutkan berdasarkan kolom Request Date (index ke-3) secara terbaru
                language: {
                    lengthMenu: "Tampilkan _MENU_ baris per halaman",
                    search: "Cari:",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                    emptyTable: "Tidak ada data tersedia",
                    zeroRecords: "Tidak ditemukan data yang sesuai"
                }
            });

            // Custom filter untuk tanggal
            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var minDate = $('#filterStartDate').val(); // Tanggal awal dari input
                var maxDate = $('#filterEndDate').val();   // Tanggal akhir dari input
                var requestDate = data[3];                // Data kolom Request Date (index ke-3)

                // Jika tidak ada filter, tampilkan semua data
                if (!minDate && !maxDate) {
                    return true;
                }

                // Logika filter: Cocokkan tanggal tabel dengan filter
                if (minDate && requestDate < minDate) {
                    return false; // Data sebelum Start Date
                }
                if (maxDate && requestDate > maxDate) {
                    return false; // Data setelah End Date
                }

                return true; // Data sesuai filter
            });

            // Event listener untuk input tanggal
            $('#filterStartDate, #filterEndDate').on('change', function () {
                table.draw(); // Refresh tabel
            });

            // Tombol Clear Filter
            $('#clearFilter').on('click', function () {
                $('#filterStartDate').val(''); // Kosongkan Start Date
                $('#filterEndDate').val('');   // Kosongkan End Date
                table.draw(); // Refresh tabel
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            // Event listener untuk tombol Reject
            $(document).on('click', '.reject-button', function () {
                const spkId = $(this).data('id'); // Ambil ID SPK

                if (!spkId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Data ID is missing!',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Tampilkan SweetAlert untuk konfirmasi
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to change the status to Rejected.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Reject it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan indikator loading
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Rejecting SPK, please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });

                        // Kirim permintaan AJAX
                        $.ajax({
                            url: `/edc/spk/reject-to-rejected/${spkId}`, // Endpoint untuk mengubah status
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
                            },
                            success: function (response) {
                                Swal.close(); // Tutup indikator loading

                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message
                                    });

                                    // Perbarui status di tabel
                                    $(`#spkStatus-${spkId}`).text('Rejected').removeClass('badge-danger').addClass('badge-secondary');

                                    // Refresh tabel atau hapus baris
                                    $(`button[data-id="${spkId}"]`).closest('tr').remove();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed',
                                        text: response.message
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.close(); // Tutup indikator loading
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error occurred while updating status!'
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
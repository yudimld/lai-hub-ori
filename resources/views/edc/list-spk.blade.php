<!DOCTYPE html>
<html lang="en">
@php
    $title = 'List of SPK';
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
								<h2 class="text-white pb-2 fw-bold">List SPK EDC</h2>
								<h5 class="text-white op-7 mb-2">List data antrian project EDC</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive" style="overflow-x: auto;">
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
                                                    <th>Detail</th>
                                                    <th>Status</th>
                                                    <th>SPK Number</th>
                                                    <th>Request Date</th>
                                                    <th>Subject</th>
                                                    <th>Created By</th>
                                                    <th>Assignee</th>
                                                    <th>Priority</th>
                                                    <th>Category</th>
                                                    <th>Start Date</th>
                                                    <th>Deadline Date</th>
                                                    <th>Jenis Biaya</th>
                                                    <th>Jenis SPK</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($spkList))
                                                    @foreach ($spkList as $spk)
                                                        <tr>
                                                            <td>
                                                                <button 
                                                                    class="btn btn-primary btn-round show-details-button btn-link btn-lg"
                                                                    data-id="{{ $spk['id'] }}"
                                                                    data-status="{{ $spk['status'] }}"
                                                                    data-spk-number="{{ $spk['spkNumber'] }}"
                                                                    data-request-date="{{ $spk['requestDate'] }}"
                                                                    data-subject="{{ $spk['subject'] }}"
                                                                    data-created-by="{{ $spk['createdBy'] }}"
                                                                    data-description="{{ $spk['description'] }}"
                                                                    data-attachments="{{ json_encode($spk['attachments'] ?? []) }}"
                                                                    data-assignee="{{ $spk['assignee'] ?? '-' }}"
                                                                    data-priority="{{ $spk['priority'] ?? '-' }}"
                                                                    data-category="{{ $spk['category'] ?? '-' }}"
                                                                    data-start-date="{{ $spk['start_date'] ?? '-' }}"
                                                                    data-deadline-date="{{ $spk['deadline_date'] ?? '-' }}"
                                                                    data-jenis-biaya="{{ $spk['jenis_biaya'] ?? '-' }}"
                                                                    data-jenis-spk="{{ $spk['jenis_spk'] ?? '-' }}"
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#spkDetailsModal">
                                                                    <i class="fa fa-eye"></i>
                                                                    
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <span id="spkStatus-{{ $spk['id'] }}" 
                                                                    class="badge 
                                                                        {{ $spk['status'] === 'Assigned' ? 'badge-warning' : 
                                                                        ($spk['status'] === 'Request to Close' ? 'badge-primary' : 
                                                                        ($spk['status'] === 'Closed' ? 'badge-success' : 'badge-danger')) }}">
                                                                    {{ $spk['status'] }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $spk['spkNumber'] }}</td>
                                                            <td>{{ $spk['requestDate'] }}</td>
                                                            <td>{{ $spk['subject'] }}</td>
                                                            <td>{{ $spk['createdBy'] }}</td>
                                                            <td>{{ $spk['assignee'] }}</td>
                                                            <td>{{ $spk['priority'] }}</td>
                                                            <td>{{ $spk['category'] }}</td>
                                                            <td>{{ $spk['start_date'] }}</td>
                                                            <td>{{ $spk['deadline_date'] }}</td>
                                                            <td>{{ $spk['jenis_biaya'] }}</td>
                                                            <td>{{ $spk['jenis_spk'] }}</td>
                                                            <td>
                                                                @if (trim($spk['createdBy']) === trim(auth()->user()->id_card) && strtolower(trim($spk['status'])) === 'open')
                                                                <!-- Tombol Edit -->
                                                                <button 
                                                                    class="btn btn-link btn-primary btn-lg" 
                                                                    data-id="{{ $spk['id'] }}"
                                                                    data-status="{{ $spk['status'] }}"
                                                                    data-spk-number="{{ $spk['spkNumber'] }}"
                                                                    data-request-date="{{ $spk['requestDate'] }}"
                                                                    data-subject="{{ $spk['subject'] }}"
                                                                    data-created-by="{{ $spk['createdBy'] }}"
                                                                    data-description="{{ $spk['description'] }}"
                                                                    data-attachments="{{ json_encode($spk['attachments'] ?? []) }}"
                                                                    data-assignee="{{ $spk['assignee'] ?? '-' }}"
                                                                    data-priority="{{ $spk['priority'] ?? '-' }}"
                                                                    data-category="{{ $spk['category'] ?? '-' }}"
                                                                    data-start-date="{{ $spk['start_date'] ?? '-' }}"
                                                                    data-deadline-date="{{ $spk['deadline_date'] ?? '-' }}"
                                                                    data-jenis-biaya="{{ $spk['jenis_biaya'] ?? '-' }}"
                                                                    data-jenis-spk="{{ $spk['jenis_spk'] ?? '-' }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editSpkModal"
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Edit Task">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>

                                                                <!-- Tombol Delete -->
                                                                <!-- Tombol Delete -->
                                                                <button 
                                                                    class="btn btn-link btn-danger delete-button" 
                                                                    data-toggle="tooltip"
                                                                    data-original-title="Delete"
                                                                    data-id="{{ $spk['id'] }}">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="10" class="text-center">No data available</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <!-- modal detail data -->
                                        <div class="modal fade" id="spkDetailsModal" tabindex="-1" aria-labelledby="spkDetailsModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                        <h5 class="modal-title fw-bold" id="spkDetailsModalLabel" style="flex: 1; text-align: center;">SPK Details</h5>
                                                    </div>
                                                    <!-- Modal Body -->
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <!-- SPK Information -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-6 d-flex align-items-center">
                                                                    <strong style="width: 40%;">SPK Number</strong>
                                                                    <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="modalSpkNumber">-</p>
                                                                </div>
                                                                <div class="col-md-6 d-flex align-items-center">
                                                                    <strong style="width: 40%;">Assignee</strong>
                                                                    <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="modalAssignee">-</p>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-6 d-flex align-items-center">
                                                                    <strong style="width: 40%;">Request Date</strong>
                                                                    <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="modalRequestDate">-</p>
                                                                </div>
                                                                <div class="col-md-6 d-flex align-items-center">
                                                                    <strong style="width: 40%;">Priority</strong>
                                                                    <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="modalPriority">-</p>
                                                                </div>
                                                            </div>
                                                            <!-- Subject -->
    
                                                            <div class="row mb-3">
                                                                <div class="col-md-6 d-flex align-items-center">
                                                                    <strong style="width: 40%;">Subject</strong>
                                                                    <textarea style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; flex: 1; border: none;" rows="3" readonly id="modalSubject"></textarea>
                                                                </div>
                                                                <div class="col-md-6 d-flex align-items-center">
                                                                    <strong style="width: 40%;">Category</strong>
                                                                    <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="modalCategory">-</p>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-6 d-flex align-items-center">
                                                                    <strong style="width: 40%;">Start Date</strong>
                                                                    <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="modalStartDate">-</p>
                                                                </div>
                                                                <div class="col-md-6 d-flex align-items-center">
                                                                    <strong style="width: 40%;">Deadline Date</strong>
                                                                    <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="modalDeadlineDate">-</p>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-6 d-flex align-items-center">
                                                                    <strong style="width: 40%;">Jenis Biaya</strong>
                                                                    <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="modalJenisBiaya">-</p>
                                                                </div>
                                                                <div class="col-md-6 d-flex align-items-center">
                                                                    <strong style="width: 40%;">Jenis SPK</strong>
                                                                    <p style="background-color: #f8f9fa; padding: 5px; border-radius: 5px; margin: 0; flex: 1;" id="modalJenisSpk">-</p>
                                                                </div>
                                                            </div>

                                                            <!-- Description -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-12">
                                                                    <strong>Description</strong>
                                                                    <textarea id="modalDescription" class="form-control mt-2" rows="3" readonly style="background-color: #f8f9fa; border-radius: 5px;"></textarea>
                                                                </div>
                                                            </div>

                                                            <!-- Attachments -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-12">
                                                                    <strong>Attachments</strong>
                                                                    <ul id="modalAttachmentsList" class="list-unstyled mt-2" style="background-color: #f8f9fa; padding: 5px; border-radius: 5px;"></ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
                                                        <button id="closeButton" 
                                                                class="btn btn-primary btn-success btn-round" 
                                                                type="submit"
                                                                data-id="" 
                                                                data-created-by="" 
                                                                disabled>
                                                            <i class="fa fa-check-circle"></i> Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- modal edit -->
                                        <div class="modal fade" id="editSpkModal" tabindex="-1" aria-labelledby="editSpkModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                        <h5 class="modal-title fw-bold" id="editSpkModalLabel" style="flex: 1; text-align: center;">Edit SPK Details</h5>
                                                    </div>
                                                    <!-- Modal Body -->
                                                    <div class="modal-body">
                                                        <form id="editSpkForm">
                                                            <!-- Hidden Field for SPK ID -->
                                                            <input type="hidden" id="modalSpkId" name="id">

                                                            <!-- SPK Number -->
                                                            <div class="mb-3">
                                                                <label for="modalSpkNumber" class="form-label">SPK Number</label>
                                                                <input type="text" id="modalSpkNumber" name="spkNumber" class="form-control" readonly>
                                                            </div>

                                                            <!-- Request Date -->
                                                            <div class="mb-3">
                                                                <label for="modalRequestDate" class="form-label">Request Date</label>
                                                                <input type="date" id="modalRequestDate" name="requestDate" class="form-control" readonly>
                                                            </div>
                                                            <!-- Subject -->
                                                            <div class="mb-3">
                                                                <label for="modalSubject" class="form-label">Subject</label>
                                                                <textarea id="modalSubject" name="subject" class="form-control" rows="3"></textarea>
                                                            </div>

                                                            <!-- Deskripsi Pekerjaan -->
                                                            <div class="mb-3">
                                                                <label for="modalDescription" class="form-label">Deskripsi Pekerjaan</label>
                                                                <textarea id="modalDescription" name="description" class="form-control" rows="3"></textarea>
                                                            </div>

                                                            <!-- Attachments -->
                                                            <div class="mb-3">
                                                                <label for="modalAttachmentsInput" class="form-label">Attachments</label>
                                                                
                                                                <!-- Daftar Attachments yang Sudah Ada -->
                                                                <div id="existingAttachmentsList" class="mb-2">
                                                                    <!-- Akan diisi oleh JavaScript -->
                                                                </div>

                                                                <!-- Input untuk Menambahkan Attachments Baru -->
                                                                <input type="file" id="modalAttachmentsInput" name="attachments[]" class="form-control" multiple>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <!-- Modal Footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
                                                        <button id="saveChangesButton" class="btn btn-primary btn-round">Save Changes</button>
                                                    </div>
                                                </div>
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

    <!-- Custom Script -->
    <script>
        $(document).ready(function () {
            // Inisialisasi DataTables
            var table = $('#dummy-data-table').DataTable({
                scrollX: true,
                pageLength: 10,
                order: [[1, 'desc']],
                language: {
                    emptyTable: "No data available in table",
                    zeroRecords: "No matching records found"
                }
            });

            // Fungsi untuk refresh tabel tanpa AJAX
            function refreshTableWithoutAjax() {
                table.destroy(); // Hancurkan tabel
                $('#dummy-data-table').DataTable({
                    scrollX: true,
                    pageLength: 10,
                    order: [[3, 'desc']],
                    language: {
                        emptyTable: "No data available in table",
                        zeroRecords: "No matching records found"
                    }
                });
            }

            // Event saat tombol show details ditekan
            $(document).on('click', '.show-details-button', function () {
                const spkId = $(this).data('id');
                const status = $(this).data('status') || '-';
                const createdBy = $(this).data('created-by'); // Ambil data createdBy dari atribut tombol
                const currentUser = "{{ Auth::user()->name }}"; // Ambil nama pengguna saat ini dari backend

                // Isi modal dengan data
                $('#modalSpkNumber').text($(this).data('spk-number') || '-');
                $('#modalRequestDate').text($(this).data('request-date') || '-');
                $('#modalSubject').text($(this).data('subject') || '-');
                $('#modalCreatedBy').text($(this).data('created-by') || '-');
                $('#modalAssignee').text($(this).data('assignee') || '-');
                $('#modalPriority').text($(this).data('priority') || '-');
                $('#modalCategory').text($(this).data('category') || '-');
                $('#modalStartDate').text($(this).data('start-date') || '-');
                $('#modalDeadlineDate').text($(this).data('deadline-date') || '-');
                $('#modalDescription').val($(this).data('description') || 'No Description Available');
                $('#modalJenisBiaya').text($(this).data('jenis-biaya') || '-');
                $('#modalJenisSpk').text($(this).data('jenis-spk') || '-');

                // Tambahkan ID SPK ke tombol "Close"
                $('#closeButton').data('id', spkId);

                // Validasi status untuk mengaktifkan atau menonaktifkan tombol
                if (status === 'Request to Close'&& createdBy === currentUser) {
                    $('#closeButton').prop('disabled', false); // Aktifkan tombol
                } else {
                    $('#closeButton').prop('disabled', true); // Nonaktifkan tombol
                }
            });

            // Event saat tombol Close ditekan
            $(document).on('click', '#closeButton', function () {
                const spkId = $(this).data('id'); // Ambil ID SPK dari data-id
                const createdBy = $('#modalCreatedBy').text(); // Ambil data createdBy dari modal
                const currentUser = "{{ Auth::user()->name }}"; // Ambil nama pengguna saat ini

                if (createdBy !== currentUser) {
                    swal({
                        icon: 'error',
                        title: 'Unauthorized',
                        text: 'You are not authorized to close this SPK.',
                        buttons: {
                            confirm: {
                                text: 'OK',
                                className: 'btn btn-danger'
                            }
                        }
                    });
                    return;
                }
                
                if (!spkId) {
                    swal({
                        icon: 'error',
                        title: 'Error',
                        text: 'SPK ID is missing!',
                        buttons: {
                            confirm: {
                                text: 'OK',
                                className: 'btn btn-danger'
                            }
                        }
                    });
                    return;
                }

                // Tampilkan konfirmasi dengan SweetAlert
                swal({
                    title: 'Are you sure?',
                    text: 'You are about to close this SPK!',
                    icon: 'warning',
                    buttons: {
                        cancel: {
                            text: 'Cancel',
                            visible: true,
                            className: 'btn btn-default'
                        },
                        confirm: {
                            text: 'Yes, proceed!',
                            className: 'btn btn-success'
                        }
                    }
                }).then((willClose) => {
                    if (willClose) {
                        // Lakukan permintaan AJAX
                        $.ajax({
                            url: '/edc/api/spk/close/' + spkId, // Endpoint untuk menutup SPK
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                console.log('Server response:', response); // Debugging
                                if (response.success) {
                                    swal({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message,
                                        buttons: {
                                            confirm: {
                                                text: 'OK',
                                                className: 'btn btn-success'
                                            }
                                        }
                                    });

                                    // Perbarui status di tabel
                                    $('#spkStatus-' + spkId).text('Closed').removeClass().addClass('badge badge-success');

                                    // Tutup modal
                                    $('#spkDetailsModal').modal('hide');
                                } else {
                                    swal({
                                        icon: 'error',
                                        title: 'Failed',
                                        text: response.message,
                                        buttons: {
                                            confirm: {
                                                text: 'OK',
                                                className: 'btn btn-danger'
                                            }
                                        }
                                    });
                                }
                            },
                            error: function (xhr) {
                                console.error('AJAX Error:', xhr.responseText); // Debugging
                                swal({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to close SPK. Please try again later.',
                                    buttons: {
                                        confirm: {
                                            text: 'OK',
                                            className: 'btn btn-danger'
                                        }
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    <!-- js detail modal -->
    <script>
        $(document).on('click', '.show-details-button', function () {
            // Ambil data dari atribut tombol
            const spkId = $(this).data('id');
            const spkNumber = $(this).data('spk-number') || '-';
            const requestDate = $(this).data('request-date') || '-';
            const subject = $(this).data('subject') || '-';
            const createdBy = $(this).data('created-by') || '-';
            const assignee = $(this).data('assignee') || '-';
            const priority = $(this).data('priority') || '-';
            const category = $(this).data('category') || '-';
            const startDate = $(this).data('start-date') || '-';
            const deadlineDate = $(this).data('deadline-date') || '-';
            const description = $(this).data('description') || 'No Description Available';
            const jenisBiaya = $(this).data('jenis-biaya') || '-';
            const jenisSpk = $(this).data('jenis-spk') || '-';
            const status = $(this).data('status') || '-';

            // Debugging dan parsing attachments
            let attachments = [];
            try {
                const rawAttachments = $(this).data('attachments');
                console.log("Raw attachments:", rawAttachments);

                // Jika rawAttachments adalah string JSON
                if (typeof rawAttachments === 'string') {
                    attachments = JSON.parse(rawAttachments);
                } else if (Array.isArray(rawAttachments)) {
                    // Jika rawAttachments sudah berupa array
                    attachments = rawAttachments;
                }
                console.log("Parsed attachments:", attachments);
            } catch (e) {
                console.error("Failed to parse attachments:", e);
            }

            // Isi modal dengan data yang diambil
            $('#modalSpkNumber').text(spkNumber);
            $('#modalRequestDate').text(requestDate);
            $('#modalSubject').text(subject);
            $('#modalCreatedBy').text(createdBy);
            $('#modalAssignee').text(assignee);
            $('#modalPriority').text(priority);
            $('#modalCategory').text(category);
            $('#modalStartDate').text(startDate);
            $('#modalDeadlineDate').text(deadlineDate);
            $('#modalDescription').val(description);
            $('#modalJenisBiaya').text(jenisBiaya);
            $('#modalJenisSpk').text(jenisSpk);

            // Tampilkan daftar attachments
            let attachmentsHtml = '';
            if (attachments.length > 0) {
                attachments.forEach(attachment => {
                    if (attachment.path && attachment.originalName) {
                        attachmentsHtml += `<li><a href="/storage/${attachment.path}" target="_blank">${attachment.originalName}</a></li>`;
                    }
                });
            } else {
                attachmentsHtml = '<li>No Attachments</li>';
            }
            $('#modalAttachmentsList').html(attachmentsHtml);

            // Tambahkan ID SPK ke tombol "Request to Close"
            $('#requestToCloseButton').data('id', spkId);

            // Periksa status untuk menonaktifkan tombol
            if (status === 'Request to Close') {
                $('#requestToCloseButton').prop('disabled', true); // Nonaktifkan tombol
            } else {
                $('#requestToCloseButton').prop('disabled', false); // Aktifkan tombol
            }
        });
    </script>

    <!-- close -->
    <script>
        $(document).ready(function () {
            // Event saat tombol show details ditekan
            $(document).on('click', '.show-details-button', function () {
                const spkId = $(this).data('id');
                const createdBy = $(this).data('created-by');
                const status = $(this).data('status');
                const currentUserIdCard = "{{ Auth::user()->id_card }}";

                // Logika untuk menentukan apakah user authorized dan status sesuai
                const isAuthorized = createdBy.trim() === currentUserIdCard.trim() && status === "Request to Close";

                const closeButton = $('#closeButton');
                closeButton
                    .data('id', spkId)
                    .data('created-by', createdBy);

                if (status === "Closed") {
                    closeButton
                        .attr('disabled', 'disabled')
                        .css({
                            opacity: 0.65,
                            pointerEvents: 'none'
                        });
                } else if (isAuthorized) {
                    closeButton
                        .removeAttr('disabled')
                        .css({
                            opacity: 1,
                            pointerEvents: 'auto'
                        });
                } else {
                    closeButton
                        .attr('disabled', 'disabled')
                        .css({
                            opacity: 0.65,
                            pointerEvents: 'none'
                        });
                }
            });

            // Reset tombol Close saat modal ditutup
            $('#spkDetailsModal').on('hidden.bs.modal', function () {
                const status = $('#spkStatus-' + $('#closeButton').data('id')).text();

                if (status !== "Closed") {
                    $('#closeButton')
                        .data('id', '') // Reset ID SPK
                        .data('created-by', '') // Reset Created By
                        .attr('disabled', 'disabled') // Nonaktifkan tombol secara default
                        .css({
                            opacity: 0.65,
                            pointerEvents: 'none' // Nonaktifkan interaksi
                        });
                }
            });

            // Event untuk menangani klik pada tombol Close
            $(document).on('click', '#closeButton', function () {
                const spkId = $(this).data('id'); // Ambil ID SPK dari atribut tombol

                if (!spkId) {
                    swal({
                        icon: 'error',
                        title: 'Error',
                        text: 'SPK ID is missing!',
                        buttons: {
                            confirm: {
                                text: 'OK',
                                className: 'btn btn-danger'
                            }
                        }
                    });
                    return;
                }

                // SweetAlert untuk konfirmasi
                swal({
                    title: 'Are you sure?',
                    text: 'You are about to close this SPK!',
                    icon: 'warning',
                    buttons: {
                        cancel: {
                            text: 'Cancel',
                            visible: true,
                            className: 'btn btn-default'
                        },
                        confirm: {
                            text: 'Yes, proceed!',
                            className: 'btn btn-success'
                        }
                    }
                }).then((willClose) => {
                    if (willClose) {
                        // Tampilkan indikator loading
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we close the SPK.',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });

                        // Kirim permintaan AJAX
                        $.ajax({
                            url: '/edc/api/spk/close/' + spkId, // Endpoint untuk menutup SPK
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                Swal.close(); // Tutup indikator loading
                                if (response.success) {
                                    swal({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'SPK successfully closed!',
                                        buttons: {
                                            confirm: {
                                                text: 'OK',
                                                className: 'btn btn-success'
                                            }
                                        }
                                    });

                                    // Perbarui tampilan status di tabel
                                    $('#spkStatus-' + spkId).text('Closed').removeClass().addClass('badge badge-success');

                                    // Nonaktifkan tombol Close
                                    const closeButton = $('#closeButton');
                                    closeButton
                                        .attr('disabled', 'disabled') // Nonaktifkan tombol
                                        .css({
                                            opacity: 0.65,
                                            pointerEvents: 'none'
                                        });

                                    // Tutup modal
                                    $('#spkDetailsModal').modal('hide');
                                } else {
                                    swal({
                                        icon: 'error',
                                        title: 'Failed',
                                        text: response.message,
                                        buttons: {
                                            confirm: {
                                                text: 'OK',
                                                className: 'btn btn-danger'
                                            }
                                        }
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.close(); // Tutup indikator loading
                                swal({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to close SPK. Please try again later.',
                                    buttons: {
                                        confirm: {
                                            text: 'OK',
                                            className: 'btn btn-danger'
                                        }
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>


    <!-- edit  -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('button[data-bs-target="#editSpkModal"]');

            // Event untuk membuka modal dan mengisi data
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const modal = document.querySelector('#editSpkModal');

                    // Isi data ke modal
                    modal.querySelector('#modalSpkId').value = this.dataset.id;
                    modal.querySelector('#modalSpkNumber').value = this.dataset.spkNumber || '-';
                    modal.querySelector('#modalRequestDate').value = this.dataset.requestDate || '-';
                    modal.querySelector('#modalSubject').value = this.dataset.subject || '';
                    modal.querySelector('#modalDescription').value = this.dataset.description || '';

                    // Tampilkan daftar attachments
                    const existingAttachmentsList = modal.querySelector('#existingAttachmentsList');
                    existingAttachmentsList.innerHTML = ''; // Kosongkan isi sebelumnya

                    try {
                        const rawAttachments = this.dataset.attachments;
                        const attachments = JSON.parse(rawAttachments || '[]');

                        if (attachments.length > 0) {
                            attachments.forEach(attachment => {
                                const attachmentElement = document.createElement('div');
                                attachmentElement.className = 'd-flex align-items-center justify-content-between';
                                attachmentElement.innerHTML = `
                                    <a href="/storage/${attachment.path}" target="_blank">${attachment.originalName}</a>
                                `;
                                existingAttachmentsList.appendChild(attachmentElement);
                            });
                        } else {
                            existingAttachmentsList.innerHTML = '<p>No Attachments</p>';
                        }
                    } catch (error) {
                        console.error('Failed to parse attachments:', error);
                        existingAttachmentsList.innerHTML = '<p>No Attachments</p>';
                    }
                });
            });

            // Event untuk menyimpan perubahan
            document.querySelector('#saveChangesButton').addEventListener('click', function () {
                const modal = document.querySelector('#editSpkModal');
                const spkId = modal.querySelector('#modalSpkId').value;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to save the changes?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan indikator loading
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Saving your changes.',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });

                        const formData = new FormData();
                        formData.append('spkNumber', modal.querySelector('#modalSpkNumber').value);
                        formData.append('requestDate', modal.querySelector('#modalRequestDate').value);
                        formData.append('subject', modal.querySelector('#modalSubject').value);
                        formData.append('description', modal.querySelector('#modalDescription').value);

                        const newAttachments = modal.querySelector('#modalAttachmentsInput').files;
                        for (let i = 0; i < newAttachments.length; i++) {
                            formData.append('new_attachments[]', newAttachments[i]);
                        }

                        const removedAttachments = [...document.querySelectorAll('.remove-attachment')].map(btn => btn.dataset.path);
                        removedAttachments.forEach(path => formData.append('removed_attachments[]', path));

                        fetch(`/edc/api/spk/update/${spkId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: formData,
                        })
                            .then(response => {
                                Swal.close(); // Tutup indikator loading
                                if (!response.ok) {
                                    throw new Error(`HTTP error ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'Data successfully updated!',
                                        timer: 3000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed',
                                        text: `Failed to update: ${data.message}`,
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error updating data:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to update data. Please try again.',
                                });
                            });
                    }
                });
            });
        });
    </script>

    <!-- deleted -->
    <script>
        $(document).on('click', '.delete-button', function () {
            const spkId = $(this).data('id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this SPK!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "Cancel",
                        visible: true,
                        className: "btn btn-default",
                    },
                    confirm: {
                        text: "Yes, delete it!",
                        className: "btn btn-danger",
                    },
                },
            }).then((willDelete) => {
                if (willDelete) {
                    // Tampilkan indikator loading
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Deleting the SPK.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });

                    $.ajax({
                        url: '/edc/api/spk/delete/' + spkId, // Pastikan route ini sesuai
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            Swal.close(); // Tutup indikator loading
                            if (response.success) {
                                swal({
                                    icon: "success",
                                    title: "Deleted!",
                                    text: response.message,
                                    buttons: false,
                                    timer: 2000,
                                });

                                // Reload halaman untuk memperbarui tabel
                                location.reload();
                            } else {
                                swal({
                                    icon: "error",
                                    title: "Failed!",
                                    text: response.message,
                                    buttons: false,
                                    timer: 2000,
                                });
                            }
                        },
                        error: function () {
                            Swal.close(); // Tutup indikator loading
                            swal({
                                icon: "error",
                                title: "Error",
                                text: "Failed to delete SPK.",
                                buttons: false,
                                timer: 2000,
                            });
                        },
                    });
                }
            });
        });
    </script>


    <!-- sweetalert -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>

    





    
</body>
</html>

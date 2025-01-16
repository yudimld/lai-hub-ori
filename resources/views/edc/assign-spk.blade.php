<!DOCTYPE html>
<html lang="en">
@php
    $title = 'Assign SPK';
@endphp
@include('layouts.head')


<style>

    .modal-blur {
        filter: blur(5px); /* Efek blur */
        pointer-events: none; /* Nonaktifkan interaksi */
        transition: all 0.3s ease; /* Transisi animasi */
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
                                <h2 class="text-white pb-2 fw-bold">Assign SPK EDC</h2>
                                <h5 class="text-white op-7 mb-2">List data untuk assign project EDC</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h1 class="fw-bold">SPK - Open</h1>
                                    <hr>
                                    <div class="table-responsive">
                                        <table id="assign-spk-table" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>SPK Number</th>
                                                    <th>Subject</th>
                                                    <th>Description</th>
                                                    <th>Request Date</th>
                                                    <th>Created By</th>
                                                    <!-- <th>Attachments</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if (!empty($spkList))
                                                    @foreach ($spkList as $spk)
                                                    <tr>
                                                        <td>{{ $spk['spkNumber'] }}</td>
                                                        <td>{{ $spk['subject'] }}</td>
                                                        <td>{{ $spk['deskripsi'] }}</td>
                                                        <td>{{ $spk['requestDate'] }}</td>
                                                        <td>{{ $spk['createdBy'] }}</td>
                                                        <td>
                                                            @if ($spk['status'] === 'Assigned')
                                                                <span class="badge badge-primary">Assigned</span>
                                                            @endif

                                                            <button 
                                                            
                                                                class="btn btn-primary btn-round show-details-button btn-link btn-lg"
                                                                data-id="{{ $spk['id'] }}" 
                                                                data-spk-number="{{ $spk['spkNumber'] }}" 
                                                                data-request-date="{{ $spk['requestDate'] }}" 
                                                                data-subject="{{ $spk['subject'] }}" 
                                                                data-created-by="{{ $spk['createdBy'] }}" 
                                                                data-deskripsi="{{ $spk['deskripsi'] ?? '' }}"
                                                                data-attachments='@json($spk['attachments'])'
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#spkDetailsModal">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center">No data available</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <form id="spkDetailsForm" method="POST" action="{{ route('edc.assign-spk-action', ['id' => 'ID_PLACEHOLDER']) }}">
                                            @csrf
                                            <input type="hidden" id="spkId" name="spkId">
                                            <!-- modal detail  -->
                                            <div class="modal fade" id="spkDetailsModal" tabindex="-1" aria-labelledby="spkDetailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header" style="background-color: #266CA9; color: #fff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                            <h5 class="modal-title fw-bold" id="spkDetailsModalLabel" style="flex: 1; text-align: center;">SPK Details for Assign</h5>
                                                        </div>
                                                        <!-- Modal Body -->
                                                        <div class="modal-body">
                                                            <form id="spkDetailsForm">
                                                                <!-- SPK Number -->
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <label for="spkNumber" class="form-label">SPK Number</label>
                                                                        <input type="text" id="spkNumber" name="spkNumber" class="form-control" readonly>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="requestDate" class="form-label">Request Date</label>
                                                                        <input type="date" id="requestDate" name="requestDate" class="form-control" readonly>
                                                                    </div>
                                                                </div>

                                                                <!-- Subject -->
                                                                <div class="row mb-3">
                                                                    <div class="col-md-12">
                                                                        <label for="subject" class="form-label">Subject</label>
                                                                        <input type="text" id="subject" name="subject" class="form-control" readonly>
                                                                    </div>
                                                                </div>

                                                                <!-- Created By -->
                                                                <div class="row mb-3">
                                                                    <div class="col-md-12">
                                                                        <label for="createdBy" class="form-label">Created By</label>
                                                                        <input type="text" id="createdBy" name="createdBy" class="form-control" readonly>
                                                                    </div>
                                                                </div>

                                                                <!-- Description -->
                                                                <div class="row mb-3">
                                                                    <div class="col-md-12">
                                                                        <label for="Deskripsi" class="form-label">Description</label>
                                                                        <textarea id="Deskripsi" name="Deskripsi" class="form-control" rows="4" readonly></textarea>
                                                                    </div>
                                                                </div>

                                                                <!-- Attachments & Assignee -->
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Attachments</label>
                                                                        <ul id="attachmentsList" class="list-unstyled">
                                                                            <!-- Attachments will be loaded dynamically -->
                                                                        </ul>
                                                                    </div>
                                                                
                                                                    <div class="col-md-6">
                                                                        <label for="assignee" class="form-label">Assignee</label>
                                                                        <select id="assignee" name="assignee" class="form-control">
                                                                            <option value="-" selected></option>
                                                                            <option value="Yudi Mulyadi">Yudi Mulyadi</option>
                                                                            <option value="Yudi Mulyadi">Danan Dwiyaksa</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- Category and Priority -->
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <label for="category" class="form-label">Category</label>
                                                                        <select id="category" name="category" class="form-control">
                                                                            <option value="create" selected>Create</option>
                                                                            <option value="modification">Modification</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="priority" class="form-label">Priority</label>
                                                                        <select id="priority" name="priority" class="form-control">
                                                                            <option value="minor" selected>Minor</option>
                                                                            <option value="major">Major</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <!-- Start Date and Deadline Date -->
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <label for="startDate" class="form-label">Start Date</label>
                                                                        <input type="date" id="startDate" name="startDate" class="form-control">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="deadlineDate" class="form-label">Deadline Date</label>
                                                                        <input type="date" id="deadlineDate" name="deadlineDate" class="form-control">
                                                                    </div>
                                                                </div>

                                                                 <!-- Jenis Biaya -->
                                                                 <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <label for="jenisBiaya" class="form-label">Jenis Biaya</label>
                                                                            <select id="jenisBiaya" name="jenisBiaya" class="form-control">
                                                                                <option value="< 5 juta" selected>< 5 Juta</option>
                                                                                <option value="> 5 juta">> 5 Juta</option>
                                                                        </select>
                                                                    </div>
                                                                <!-- Jenis SPK -->
                                                                    <div class="col-md-6">
                                                                        <label for="jenisSpk" class="form-label">Jenis Spk</label>
                                                                        <select id="jenisSpk" name="jenisSpk" class="form-control">
                                                                            <option value="Plant" selected>Plant</option>
                                                                            <option value="Non-Plant">Non-Plant</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <!-- Modal Footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
                                                            
                                                            <!-- Tombol Reject -->
                                                            <button type="button" class="btn btn-danger btn-round" id="rejectButton">
                                                                <span class="btn-label">
                                                                    <i class="fa fa-times"></i>
                                                                </span>
                                                                Request to Reject
                                                            </button>
                                                            <!-- Tombol Assign -->
                                                            <button type="submit" form="spkDetailsForm" class="btn btn-warning btn-round" id="assignButton" disabled>
                                                                <span class="btn-label">
                                                                    <i class="fa fa-check"></i>
                                                                </span>
                                                                Assign
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- modal reject -->
                                        <div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header" style="background-color: #dc3545; color: #fff;">
                                                        <h5 class="modal-title fw-bold" id="reasonModalLabel">Reject Reason</h5>
                                                    </div>

                                                    <!-- Modal Body -->
                                                    <div class="modal-body">
                                                        <form id="reasonForm">
                                                            @csrf
                                                            <input type="hidden" id="rejectSpkId" name="spkId">
                                                            <div class="form-group">
                                                                <label for="rejectReason" class="form-label">Reason</label>
                                                                <textarea id="rejectReason" name="reason" class="form-control" rows="5" required></textarea>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <!-- Modal Footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" form="reasonForm" class="btn btn-danger btn-round" id="submitRejectButton">
                                                            <span class="btn-label">
                                                                <i class="fa fa-paper-plane"></i>
                                                            </span>
                                                            Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="fw-bold">SPK - Request to Close</h1>
                                            <hr>
                                            <div class="table-responsive">
                                                <table id="assign-table" class="display table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Status</th>
                                                            <th>SPK Number</th>
                                                            <th>Subject</th>
                                                            <th>Description</th>
                                                            <th>Request Date</th>
                                                            <th>Created By</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($assignedList as $spk)
                                                            <tr>
                                                                <td>
                                                                    <span id="spkStatus-{{ $spk->id }}" 
                                                                        class="badge badge-warning">
                                                                        {{ $spk->status }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $spk->spkNumber }}</td>
                                                                <td>{{ $spk->subject }}</td>
                                                                <td>{{ $spk->deskripsi }}</td>
                                                                <td>{{ $spk->requestDate }}</td>
                                                                <td>{{ $spk->createdBy }}</td>
                                                                <td>
                                                                    <!-- Tombol Request to Close -->
                                                                    <button 
                                                                        class="btn btn-primary btn-sm btn-round request-close-button btn-link btn-sm" 
                                                                        data-id="{{ $spk->id }}">
                                                                        <i class="fa fa-paper-plane"> Request to Close</i>
                                                                    </button>

                                                                    <!-- Tombol Edit -->
                                                                    <button 
                                                                        class="btn btn-warning btn-round edit-button btn-link btn-sm"
                                                                        data-id="{{ $spk->id }}"
                                                                        data-category="{{ $spk->category ?? '' }}"
                                                                        data-priority="{{ $spk->priority ?? '' }}"
                                                                        data-start-date="{{ $spk->start_date ?? '' }}"
                                                                        data-deadline-date="{{ $spk->deadline_date ?? '' }}"
                                                                        data-jenis-biaya="{{ $spk->jenis_biaya ?? '' }}"
                                                                        data-jenis-spk="{{ $spk->jenis_spk ?? '' }}"
                                                                        data-persentase="{{ $spk->persentase }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editSpkModal">
                                                                        <i class="fa fa-edit"> Edit</i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <!-- Modal Edit -->
                                                <div class="modal fade" id="editSpkModal" tabindex="-1" aria-labelledby="editSpkModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header" style="background-color: #266CA9; color: #ffffff; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                                <h5 class="modal-title" id="editSpkModalLabel" style="flex: 1; text-align: center;">Edit SPK Assigned</h5>
                                                            </div>

                                                            <!-- Modal Body -->
                                                            <div class="modal-body">
                                                                <form id="editSpkForm">
                                                                    <input type="hidden" id="editSpkId">
                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <label for="editCategory" class="form-label">Category</label>
                                                                            <select id="editCategory" name="editCategory" class="form-control">
                                                                                <option value="create" selected>Create</option>
                                                                                <option value="modification">Modification</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="editPriority" class="form-label">Priority</label>
                                                                            <select id="editPriority" name="editPriority" class="form-control">
                                                                                <option value="minor" selected>Minor</option>
                                                                                <option value="major">Major</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <!-- Start Date -->
                                                                        <div class="col-md-6">
                                                                            <label for="editStartDate" class="form-label">Start Date</label>
                                                                            <input type="date" id="editStartDate" class="form-control">
                                                                        </div>
                                                                        <!-- Deadline Date -->
                                                                        <div class="col-md-6">
                                                                            <label for="editDeadlineDate" class="form-label">Deadline Date</label>
                                                                            <input type="date" id="editDeadlineDate" class="form-control">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <!-- Jenis Biaya -->
                                                                        <div class="col-md-6">
                                                                            <label for="editJenisBiaya" class="form-label">Jenis Biaya</label>
                                                                                <select id="editJenisBiaya" name="editJenisBiaya" class="form-control">
                                                                                    <option value="< 5 juta" selected>< 5 Juta</option>
                                                                                    <option value="> 5 juta">> 5 Juta</option>
                                                                            </select>
                                                                        </div>
                                                                        <!-- Jenis SPK -->
                                                                        <div class="col-md-6">
                                                                            <label for="editJenisSpk" class="form-label">Jenis Spk</label>
                                                                            <select id="editJenisSpk" name="editJenisSpk" class="form-control">
                                                                                <option value="Plant" selected>Plant</option>
                                                                                <option value="Non-Plant">Non-Plant</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <!-- Input untuk Persentase -->
                                                                        <div class="col-md-6">
                                                                            <label for="editPersentase" class="form-label">Persentase (%)</label>
                                                                            <input type="number" id="editPersentase" name="editPersentase" class="form-control" min="0" max="100" placeholder="0-100">
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-round" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary btn-round" id="saveEditButton">Save Changes</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS detail button show -->
    <script>
        $(document).on('click', '.show-details-button', function () {
            // Ambil data dari atribut tombol
            const spkId = $(this).data('id');
            const spkNumber = $(this).data('spk-number') || '-';
            const requestDate = $(this).data('request-date') || '-';
            const subject = $(this).data('subject') || '-';
            const createdBy = $(this).data('created-by') || '-';
            const deskripsi = $(this).data('deskripsi') || '-';
            const attachments = $(this).data('attachments') || [];

            // Isi form modal
            $('#spkId').val(spkId);
            $('#spkDetailsForm').attr('action', `/edc/assign-spk/${spkId}`);
            $('#spkNumber').val(spkNumber);
            $('#requestDate').val(requestDate);
            $('#subject').val(subject);
            $('#createdBy').val(createdBy);
            $('#Deskripsi').val(deskripsi);

            // Tampilkan daftar attachments
            let attachmentsHtml = '';
            if (attachments.length > 0) {
                attachments.forEach(attachment => {
                    attachmentsHtml += `<li><a href="/storage/${attachment.path}" target="_blank">${attachment.originalName}</a></li>`;
                });
            } else {
                attachmentsHtml = '<li>No Attachments</li>';
            }
            $('#attachmentsList').html(attachmentsHtml);

        });

        // Event submit untuk form assign SPK
        $(document).on('submit', '#spkDetailsForm', function (e) {
            e.preventDefault(); // Cegah reload halaman

            const form = $(this);
            const actionUrl = form.attr('action'); // URL dari action form
            const spkId = $('#spkId').val(); // Ambil ID SPK dari input hidden

            // Tampilkan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to assign this SPK.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, assign it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading sebelum proses
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Submitting your request, please wait...',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading(); // Tampilkan loading spinner
                        }
                    });

                    // Kirim form menggunakan AJAX
                    $.ajax({
                        url: actionUrl, // URL API dari form action
                        method: 'POST',
                        data: form.serialize(), // Kirim data form
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
                        },
                        success: function (response) {
                            Swal.close(); // Tutup loading spinner

                            if (response.status === 'success') {
                                // SweetAlert sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Assigned!',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Tutup modal
                                    $('#spkDetailsModal').modal('hide');

                                    // Perbarui status di tabel
                                    $(`button[data-id="${spkId}"]`)
                                        .closest('tr')
                                        .find('td:last') // Pilih kolom terakhir (kolom Action)
                                        .html('<span class="badge badge-primary">Assigned</span>');

                                    // Hapus baris dari tabel jika perlu
                                    $(`button[data-id="${spkId}"]`)
                                        .closest('tr')
                                        .fadeOut(300, function () {
                                            $(this).remove();
                                        });
                                });
                            } else {
                                // SweetAlert error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function (xhr) {
                            Swal.close(); // Tutup loading spinner
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An error occurred: ' + (xhr.responseJSON?.message || 'Unknown error'),
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    </script>


    <!-- untuk validasi data form modal -->
    <script>
        $(document).ready(function () {
            // Fungsi untuk memeriksa validasi form
            function validateForm() {
                const assignee = $('#assignee').val().trim();
                const startDate = $('#startDate').val().trim();
                const deadlineDate = $('#deadlineDate').val().trim();
                const priority = $('#priority').val().trim();
                const category = $('#category').val().trim();
                const jenisBiaya = $('#jenisBiaya').val().trim();
                const jenisSpk = $('#jenisSpk').val().trim();

                // Validasi semua field wajib
                if (assignee && startDate && deadlineDate && priority && category && jenisBiaya && jenisSpk) {
                    $('#assignButton').prop('disabled', false); // Aktifkan tombol
                } else {
                    $('#assignButton').prop('disabled', true); // Nonaktifkan tombol
                }
            }

            // Event listener untuk setiap input pada form
            $('#assignee, #startDate, #deadlineDate, #priority, #category, #jenisBiaya, #jenisSpk').on('input change', function () {
                validateForm();
            });

            // Pastikan tombol diinisialisasi dalam kondisi disabled
            validateForm();
        });
    </script>

    <!-- untuk reject -->
    <script>
        $(document).ready(function () {
            // Ketika tombol Reject diklik
            $(document).on('click', '#rejectButton', function () {
                const spkId = $('#spkId').val(); // Ambil ID SPK dari modal utama
                $('#rejectSpkId').val(spkId); // Set ID ke modal reason

                // Tambahkan efek buram ke modal utama
                $('#spkDetailsModal').addClass('modal-blur');

                // Tampilkan modal Reject
                $('#reasonModal').modal('show');
            });

            // Ketika modal Reject ditutup
            $(document).on('hidden.bs.modal', '#reasonModal', function () {
                // Hapus efek buram dari modal utama
                $('#spkDetailsModal').removeClass('modal-blur');
            });

            // Submit form Reject dengan SweetAlert konfirmasi
            $(document).on('submit', '#reasonForm', function (e) {
                e.preventDefault(); // Cegah reload halaman

                const spkId = $('#rejectSpkId').val(); // Ambil ID SPK
                const reason = $('#rejectReason').val(); // Ambil alasan reject

                if (!spkId || !reason) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error!',
                        text: 'SPK ID and Reason are required.',
                    });
                    return;
                }

                // SweetAlert konfirmasi
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to Request to Reject this SPK.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, request it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loading sebelum proses
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Submitting your request, please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading(); // Tampilkan loading spinner
                            }
                        });

                        // Kirim data dengan AJAX
                        $.ajax({
                            url: `/edc/reject-spk/${spkId}`, // Endpoint reject
                            method: 'POST',
                            data: { reason },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                Swal.close(); // Tutup loading spinner

                                if (response.status === 'success') {
                                    // Tampilkan notifikasi sukses
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Request Submitted!',
                                        text: response.message,
                                    }).then(() => {
                                        // Tutup semua modal setelah notifikasi sukses
                                        $('#reasonModal').modal('hide');
                                        $('#spkDetailsModal').modal('hide');

                                        // Perbarui status di tabel
                                        $(`button[data-id="${spkId}"]`)
                                            .closest('tr')
                                            .find('td:last')
                                            .html('<span class="badge badge-warning">Request to Reject</span>');
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed!',
                                        text: response.message,
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.close(); // Tutup loading spinner
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'An error occurred.',
                                });
                            },
                        });
                    }
                });
            });
        });
    </script>


    <!-- menghapus data di table jika sudah di assign -->
    <script>
        $(document).ready(function () {
            // Event submit form modal Assign SPK
            $('#spkDetailsForm').on('submit', function (e) {
                e.preventDefault(); // Cegah reload halaman

                const form = $(this);
                const actionUrl = form.attr('action'); // URL dari action form
                const spkId = $('#spkId').val(); // Ambil ID SPK dari input hidden

                // Tampilkan konfirmasi dengan SweetAlert
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to assign this SPK.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, assign it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim form menggunakan AJAX
                        $.ajax({
                            url: actionUrl, // URL API dari form action
                            method: 'POST',
                            data: form.serialize(), // Kirim data form
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    // SweetAlert sukses
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Assigned!',
                                        text: response.message,
                                        confirmButtonText: 'OK'
                                    });

                                    // Tutup modal
                                    $('#spkDetailsModal').modal('hide');

                                    // Perbarui status di tabel pada kolom Action
                                    $(`button[data-id="${spkId}"]`)
                                        .closest('tr')
                                        .find('td:last') // Pilih kolom terakhir (kolom Action)
                                        .html('<span class="badge badge-primary">Assigned</span>');

                                    // Hapus baris dari tabel jika perlu
                                    $(`button[data-id="${spkId}"]`)
                                        .closest('tr')
                                        .fadeOut(300, function () {
                                            $(this).remove();
                                        });
                                } else {
                                    // SweetAlert error
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed!',
                                        text: response.message,
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'An error occurred: ' + (xhr.responseJSON?.message || 'Unknown error'),
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    <!-- request closed table -->
    <script>
        $(document).ready(function () {
            $('#assign-table').DataTable({
                "processing": true,
            }); // Inisialisasi DataTable
            order: [[4, 'desc']]; // Urutkan kolom pertama (indeks 0) secara descending

            // Event listener untuk tombol Ceklis
            $(document).on('click', '.request-close-button', function () {
                const spkId = $(this).data('id'); // Ambil ID SPK dari tombol

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to Request to Close this SPK.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, request it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loading
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Submitting your request, please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading(); // Tampilkan loading spinner
                            }
                        });

                        // Kirim permintaan AJAX ke backend untuk mengubah status
                        $.ajax({
                            url: `/edc/request-close/${spkId}`,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                Swal.close(); // Tutup loading spinner

                                if (response.status === 'success') {
                                    // SweetAlert sukses
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: response.message,
                                    }).then(() => {
                                        location.reload(); // Refresh halaman setelah konfirmasi
                                    });
                                } else {
                                    // SweetAlert error (jika ada respon dengan status error)
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.close(); // Tutup loading spinner
                                // SweetAlert error untuk kesalahan server
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'An unexpected error occurred.',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>


    <!-- edit data yang sudah di assign -->
    <script>
        $(document).ready(function () {
            // Event listener untuk tombol Edit
            $(document).on('click', '.edit-button', function () {
                const spkId = $(this).data('id');
                const category = $(this).data('category');
                const priority = $(this).data('priority');
                const startDate = $(this).data('start-date');
                const deadlineDate = $(this).data('deadline-date');
                const jenisBiaya = $(this).data('jenis-biaya');
                const jenisSpk = $(this).data('jenis-spk');
                const persentase = $(this).data('persentase');

                // Isi modal dengan data SPK
                $('#editSpkId').val(spkId);
                $('#editCategory').val(category);
                $('#editPriority').val(priority);
                $('#editStartDate').val(startDate);
                $('#editDeadlineDate').val(deadlineDate);
                $('#editJenisBiaya').val(jenisBiaya);
                $('#editJenisSpk').val(jenisSpk);
                $('#editPersentase').val(persentase);
            });

            // Event untuk menyimpan perubahan
            $('#saveEditButton').on('click', function () {
                const spkId = $('#editSpkId').val();
                const data = {
                    category: $('#editCategory').val(),
                    priority: $('#editPriority').val(),
                    start_date: $('#editStartDate').val(),
                    deadline_date: $('#editDeadlineDate').val(),
                    jenis_biaya: $('#editJenisBiaya').val(),
                    jenis_spk: $('#editJenisSpk').val(),
                    persentase: $('#editPersentase').val(),
                };

                // Tampilkan konfirmasi SweetAlert sebelum melanjutkan
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to save these changes?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, save it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loading SweetAlert sebelum proses dimulai
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Saving your changes, please wait...',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading(); // Tampilkan loading spinner
                            }
                        });

                        // Kirim data ke server
                        $.ajax({
                            url: `/edc/api/update_assign/${spkId}`, // Perbaiki sesuai prefix route
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: data,
                            success: function (response) {
                                Swal.close(); // Tutup loading spinner

                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: response.message,
                                    }).then(() => {
                                        location.reload(); // Refresh halaman setelah update
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message,
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.close(); // Tutup loading spinner
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'An unexpected error occurred.',
                                });
                            },
                        });
                    }
                });
            });
        });
    </script>

</body>
</html>

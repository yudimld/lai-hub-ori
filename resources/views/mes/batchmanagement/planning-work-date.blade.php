<!DOCTYPE html>
<html lang="en">
@php
    $title = 'Planning Work Date';
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
                                <h2 class="text-white pb-2 fw-bold">Planning Work Date</h2>
                                <h5 class="text-white op-7 mb-2">Create Planning Work Date</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-end" style="margin-bottom: 15px;">
                                        <button class="btn btn-primary btn-round" id="addDataBtn">Add Data</button>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="planningWorkDateTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Datetime (YYYY-MM)</th>
                                                    <th>Target Production</th>
                                                    <th>Target Workdays</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Form for Add Data -->
                <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #266CA9">
                                <h5 class="modal-title" id="addDataModalLabel" style="color: #ffffff">Add New Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="addDataForm">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="datetime">Datetime (YYYY-MM)</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="year">Year (YYYY)</label>
                                                <input type="number" class="form-control" id="year" name="year" required min="2020" max="2099" step="1" placeholder="Enter Year" />

                                            </div>
                                            <div class="col-6">
                                                <label for="month">Month (MM)</label>
                                                <select id="month" class="form-control" name="month" required>
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="target_production">Target Production</label>
                                        <input type="number" class="form-control" id="target_production" name="target_production" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="target_workdays">Target Workdays</label>
                                        <input type="number" class="form-control" id="target_workdays" name="target_workdays" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary btn-round" id="submitDataBtn">Add Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Form for Edit Data -->
                <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #266CA9">
                                <h5 class="modal-title" id="editDataModalLabel" style="color: #ffffff">Edit Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editDataForm">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" id="edit_id"> <!-- Hidden field to store the ID for edit -->

                                    <div class="form-group">
                                        <label for="edit_year">Year (YYYY)</label>
                                        <input type="number" class="form-control" id="edit_year" name="year" required min="2020" max="2099" step="1" placeholder="Enter Year">
                                    </div>

                                    <div class="form-group">
                                        <label for="edit_month">Month (MM)</label>
                                        <select id="edit_month" class="form-control" name="month" required>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="edit_target_production">Target Production</label>
                                        <input type="number" class="form-control" id="edit_target_production" name="target_production" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="edit_target_workdays">Target Workdays</label>
                                        <input type="number" class="form-control" id="edit_target_workdays" name="target_workdays" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary btn-round" id="updateDataBtn">Update Data</button>
                                </div>
                            </form>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('atlantis/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('atlantis/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('atlantis/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('atlantis/js/atlantis.min.js') }}"></script>

    <!-- datatable -->
    <script>
        $(document).ready(function () {
            $('#planningWorkDateTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('mes-menu.batchmanagement.planning.data') }}",  // Pastikan URL ini benar
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'datetime', name: 'datetime' },
                    { data: 'target_production', name: 'target_production' },
                    { data: 'target_workdays', name: 'target_workdays' },
                    {
                    data: 'id',
                    render: function(data, type, row, meta) {
                        return `
                            <button class="btn btn-warning btn-sm" 
                                    onclick="editData('${row.id}', '${row.year}', '${row.month}', '${row.target_production}', '${row.target_workdays}')">Edit</button>
                        `;
                    }
                }

                ],
                searching: true,
                columnDefs: [
                    { 
                        targets: 0,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;  // Menambahkan nomor baris
                        }
                    }
                ]
            });
        });
    </script>

    <!-- // add data -->
    <script>
        // Show Add Data Modal when button clicked
        $('#addDataBtn').click(function() {
            $('#addDataModal').modal('show');  // Show the modal when the button is clicked
        });

        $('#addDataForm').submit(function(e) {
            e.preventDefault();

            // Ambil nilai year dan month
            var year = $('#year').val();
            var month = parseInt($('#month').val(), 10);  // Pastikan month menjadi integer

            var formData = {
                year: year,
                month: month,  // kirim month sebagai integer
                target_production: $('#target_production').val(),
                target_workdays: $('#target_workdays').val(),
                _token: $('input[name="_token"]').val()
            };

            // SweetAlert konfirmasi sebelum submit
            swal({
                title: "Are you sure?",
                text: "You want to add this data?",
                icon: "warning",
                buttons: ["Cancel", "Yes, Add Data!"],
                dangerMode: true,
            }).then((willAdd) => {
                if (willAdd) {
                    // Kirim data ke server menggunakan AJAX
                    $.ajax({
                        url: "{{ route('mes-menu.batchmanagement.planning.store') }}", // Pastikan URL ini benar
                        type: 'POST', // Gunakan POST untuk menyimpan data
                        data: formData,
                        success: function(response) {
                            // Tampilkan SweetAlert success
                            swal("Success!", "Data has been added successfully!", "success");
                            
                            // Tutup modal setelah berhasil
                            $('#addDataModal').modal('hide');
                            
                            // Reload DataTable untuk menampilkan data yang baru
                            $('#planningWorkDateTable').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText); // Menampilkan error di console
                            swal("Error!", "There was an error adding the data.", "error");
                        }
                    });
                } else {
                    swal("Cancelled", "Your data was not added.", "error");
                }
            });
        });


    </script>

    <!-- edit data -->
    <script>
function editData(id, year, month, target_production, target_workdays) {
    console.log("Editing data for ID:", id);
    console.log("Year:", year, "Month:", month, "Target Production:", target_production, "Target Workdays:", target_workdays);

    // Isi form modal dengan data yang diterima
    $('#edit_id').val(id);
    $('#edit_year').val(year);
    
    // Pastikan bulan memiliki format dua digit
    const formattedMonth = month < 10 ? `0${month}` : month; // Format bulan menjadi dua digit
    $('#edit_month').val(formattedMonth);  // Isi dropdown bulan dengan nilai yang diformat

    $('#edit_target_production').val(target_production);
    $('#edit_target_workdays').val(target_workdays);

    // Tampilkan modal form edit
    $('#editDataModal').modal('show');
}

$('#editDataForm').submit(function(e) {
    e.preventDefault();

    // Ambil ID dari hidden input
    var id = $('#edit_id').val();

    var formData = {
        year: $('#edit_year').val(),
        month: $('#edit_month').val(),
        target_production: $('#edit_target_production').val(),
        target_workdays: $('#edit_target_workdays').val(),
        _token: $('input[name="_token"]').val()
    };

    // SweetAlert konfirmasi sebelum update
    swal({
        title: "Are you sure?",
        text: "You want to update this data?",
        icon: "warning",
        buttons: ["Cancel", "Yes, Update Data!"],
        dangerMode: true,
    }).then((willUpdate) => {
        if (willUpdate) {
            // Update data menggunakan AJAX
            $.ajax({
    url: `{{ url('mes/menu/batchmanagement/planning-work-date') }}/${id}`,
    type: 'PUT',
    data: formData,
    success: function(response) {
        console.log('Success Response:', response);  // Log response dari server
        swal("Success!", "Data has been updated successfully!", "success");
        $('#editDataModal').modal('hide');
        $('#planningWorkDateTable').DataTable().ajax.reload();
    },
    error: function(xhr, status, error) {
        console.log('AJAX Error:', xhr.responseText);  // Log error response
        swal("Error!", "There was an error updating the data.", "error");
    }
});

        } else {
            swal("Cancelled", "Your data was not updated.", "error");
        }
    });
});

    </script>


</body>
</html>

<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

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
                                    <div class="table-responsive">
                                        <table id="dummy-data-table" class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Created At</th>
                                                </tr>
                                            </thead>
                                            
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

	<!-- jQuery Sparkline -->
	<script src="{{ asset('atlantis/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('atlantis/js/plugin/chart-circle/circles.min.js') }}"></script>


	<!-- Datatables -->
	<script src="{{ asset('atlantis/js/plugin/datatables/datatables.min.js') }}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('atlantis/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ asset('atlantis/js/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
	<script src="{{ asset('atlantis/js/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('atlantis/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('atlantis/js/atlantis.min.js') }}"></script>

    <script>
    $(document).ready(function () {
        // Inisialisasi DataTable untuk tabel dummy-data-table dengan data dari API
        $('#dummy-data-table').DataTable({
            ajax: {
                url: '/api/dummy-data', // URL dari dummy API JSON
                dataSrc: '', // Data berasal langsung dari root JSON
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'role' },
                { data: 'created_at' },
            ],
            pageLength: 5, // Jumlah data per halaman
        });

        // Inisialisasi DataTable untuk tabel dasar
        $('#basic-datatables').DataTable();

        // Inisialisasi DataTable dengan fitur filter pada kolom
        $('#multi-filter-select').DataTable({
            "pageLength": 5, // Jumlah baris per halaman
            initComplete: function () {
                // Tambahkan filter dropdown di footer setiap kolom
                this.api()
                    .columns()
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select class="form-control"><option value=""></option></select>'
                        )
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        // Tambahkan data unik ke dropdown
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            });
                    });
            },
        });

        // Inisialisasi DataTable dengan fitur tambah baris
        var addRowTable = $('#add-row').DataTable({
            "pageLength": 5, // Jumlah baris per halaman
        });

        // Aksi untuk tombol "Add Row"
        $('#addRowButton').click(function () {
            var action =
                '<td> <div class="form-button-action"> ' +
                '<button type="button" class="btn btn-link btn-primary btn-lg" data-toggle="tooltip" data-original-title="Edit Task"> ' +
                '<i class="fa fa-edit"></i> </button> ' +
                '<button type="button" class="btn btn-link btn-danger" data-toggle="tooltip" data-original-title="Remove"> ' +
                '<i class="fa fa-times"></i> </button> ' +
                '</div> </td>';

            // Tambahkan data baru ke tabel
            addRowTable.row
                .add([
                    $("#addName").val(), // Nama dari input
                    $("#addPosition").val(), // Posisi dari input
                    $("#addOffice").val(), // Office dari input
                    action, // Aksi
                ])
                .draw(false); // Render ulang tanpa memuat ulang halaman

            // Tutup modal setelah data ditambahkan
            $('#addRowModal').modal('hide');

            // Bersihkan input setelah data ditambahkan
            $("#addName").val('');
            $("#addPosition").val('');
            $("#addOffice").val('');
        });
    });
    </script>


</body>
</html>
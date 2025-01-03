<!DOCTYPE html>
<html lang="en">
@php
    $title = 'Create SPK';
@endphp
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
								<h2 class="text-white pb-2 fw-bold">Create SPK EDC</h2>
								<h5 class="text-white op-7 mb-2">Buat SPK untuk masuk ke List Antrian Project EDC</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form id="createSpkForm" action="{{ route('edc.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- SPK Number -->
                                        <div class="form-group row align-items-center">
                                            <label for="spkNumber" class="col-md-2 col-form-label text-left">SPK No.</label>
                                            <div class="col-md-10">
                                                <input type="text" id="spkNumber" name="spkNumber" class="form-control" value="{{ $spkNumber }}" readonly style="background-color: #eeefef">
                                            </div>
                                        </div>

                                        <!-- Request Date -->
                                        <div class="form-group row align-items-center">
                                            <label for="requestDate" class="col-md-2 col-form-label text-left">Request Date</label>
                                            <div class="col-md-10">
                                                <input readonly type="date" name="requestDate" class="form-control" id="requestDate" value="{{ date('Y-m-d') }}" style="background-color: #eeefef">
                                            </div>
                                        </div>

                                        <!-- Subject -->
                                        <div class="form-group row align-items-center">
                                            <label for="subject" class="col-md-2 col-form-label text-left">Subject</label>
                                            <div class="col-md-10">
                                                <input type="text" name="subject" class="form-control" id="subject" style="background-color: #eeefef">
                                            </div>
                                        </div>

                                        <!-- Deskripsi Pekerjaan -->
                                        <div class="form-group row align-items-center">
                                            <label class="col-md-2 col-form-label text-left" for="deskripsi">Deskripsi Pekerjaan</label>
                                            <div class="col-md-10">
                                                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="5" style="background-color: #eeefef;"></textarea>
                                            </div>
                                        </div>

                                        <!-- Attachments -->
                                        <div class="form-group row align-items-center">
                                            <label class="col-md-2 col-form-label text-left">Attachments</label>
                                            <div class="col-md-10">
                                                <div id="attachment-container">
                                                    <div class="input-group mb-2">
                                                        <input type="file" name="attachments[]" class="form-control attachment-file" style="padding: 5px;">
                                                        <button class="btn btn-outline-secondary remove-attachment" type="button" style="margin-left: 5px;">
                                                            Remove
                                                        </button>
                                                    </div>
                                                </div>
                                                <button class="btn btn-outline-primary mt-2" type="button" id="addAttachment">
                                                    + Add Attachment
                                                </button>
                                                <small class="form-text text-danger mt-2">
                                                    Maximum file size: 3MB<br>
                                                    File extensions: jpg, jpeg, bmp, png, xls, xlsx, doc, docx, pdf, txt, ppt, pptx
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="submit" class="btn btn-success btn-round">
                                                <span class="btn-label">
                                                    <i class="fa fa-check"></i>
                                                </span>Submit
                                            </button>
                                        </div>
                                    </form>
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

	<!-- Chart Circle -->
	<script src="{{ asset('atlantis/js/plugin/chart-circle/circles.min.js') }}"></script>


	<!-- Datatables -->
	<script src="{{ asset('atlantis/js/plugin/datatables/datatables.min.js') }}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('atlantis/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('atlantis/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('atlantis/js/atlantis.min.js') }}"></script>

    <script>
        // Ambil elemen input
        const requestDateInput = document.getElementById('requestDate');

        // Fungsi untuk mendapatkan tanggal sekarang dalam format YYYY-MM-DD
        function getCurrentDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Tambahkan 0 jika angka bulan < 10
            const day = String(today.getDate()).padStart(2, '0'); // Tambahkan 0 jika angka hari < 10
            return `${year}-${month}-${day}`;
        }

        // Atur nilai default input ke tanggal sekarang
        requestDateInput.value = getCurrentDate();
    </script>

    <script>
        document.getElementById('addAttachment').addEventListener('click', function () {
            const container = document.getElementById('attachment-container');

            const attachmentGroup = document.createElement('div');
            attachmentGroup.className = 'input-group mb-2';

            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = 'attachments[]';
            fileInput.className = 'form-control attachment-file';
            fileInput.style.padding = '5px';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-outline-secondary remove-attachment';
            removeButton.textContent = 'Remove';
            removeButton.style.marginLeft = '5px';

            removeButton.addEventListener('click', function () {
                container.removeChild(attachmentGroup);
            });

            attachmentGroup.appendChild(fileInput);
            attachmentGroup.appendChild(removeButton);

            container.appendChild(attachmentGroup);
        });

        const maxFiles = 5;

        document.getElementById('addAttachment').addEventListener('click', function () {
            const container = document.getElementById('attachment-container');
            const currentFiles = container.querySelectorAll('.attachment-file').length;

            if (currentFiles >= maxFiles) {
                alert(`You can only upload up to ${maxFiles} files.`);
                return;
            }

            // Add the new file input
            // (Same code as above)
        });


    </script>

    <!-- sweetalert -->
    <script>
        document.getElementById('createSpkForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Mencegah pengiriman form langsung

            // Tampilkan SweetAlert untuk konfirmasi
            Swal.fire({
                title: 'Are you sure?',
                text: "Make sure all data is correct before submitting.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan indikator loading sebelum pengiriman form
                    Swal.fire({
                        title: 'Submitting...',
                        text: 'Please wait while your data is being processed.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                    });

                    // Kirim form
                    this.submit();
                }
            });
        });
    </script>

    <!-- hindari duplikat data -->
    <script>
        document.getElementById('createSpkForm').addEventListener('submit', function () {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true; // Nonaktifkan tombol
            submitButton.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Submitting...
            `; // Tambahkan spinner dan ubah teks tombol
        });
    </script>





</body>
</html>
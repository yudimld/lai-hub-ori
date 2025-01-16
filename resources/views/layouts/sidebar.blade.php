
<!-- Sidebar -->
<div id="sidebar" class="sidebar sidebar-style-2">			
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('home-page/images/user.png') }}" alt="User Icon" class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ explode(' ', Auth::user()->name)[0] ?? 'Guest' }}
                            <!-- Tampilkan nama pengguna -->
                            <span class="user-level">{{ Auth::user()->role ?? 'User' }}</span> <!-- Tampilkan peran pengguna -->
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#profile" data-toggle="modal" data-target="#changePasswordModal">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <!-- MES-SPK -->
                @if (session('active_menu') === 'mes-spk')
                    <!-- Menu List SPK -->
                    <li class="nav-item {{ Request::is('mes-spk') ? 'active' : '' }}">
                        <a href="{{ route('mes.spk.list') }}">
                            <i class="fas fa-list"></i>
                            <p>List SPK</p>
                        </a>
                    </li>

                    <!-- Menu Create SPK -->
                    <li class="nav-item {{ Request::is('mes-spk/create') ? 'active' : '' }}">
                        <a href="{{ route('mes.spk.create') }}">
                            <i class="fas fa-plus"></i>
                            <p>Create SPK</p>
                        </a>
                    </li>
                @endif

                <!-- Menu untuk Sales Marketing CSR -->
                @if (Request::is('salesmarketing/csr*'))
                    <!-- Menu untuk manager_csr -->
                    @if (Auth::user()->role === 'manager_csr')
                        <li class="nav-item {{ Request::is('salesmarketing/csr/opportunity') ? 'active' : '' }}">
                            <a href="{{ route('csr.opportunity') }}">
                                <i class="fas fa-indent"></i>
                                <p>Opportunity</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('salesmarketing/csr/so-number') ? 'active' : '' }}">
                            <a href="{{ route('csr.so-number') }}">
                                <i class="fas fa-warehouse"></i>
                                <p>SO Number</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk spv_csr -->
                    @if (Auth::user()->role === 'spv_csr')
                        <li class="nav-item {{ Request::is('salesmarketing/csr/opportunity') ? 'active' : '' }}">
                            <a href="{{ route('csr.opportunity') }}">
                                <i class="fas fa-indent"></i>
                                <p>Opportunity</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('salesmarketing/csr/so-number') ? 'active' : '' }}">
                            <a href="{{ route('csr.so-number') }}">
                                <i class="fas fa-warehouse"></i>
                                <p>SO Number</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk staff_csr -->
                    @if (Auth::user()->role === 'staff_csr')
                        <li class="nav-item {{ Request::is('salesmarketing/csr/opportunity') ? 'active' : '' }}">
                            <a href="{{ route('csr.opportunity') }}">
                                <i class="fas fa-indent"></i>
                                <p>Opportunity</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('salesmarketing/csr/so-number') ? 'active' : '' }}">
                            <a href="{{ route('csr.so-number') }}">
                                <i class="fas fa-warehouse"></i>
                                <p>SO Number</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk staff_edc -->
                    @if (Auth::user()->role === 'staff_edc')
                        <li class="nav-item {{ Request::is('salesmarketing/csr/opportunity') ? 'active' : '' }}">
                            <a href="{{ route('csr.opportunity') }}">
                                <i class="fas fa-indent"></i>
                                <p>Opportunity</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('salesmarketing/csr/so-number') ? 'active' : '' }}">
                            <a href="{{ route('csr.so-number') }}">
                                <i class="fas fa-warehouse"></i>
                                <p>SO Number</p>
                            </a>
                        </li>
                    @endif
                @endif


                <!-- Menu untuk PPIC -->
                @if (Request::is('ppic-eticket*'))
                    <!-- Menu untuk manager_logistik -->
                    @if (Auth::user()->role === 'manager_logistik')
                        <li class="nav-item {{ Request::is('ppic-eticket') ? 'active' : '' }}">
                            <a href="{{ route('ppic.eticket') }}">
                                <i class="fas fa-list"></i>
                                <p>Data SPK CSR</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('ppic-eticket/ppic/requests') ? 'active' : '' }}">
                            <a href="{{ route('ppic.requests') }}">
                                <i class="fas fa-plus"></i>
                                <p>Create SPK</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk spv_ppic -->
                    @if (Auth::user()->role === 'spv_ppic')
                        <li class="nav-item {{ Request::is('ppic-eticket') ? 'active' : '' }}">
                            <a href="{{ route('ppic.eticket') }}">
                                <i class="fas fa-list"></i>
                                <p>Data SPK CSR</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('ppic-eticket/ppic/requests') ? 'active' : '' }}">
                            <a href="{{ route('ppic.requests') }}">
                                <i class="fas fa-plus"></i>
                                <p>Create SPK</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk staff_ppic -->
                    @if (Auth::user()->role === 'staff_edc')
                        <li class="nav-item {{ Request::is('ppic-eticket') ? 'active' : '' }}">
                            <a href="{{ route('ppic.eticket') }}">
                                <i class="fas fa-list"></i>
                                <p>Data SPK CSR</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('ppic-eticket/ppic/requests') ? 'active' : '' }}">
                            <a href="{{ route('ppic.requests') }}">
                                <i class="fas fa-plus"></i>
                                <p>Create SPK</p>
                            </a>
                        </li>
                    @endif
                @endif

                <!-- Menu untuk Delivery -->
                @if (Request::is('delivery-spk*'))
                    <!-- Menu untuk manager_logistik -->
                    @if (Auth::user()->role === 'manager_edc')
                        <li class="nav-item {{ Request::is('delivery-spk') ? 'active' : '' }}">
                            <a href="{{ route('delivery.spk') }}">
                                <i class="fas fa-truck"></i>
                                <p>Data Delivery</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('delivery-spk/requests') ? 'active' : '' }}">
                            <a href="{{ route('delivery.requests') }}">
                                <i class="fas fa-plus"></i>
                                <p>Create Delivery</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk spv_logistik -->
                    @if (Auth::user()->role === 'spv_logistik')
                        <li class="nav-item {{ Request::is('delivery-spk') ? 'active' : '' }}">
                            <a href="{{ route('delivery.spk') }}">
                                <i class="fas fa-truck"></i>
                                <p>Data Delivery</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('delivery-spk/requests') ? 'active' : '' }}">
                            <a href="{{ route('delivery.requests') }}">
                                <i class="fas fa-plus"></i>
                                <p>Create Delivery</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk staff_logistik -->
                    @if (Auth::user()->role === 'staff_edc')
                        <li class="nav-item {{ Request::is('delivery-spk') ? 'active' : '' }}">
                            <a href="{{ route('delivery.spk') }}">
                                <i class="fas fa-truck"></i>
                                <p>Data Delivery</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('delivery-spk/requests') ? 'active' : '' }}">
                            <a href="{{ route('delivery.requests') }}">
                                <i class="fas fa-plus"></i>
                                <p>Create Delivery</p>
                            </a>
                        </li>
                    @endif
                @endif


                <!-- Menu EDC -->
                @if (Request::is('edc*'))
                    <!-- Menu untuk manager_edc -->
                    @if (Auth::user()->role === 'manager_edc')
                        <li class="nav-item {{ Request::is('edc') ? 'active' : '' }}">
                            <a href="{{ route('edc.dashboard') }}">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('edc/assign-spk') ? 'active' : '' }}">
                            <a href="{{ route('edc.assign-spk') }}">
                                <i class="fas fa-user"></i>
                                <p>Assign SPK</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('edc/list-spk') ? 'active' : '' }}">
                            <a href="{{ route('edc.list-spk') }}">
                                <i class="fas fa-list"></i>
                                <p>List SPK</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('edc/create-spk') ? 'active' : '' }}">
                            <a href="{{ route('edc.create-spk') }}">
                                <i class="fas fa-plus"></i>
                                <p>Create SPK</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('edc/approval-reject') ? 'active' : '' }}">
                            <a href="{{ route('edc.approval-reject') }}">
                                <i class="fas fa-ban"></i>
                                <p>Approval Reject</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk staff_edc -->
                    @if (Auth::user()->role === 'staff_edc')
                        <li class="nav-item {{ Request::is('edc') ? 'active' : '' }}">
                            <a href="{{ route('edc.dashboard') }}">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('edc/assign-spk') ? 'active' : '' }}">
                            <a href="{{ route('edc.assign-spk') }}">
                                <i class="fas fa-user"></i>
                                <p>Assign SPK</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('edc/list-spk') ? 'active' : '' }}">
                            <a href="{{ route('edc.list-spk') }}">
                                <i class="fas fa-list"></i>
                                <p>List SPK</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('edc/create-spk') ? 'active' : '' }}">
                            <a href="{{ route('edc.create-spk') }}">
                                <i class="fas fa-plus"></i>
                                <p>Create SPK</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk role selain manager_edc dan staff_edc -->
                    @if (Auth::user()->role !== 'manager_edc' && Auth::user()->role !== 'staff_edc')
                        <li class="nav-item {{ Request::is('edc/list-spk') ? 'active' : '' }}">
                            <a href="{{ route('edc.list-spk') }}">
                                <i class="fas fa-list"></i>
                                <p>List SPK</p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('edc/create-spk') ? 'active' : '' }}">
                            <a href="{{ route('edc.create-spk') }}">
                                <i class="fas fa-plus"></i>
                                <p>Create SPK</p>
                            </a>
                        </li>
                    @endif
                @endif

            </ul>
        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #266CA9">
                <h5 class="modal-title" id="changePasswordModalLabel" style="color: #ffffff">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="changePasswordForm" action="{{ route('profile.change-password') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmNewPassword">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmNewPassword" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-round" id="confirmChangePassword">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('confirmChangePassword').addEventListener('click', function (e) {
        e.preventDefault(); // Mencegah pengiriman form default

        // Ambil nilai input
        const currentPassword = document.getElementById('currentPassword').value.trim();
        const newPassword = document.getElementById('newPassword').value.trim();
        const confirmNewPassword = document.getElementById('confirmNewPassword').value.trim();

        // Validasi input
        if (!currentPassword || !newPassword || !confirmNewPassword) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Form',
                text: 'Please fill out all fields before submitting.',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (newPassword !== confirmNewPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'New password and confirmation do not match.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Jika validasi lolos, tampilkan SweetAlert untuk konfirmasi
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to change your password?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form jika dikonfirmasi
                document.getElementById('changePasswordForm').submit();
            }
        });
    });

</script>

@if(session('success'))
<script>
    console.log('Success Message: {{ session('success') }}');
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    console.log('Error Message: {{ session('error') }}');
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false
    });
</script>
@endif




<!-- End Sidebar -->
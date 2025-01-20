<style>
    #userInfoButton i {
        font-size: 16px; /* Ukuran ikon */
        margin-right: 6px; /* Jarak antara ikon dan teks */
        color: #266CA9;
    }

    #userInfoButton {
        color: #266CA9; /* Warna teks di dalam span */
        font-weight: bold;
    }
</style>

<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" style="background-color: #ADE1FB;">        
        <a href="{{ url('/homePage') }}" class="logo">
            <img src="{{ asset('home-page/images/LogoLAI.png') }}"  style="max-height: 30px;" class="navbar-brand">
        </a>
        <button id="toggleSidebar" class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="#sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu" style="color: black;"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" style="background-color: #ffffff;">
        <div class="container-fluid">
            <div class="collapse" id="search-nav">
                <form class="navbar-left navbar-form nav-search mr-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-search pr-1">
                                <i class="fa fa-search search-icon"></i>
                            </button>
                        </div>
                        <input type="text" placeholder="Search ..." class="form-control">
                    </div>
                </form>
            </div>

            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item rounded" style="border: 2px solid #266CA9;">
                    <div class="d-flex align-items-center p-2 border rounded">
                        <!-- Data User -->
                        <div>
                            <span class="profile d-flex align-items-center" id="userInfoButton">
                                <i class="fas fa-user mr-2"></i>
                                {{ Auth::user()->name ?? 'Guest' }} ({{ Auth::user()->id_card ?? '-' }})
                            </span>
                        </div>
                    </div>
                </li>
                
                <!-- Tombol Kembali ke HomePage -->
                <li class="nav-item ml-1">
                    <a href="{{ url('/homePage') }}" id="home-button">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary" style="width: 40px; height: 40px;">
                            <i class="fas fa-home text-white"></i>
                        </div>
                    </a>
                </li>

                <!-- Tombol Logout -->
                <li class="nav-item ml-1">
                    <a href="javascript:void(0);" id="logout-button">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-danger" style="width: 40px; height: 40px;">
                            <i class="fas fa-power-off text-white"></i>
                        </div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>



        </div>
    </nav>
    <!-- End Navbar -->
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const logoutButton = document.getElementById("logout-button");
        const logoutForm = document.getElementById("logout-form");

        logoutButton.addEventListener("click", function (event) {
            event.preventDefault(); // Mencegah tindakan default dari tombol

            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out from the application.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Logout",
                cancelButtonText: "Cancel",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    logoutForm.submit(); // Kirim form logout jika dikonfirmasi
                }
            });
        });
    });
</script>

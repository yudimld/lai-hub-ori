<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page - LAI HUB</title>
    <link rel="stylesheet" href="{{ asset('home-page/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('atlantis/css/fonts.min.css') }}">
    <link rel="icon" href="{{ asset('atlantis/img/icon/lai.ico') }}" type="image/x-icon"/>
    <!-- Link CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ asset('home-page/images/lai.png') }}" alt="LAI Logo">
            <span>LAI HUB</span>
        </div>
        <div class="actions">
            <button class="profile d-flex align-items-center" id="userInfoButton" data-toggle="modal" data-target="#changePasswordModal">
                <i class="fas fa-user mr-2"></i> {{ Auth::user()->name ?? 'Guest' }} - {{ Auth::user()->id_card ?? 'ID Not Available' }}
            </button>

            <form id="logout-form-header" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
            <button type="button" class="logout" id="logout-button-header">
                <i class="fas fa-sign-out-alt"></i>
            </button>
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
                <form action="{{ route('profile.change-password') }}" method="POST">
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
                        <button type="submit" class="btn btn-primary btn-round">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content">
        <img src="{{ asset('home-page/images/LogoLAI.png') }}" alt="Lautan Air Indonesia">

        <div class="search-container">
                <!-- Tombol Home -->
                <button id="home-button" class="hidden">
                    <img src="{{ asset('home-page/images/home.png') }}" alt="Home Icon">
                </button>

                <!-- Tombol plant -->
                <button id="plant-button" class="hidden">
                    Plant
                </button>

                <!-- Tombol MES -->
                <button id="mes-button" class="hidden">
                    MES
                </button>
                <!-- TombolCMMS -->
                <button id="cmms-button" class="hidden">
                    CMMS
                </button>

                <!-- Tombol Supply Chain -->
                <button id="supplychain-button" class="hidden">
                    Supply Chain
                </button>

                <!-- Tombol Supply Chain -->
                <button id="warehouse-button" class="hidden">
                    Warehouse
                </button>

                <!-- Tombol Supply Chain -->
                <button id="delivery-button" class="hidden">
                    Delivery
                </button>

                <!-- Tombol Sales Marketing -->
                <button id="qhse-button" class="hidden">
                    QHSE
                </button>

                <!-- Tombol Sales Marketing -->
                <button id="salesmarketing-button" class="hidden">
                    Sales Marketing
                </button>

                <!-- Tombol Procurement & Exim -->
                <button id="procurement-button" class="hidden">
                    Procurement Exim
                </button>

                <!-- Search Bar -->
                <div class="search-bar">
                    <input type="text" placeholder="Start your search" id="search-bar">
                    <button></button>
                </div>
        </div>
        
        <div class="grid" id="grid-container">
            <div class="card" data-name="dashboard">
                <img src="{{ asset('home-page/images/dashboard.png') }}" alt="Dashboard">
                <span>Dashboard</span>
            </div>
            <div class="card" id="plant-card" data-name="plant">
                <img src="{{ asset('home-page/images/plant.png') }}" alt="Plant">
                <span>Plant</span>
            </div>
            <div class="card" data-name="hcca">
                <img src="{{ asset('home-page/images/hcca.png') }}" alt="HCCA">
                <span>HCCA</span>
            </div>
            <div class="card" data-name="r&d">
                <img src="{{ asset('home-page/images/r&d.png') }}" alt="R&D">
                <span>R&D</span>
            </div>
            <div class="card" id="qhse" data-name="qhse">
                <img src="{{ asset('home-page/images/qhse.png') }}" alt="QHSE">
                <span>QHSE</span>
            </div>
            <div class="card" id="salesmarketing-card" data-name="salesmarketing">
                <img src="{{ asset('home-page/images/salesmarketing.png') }}" alt="Sales & Marketing">
                <span>Sales & Marketing</span>
            </div>
            <div class="card" data-name="internalaudit">
                <img src="{{ asset('home-page/images/internalaudit.png') }}" alt="Internal Audit">
                <span>Internal Audit</span>
            </div>
            <a href="{{ route('finance.dashboard') }}" style="text-decoration: none;">
                <div class="card" data-name="finance">
                    <img src="{{ asset('home-page/images/finance.png') }}" alt="Finance">
                    <span>Finance</span>
                </div>
            </a>
            <div class="card" data-name="it">
                <img src="{{ asset('home-page/images/it.png') }}" alt="IT">
                <span>IT</span>
            </div>
            <a href="{{ Auth::user()->role === 'manager_edc' || Auth::user()->role === 'staff_edc' ? route('edc.dashboard') : route('edc.list-spk') }}" style="text-decoration: none;">
                <div class="card" data-name="engineeringdevelopmentcenter">
                    <img src="{{ asset('home-page/images/edc.png') }}" alt="Engineering Development Center">
                    <span>Engineering Development Center</span>
                </div>
            </a>
            <div class="card" data-name="businessdevelopment">
                <img src="{{ asset('home-page/images/business.png') }}" alt="Business Development">
                <span>Business Development</span>
            </div>
            <div class="card" id="supplychain" data-name="supplychain">
                <img src="{{ asset('home-page/images/supplychain.png') }}" alt="Supply Chain">
                <span>Supply Chain</span>
            </div>
            <div class="card" id="procurement" data-name="procurement">
                <img src="{{ asset('home-page/images/procurement.png') }}" alt="Procurement">
                <span>Procurement & exim</span>
            </div>
        </div>
    </div>

    <div class="footer">
        ©2024, made with <i class="fa fa-heart heart text-danger"></i> by Engineering Development Center LAI
    </div>
    
</body>
</html>

   <!-- Link JS Bootstrap (termasuk jQuery) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Ambil elemen-elemen yang dibutuhkan
        const homeButton = document.getElementById('home-button');
        const plantButton = document.getElementById('plant-button');
        const mesButton = document.getElementById('mes-button');
        const cmmsButton = document.getElementById('cmms-button');
        const supplyChainButton = document.getElementById('supplychain-button');
        const warehouseButton = document.getElementById('warehouse-button');
        const deliveryButton = document.getElementById('delivery-button');
        const qhseButton = document.getElementById('qhse-button');
        const salesMarketingButton = document.getElementById('salesmarketing-button');
        const procurementButton = document.getElementById('procurement-button');

        const gridContainer = document.getElementById('grid-container');
        const searchBar = document.getElementById('search-bar');
        const initialGridHTML = gridContainer.innerHTML; // Simpan HTML awal untuk kembali ke homepage
 
        // Fungsi untuk menyembunyikan semua tombol
        function hideAllButtons() {
            const allButtons = [homeButton, plantButton, mesButton, cmmsButton, supplyChainButton, warehouseButton, deliveryButton, qhseButton, salesMarketingButton, procurementButton];
            allButtons.forEach(button => button.classList.add('hidden'));
        }

        // Fungsi untuk menerapkan ulang gaya CSS ke elemen card
        function applyCardStyles(container) {
            const cards = container.querySelectorAll('.card'); // Ambil card di container tertentu
            cards.forEach((card) => {
                card.style.width = '100%';
                card.style.maxWidth = '245px';
                card.style.height = '118px';
                card.style.padding = '10px';
                card.style.display = 'flex';
                card.style.justifyContent = 'space-between';
                card.style.alignItems = 'center';
                card.style.background = 'conic-gradient(from 140deg at center, #ADE1FB 23%, #FFFFFF 56%)';
                card.style.borderRadius = '10px';
                card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            });
        }

        // Fungsi pencarian
        function performSearch() {
            const searchValue = searchBar.value.toLowerCase().trim(); // Ambil input dan ubah ke huruf kecil
            const allCards = Array.from(gridContainer.querySelectorAll('.card')); // Ambil elemen kartu secara dinamis

            allCards.forEach((card) => {
                const cardName = card.getAttribute('data-name').toLowerCase(); // Nama kartu dari data-name
                if (cardName.includes(searchValue)) {
                    card.style.display = 'flex'; // Tampilkan kartu jika cocok
                } else {
                    card.style.display = 'none'; // Sembunyikan kartu jika tidak cocok
                }
            });
        }

        // Fungsi untuk menampilkan tombol yang relevan
        function showButtons(...buttons) {
            buttons.forEach(button => button.classList.remove('hidden'));
        }

        // Event listener untuk card "Plant"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#plant-card')) {
                hideAllButtons();
                showButtons(homeButton, plantButton);

                // Ubah isi grid-container menjadi card baru
                gridContainer.innerHTML = `
                    <div class="card" id="mes-card" data-name="mes">
                        <img src="/home-page/images/mes.png" alt="MES">
                        <span>MES</span>
                    </div>
                    <div class="card" id="cmms-card" data-name="cmms">
                        <img src="{{ asset('home-page/images/cmms.png') }}" alt="CMMS">
                        <span>CMMS</span>
                    </div>
                    <div class="card" data-name="ums">
                        <img src="/home-page/images/ums.png" alt="UMS">
                        <span>UMS</span>
                    </div>
                    <div class="card" data-name="lims">
                        <img src="/home-page/images/lims.png" alt="LIMS">
                        <span>LIMS</span>
                    </div>
                `;
                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk card "MES"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#mes-card')) {
                hideAllButtons();
                showButtons(homeButton, mesButton);

                gridContainer.innerHTML = `
                    <div class="card" data-name="mesdashboard" id="mesdashboard-card">
                        <img src="/home-page/images/dashboard.png" alt="Dashboard">
                        <span>Dashboard</span>
                    </div>
                    
                    <div class="card" data-name="spk">
                        <img src="{{ asset('home-page/images/spk.png') }}" alt="SPK">
                        <span>SPK</span>
                    </div>
                    <a href="{{ route('mes-menu.batchmanagement.planning') }}" style="text-decoration: none;">
                        <div class="card" data-name="batch">
                            <img src="/home-page/images/batchmanagement.png" alt="Batch Management">
                            <span>Batch Management</span>
                        </div>
                    </a>

                `;
                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk card "CMMS"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#cmms-card')) {  // Pastikan id card "cmms-card"
                hideAllButtons();  // Fungsi untuk menyembunyikan semua tombol
                showButtons(homeButton, cmmsButton);  // Fungsi untuk menampilkan tombol yang relevan

                // Mengubah isi grid-container menjadi card CMMS yang benar
                gridContainer.innerHTML = `
                    <div class="card" data-name="cmmsdashboard" id="cmmsdashboard-card">
                        <img src="/home-page/images/dashboard.png" alt="Dashboard">
                        <span>Dashboard</span>
                    </div>
                    <div class="card" data-name="maintenance">
                        <img src="{{ asset('home-page/images/maintenance.png') }}" alt="Maintenance">
                        <span>Maintenance</span>
                    </div>
                    <div class="card" data-name="workorder">
                        <img src="/home-page/images/workorder.png" alt="Work Order">
                        <span>Work Order</span>
                    </div>
                `;
                applyCardStyles(gridContainer);  // Fungsi untuk menerapkan gaya kartu
                performSearch();  // Fungsi untuk melakukan pencarian, jika diperlukan
            }
        });

        // Event listener untuk card "Dashboard MES"
        gridContainer.addEventListener('click', (event) => {
            if (event.target.closest('#mesdashboard-card')) { // Sekarang bisa pakai ID
                hideAllButtons();
                showButtons(homeButton, mesButton);

                gridContainer.innerHTML = `
                    <div class="card" id="liquid-card" data-name="liquid">
                        <img src="/home-page/images/liquid.png" alt="Liquid">
                        <span>Liquid</span>
                    </div>
                    <a href="http://108.137.148.210:3001/public-dashboards/5fb514ae54064e5792f1de53add2873a?orgId=1&refresh=5s" style="text-decoration: none;">
                        <div class="card" id="powder-card" data-name="powder">
                            <img src="/home-page/images/powder.png" alt="Powder">
                            <span>Powder</span>
                        </div>
                    </a>
                    <div class="card" id="specialty-card" data-name="specialty">
                        <img src="/home-page/images/specialty.png" alt="Specialty">
                        <span>Specialty</span>
                    </div>
                `;

                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk card "Dashboard CMMS"
        gridContainer.addEventListener('click', (event) => {
            if (event.target.closest('#cmmsdashboard-card')) {
                hideAllButtons();
                showButtons(homeButton, cmmsButton);

                gridContainer.innerHTML = `
                    <div class="card" id="cmms-liquid-card" data-name="liquid">
                        <img src="/home-page/images/liquid.png" alt="Liquid">
                        <span>Liquid</span>
                    </div>
                    <a href="http://108.137.148.210:3001/public-dashboards/767d39d5255d487492100ab5f09cf616" style="text-decoration: none;">
                        <div class="card" id="cmms-powder-card" data-name="powder">
                            <img src="/home-page/images/powder.png" alt="Powder">
                            <span>Powder</span>
                        </div>
                    </a>
                    <div class="card" id="cmms-specialty-card" data-name="specialty">
                        <img src="/home-page/images/specialty.png" alt="Specialty">
                        <span>Specialty</span>
                    </div>
                `;

                applyCardStyles(gridContainer);
                performSearch();
            }
        });


        // Event listener untuk card "Supply Chain"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#supplychain')) {
                hideAllButtons();
                showButtons(homeButton, supplyChainButton);

                gridContainer.innerHTML = `
                    <div class="card" id="ppic-card" data-name="ppic">
                        <img src="/home-page/images/ppic.png" alt="ppic">
                        <span>PPIC</span>
                    </div>
                    <div class="card" id="warehouse-card" data-name="warehouse">
                        <img src="/home-page/images/warehouse.png" alt="Warehouse">
                        <span>Warehouse</span>
                    </div>
                    <div class="card" id="delivery-card" data-name="delivery">
                        <img src="/home-page/images/delivery.png" alt="Delivery">
                        <span>Delivery</span>
                    </div>
                `;
                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk card "PPIC"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#ppic-card')) {
                hideAllButtons();
                showButtons(homeButton, warehouseButton);

                gridContainer.innerHTML = `
                    <div class="card" data-name="dashboard">
                        <img src="/home-page/images/dashboard.png" alt="Dashboard">
                        <span>Dashboard</span>
                    </div>
                    <a href="{{ route('ppic.monitoring-spk') }}" style="text-decoration: none;">
                        <div class="card" data-name="monitoring">
                            <img src="/home-page/images/monitoring.png" alt="Monitoring">
                            <span>Monitoring</span>
                        </div>
                    </a>
                    <a href="{{ route('ppic.eticket') }}" style="text-decoration: none;">
                        <div class="card" data-name="eticket" id="ppic-eticket-card">
                            <img src="/home-page/images/eticket.png" alt="SPK">
                            <span>SPK</span>
                        </div>
                    </a>
                `;
                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk card "Warehouse"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#warehouse-card')) {
                hideAllButtons();
                showButtons(homeButton, warehouseButton);

                gridContainer.innerHTML = `
                    <div class="card" data-name="dashboard">
                        <img src="/home-page/images/dashboard.png" alt="Dashboard">
                        <span>Dashboard</span>
                    </div>
                    <div class="card" data-name="monitoring">
                        <img src="/home-page/images/monitoring.png" alt="Monitoring">
                        <span>Monitoring</span>
                    </div>
                    <div class="card" data-name="eticket">
                        <img src="/home-page/images/eticket.png" alt="SPK">
                        <span>SPK</span>
                    </div>
                `;
                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk card "Delivery"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#delivery-card')) {
                hideAllButtons();
                showButtons(homeButton, deliveryButton);

                gridContainer.innerHTML = `
                    <div class="card" data-name="dashboard">
                        <img src="/home-page/images/dashboard.png" alt="Dashboard">
                        <span>Dashboard</span>
                    </div>
                    <a href="{{ route('monitoring') }}" style="text-decoration: none;">
                        <div class="card" data-name="monitoring">
                            <img src="{{ asset('home-page/images/monitoring.png') }}" alt="Monitoring">
                            <span>Monitoring</span>
                        </div>
                    </a>
                    <a href="{{ route('delivery.spk') }}" style="text-decoration: none;">
                        <div class="card" data-name="eticket">
                            <img src="/home-page/images/eticket.png" alt="SPK">
                            <span>SPK</span>
                        </div>
                    </a>
                `;
                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk card "QHSE"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#qhse')) {
                hideAllButtons();
                showButtons(homeButton, qhseButton);

                gridContainer.innerHTML = `
                    <a href="{{ route('reports') }}" style="text-decoration: none;">
                        <div class="card" id="reports-card" data-name="reports">
                            <img src="{{ asset('home-page/images/reports.png') }}" alt="Reports">
                            <span>HSE Reports</span>
                        </div>
                    </a>
                    <div class="card" id="permit-card" data-name="permit">
                        <img src="/home-page/images/permit.png" alt="permit">
                        <span>E-permit</span>
                    </div>
                `;
                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk card "Sales & Marketing"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#salesmarketing-card')) {
                hideAllButtons();
                showButtons(homeButton, salesMarketingButton);

                gridContainer.innerHTML = `
                    <a href="/salesmarketing/csr/opportunity" style="text-decoration: none;">
                        <div class="card" id="leads-card" data-name="leads">
                            <img src="/home-page/images/csr.png" alt="CSR">
                            <span>CSR</span>
                        </div>
                    </a>
                    
                    <div class="card" id="campaigns-card" data-name="campaigns">
                        <img src="/home-page/images/campaigns.png" alt="Campaigns">
                        <span>Campaigns</span>
                    </div>
                    <div class="card" id="analytics-card" data-name="analytics">
                        <img src="/home-page/images/analytics.png" alt="Analytics">
                        <span>Analytics</span>
                    </div>
                `;
                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk tombol "Sales & Marketing"
        salesMarketingButton.addEventListener('click', () => {
            gridContainer.innerHTML = `
                <div class="card" id="leads-card" data-name="leads">
                    <img src="/home-page/images/leads.png" alt="Leads">
                    <span>Leads</span>
                </div>
                <div class="card" id="campaigns-card" data-name="campaigns">
                    <img src="/home-page/images/campaigns.png" alt="Campaigns">
                    <span>Campaigns</span>
                </div>
                <div class="card" id="analytics-card" data-name="analytics">
                    <img src="/home-page/images/analytics.png" alt="Analytics">
                    <span>Analytics</span>
                </div>
            `;
            applyCardStyles(gridContainer);
            performSearch();
        });

        // Event listener untuk card "Procurement & Exim"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#procurement')) {
                hideAllButtons();
                showButtons(homeButton, procurementButton);

                gridContainer.innerHTML = `
                    <div class="card" id="procurement-card" data-name="procurement">
                        <img src="/home-page/images/procurement.png" alt="Procurement">
                        <span>Procurement</span>
                    </div>
                    <a href="{{ route('exim') }}" style="text-decoration: none;">
                        <div class="card" id="exim-card" data-name="exim">
                            <img src="{{ asset('home-page/images/exim.png') }}" alt="Exim">
                            <span>Exim</span>
                        </div>
                    </a>
                `;
                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk card "Procurement"
        document.addEventListener('click', (event) => {
            if (event.target.closest('#procurement-card')) {
                hideAllButtons();
                showButtons(homeButton, procurementButton);

                gridContainer.innerHTML = `
                    <a href="{{ route('procurement.kpi') }}">                    
                        <div class="card" data-name="dashboard">
                            <img src="/home-page/images/dashboard.png" alt="Dashboard">
                            <span>Dashboard</span>
                        </div>
                    </a>

                    <a href="{{ route('procurement.dashboard') }}" style="text-decoration: none;">
                        <div class="card" id="data-management" data-name="data-management">
                            <img src="{{ asset('home-page/images/monitoring.png') }}" alt="Data Management">
                            <span>Data Management</span>
                        </div>
                    </a>
                `;
                applyCardStyles(gridContainer);
                performSearch();
            }
        });

        // Event listener untuk tombol Home
        homeButton.addEventListener('click', () => {
            hideAllButtons();
            showButtons(homeButton);

            gridContainer.innerHTML = initialGridHTML;
            applyCardStyles(gridContainer);
            performSearch();
        });

        // Fungsi untuk menampilkan tombol yang relevan
        function showButtons(...buttons) {
            buttons.forEach(button => button.classList.remove('hidden'));
        }

        // Tambahkan event listener untuk search bar
        searchBar.addEventListener('input', performSearch);
    </script>

    <!-- sweetalert logout  -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const logoutButtonHeader = document.getElementById("logout-button-header");
            const logoutFormHeader = document.getElementById("logout-form-header");

            logoutButtonHeader.addEventListener("click", function (event) {
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
                        logoutFormHeader.submit(); // Kirim form logout jika dikonfirmasi
                    }
                });
            });
        });
    </script>

    <!-- sweetalert after login -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Welcome',
                text: '{{ session('success') }}',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        </script>
    @endif

    <!-- SweetAlert for password change -->
    @if(session('password_change_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Password Changed',
                text: '{{ session('password_change_success') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <!-- SweetAlert untuk error umum -->
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <!-- confirm ganti password -->
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

            // Tampilkan SweetAlert untuk konfirmasi
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





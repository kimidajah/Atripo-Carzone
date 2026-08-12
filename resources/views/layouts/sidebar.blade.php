@php
    $user = Auth::user();
    $role = $user ? $user->role : null;
    $currentRoute = Route::currentRouteName();
@endphp

<nav class="sidebar d-flex flex-column flex-shrink-0 p-3">
    <!-- Brand Logo Area -->
    <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none px-2 py-1">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Atripo Carzone" class="me-2" style="height: 42px; width: auto; object-fit: contain;">
        <div class="lh-sm">
            <span class="fs-5 fw-extrabold tracking-tight text-dark">ATRIPO</span>
            <span class="fs-5 fw-extrabold text-warning">CARZONE</span>
            <div class="text-muted" style="font-size: 0.625rem; letter-spacing: 0.8px; font-weight: 600;">SHOWROOM MOBIL BEKAS</div>
        </div>
    </a>

    <hr class="my-3 text-muted opacity-25">

    <ul class="nav nav-pills flex-column mb-auto">
        <!-- Dashboard (Both Admin & Owner) -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ $currentRoute == 'dashboard' ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if($role === 'admin')
            <!-- ADMIN MENU STRUCTURE -->
            <li class="nav-header">Master Data</li>
            <li class="nav-item">
                <a href="{{ route('cars.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'cars.') ? 'active' : '' }}">
                    <i class="bi bi-car-front"></i>
                    <span>Data Mobil</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customers.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'customers.') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Data Pelanggan</span>
                </a>
            </li>

            <li class="nav-header">Transaksi</li>
            <li class="nav-item">
                <a href="{{ route('sales.create') }}" class="nav-link {{ $currentRoute == 'sales.create' ? 'active' : '' }}">
                    <i class="bi bi-cart-plus"></i>
                    <span>Penjualan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sales.index') }}" class="nav-link {{ $currentRoute == 'sales.index' || $currentRoute == 'sales.show' ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat Penjualan</span>
                </a>
            </li>

            <li class="nav-header">Persediaan</li>
            <li class="nav-item">
                <a href="{{ route('inventory.index') }}" class="nav-link {{ $currentRoute == 'inventory.index' ? 'active' : '' }}">
                    <i class="bi bi-boxes"></i>
                    <span>Stok Mobil</span>
                </a>
            </li>

            <li class="nav-header">Laporan</li>
            <li class="nav-item">
                <a href="{{ route('reports.sales') }}" class="nav-link {{ $currentRoute == 'reports.sales' ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Laporan Penjualan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reports.inventory') }}" class="nav-link {{ $currentRoute == 'reports.inventory' ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                    <span>Laporan Persediaan</span>
                </a>
            </li>
        @elseif($role === 'owner')
            <!-- PEMILIK MENU STRUCTURE -->
            <li class="nav-header">Data</li>
            <li class="nav-item">
                <a href="{{ route('cars.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'cars.') ? 'active' : '' }}">
                    <i class="bi bi-car-front"></i>
                    <span>Data Mobil</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customers.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'customers.') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Data Pelanggan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sales.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'sales.') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat Penjualan</span>
                </a>
            </li>

            <li class="nav-header">Persediaan</li>
            <li class="nav-item">
                <a href="{{ route('inventory.index') }}" class="nav-link {{ $currentRoute == 'inventory.index' ? 'active' : '' }}">
                    <i class="bi bi-boxes"></i>
                    <span>Stok Mobil</span>
                </a>
            </li>

            <li class="nav-header">Laporan</li>
            <li class="nav-item">
                <a href="{{ route('reports.sales') }}" class="nav-link {{ $currentRoute == 'reports.sales' ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Laporan Penjualan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reports.inventory') }}" class="nav-link {{ $currentRoute == 'reports.inventory' ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                    <span>Laporan Persediaan</span>
                </a>
            </li>
        @endif

        <li class="nav-header">Akun</li>
        <li class="nav-item">
            <a href="{{ route('profile.show') }}" class="nav-link {{ $currentRoute == 'profile.show' ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profil</span>
            </a>
        </li>
    </ul>

    <hr class="my-3 text-muted opacity-25">

    <div class="px-1">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 text-start d-flex align-items-center btn-sm px-3 py-2 rounded-3">
                <i class="bi bi-box-arrow-right me-2"></i>
                <span class="fw-semibold">Logout</span>
            </button>
        </form>
    </div>
</nav>

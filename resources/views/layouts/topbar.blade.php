@php
    $user = Auth::user();
@endphp

<header class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <!-- Sidebar Toggle Button for Mobile -->
        <button class="btn btn-sm btn-light border d-md-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
            <i class="bi bi-list fs-5"></i>
        </button>
        <h5 class="mb-0 fw-bold d-none d-sm-flex align-items-center text-dark">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Atripo Carzone" class="me-2" style="height: 30px; width: auto; object-fit: contain;">
            <span>ATRIPO <span class="brand-accent">CARZONE</span></span>
            <small class="text-muted fs-6 fw-normal d-none d-md-inline ms-2">| System Informasi Penjualan & Persediaan</small>
        </h5>
    </div>

    <div class="d-flex align-items-center gap-3">
        <!-- User Badge & Info -->
        <div class="text-end d-none d-sm-block">
            <div class="fw-semibold text-dark mb-0 fs-6">{{ $user->name }}</div>
            <div class="d-flex justify-content-end align-items-center gap-1">
                @if($user->isAdmin())
                    <span class="badge badge-role-admin px-2 py-1" style="font-size: 0.7rem;">ADMIN</span>
                @else
                    <span class="badge badge-role-owner px-2 py-1" style="font-size: 0.7rem;">PEMILIK</span>
                @endif
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold me-1" style="width: 38px; height: 38px; border: 2px solid #FAA87D;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="dropdownUser">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-bold">{{ $user->name }}</div>
                    <small class="text-muted">{{ $user->email }}</small>
                </li>
                <li>
                    <a class="dropdown-menu-item dropdown-item d-flex align-items-center py-2" href="{{ route('profile.show') }}">
                        <i class="bi bi-person me-2 text-warning"></i> Profil Saya
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center py-2">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

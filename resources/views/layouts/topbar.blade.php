@php
    $user = Auth::user();
@endphp

<header class="topbar d-flex justify-content-between align-items-center px-3 py-2 px-md-4 py-md-3">
    <div class="d-flex align-items-center">
        <!-- Sidebar Toggle Button for Mobile -->
        <button class="btn btn-gold btn-sidebar-toggle d-md-none me-2 me-sm-3 d-flex align-items-center justify-content-center" 
                type="button" 
                id="mobileSidebarToggle"
                data-bs-toggle="offcanvas" 
                data-bs-target="#mobileSidebar" 
                aria-controls="mobileSidebar" 
                aria-label="Buka Menu Sidebar" 
                style="width: 42px; height: 42px; padding: 0; min-width: 42px; cursor: pointer; position: relative; z-index: 100;">
            <i class="bi bi-list fs-2" style="pointer-events: none;"></i>
        </button>
        
        <!-- Brand Title for Mobile & Desktop -->
        <h5 class="mb-0 fw-bold d-flex align-items-center text-dark">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Atripo Carzone" class="me-2 d-none d-sm-inline-block" style="height: 30px; width: auto; object-fit: contain;">
            <span class="fs-6 fs-sm-5 fw-extrabold">ATRIPO <span class="brand-accent">CARZONE</span></span>
            <small class="text-muted fs-6 fw-normal d-none d-md-inline ms-2">| Sistem Informasi Penjualan & Persediaan</small>
        </h5>
    </div>

    <div class="d-flex align-items-center gap-2 gap-sm-3">
        <!-- User Badge & Info -->
        <div class="text-end d-none d-sm-block">
            <div class="fw-semibold text-dark mb-0 fs-6">{{ $user->name }}</div>
            <div class="d-flex justify-content-end align-items-center gap-1">
                @if($user->role === 'admin')
                    <span class="badge badge-role-admin px-2 py-1" style="font-size: 0.7rem;">ADMIN</span>
                @elseif($user->role === 'marketing')
                    <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 0.7rem;">MARKETING</span>
                @elseif($user->role === 'pengelola')
                    <span class="badge bg-success text-white px-2 py-1" style="font-size: 0.7rem;">PENGELOLA</span>
                @else
                    <span class="badge badge-role-owner px-2 py-1" style="font-size: 0.7rem;">PEMILIK</span>
                @endif
            </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 38px; height: 38px; border: 2px solid #FAA87D;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="dropdownUser">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                    <small class="text-muted d-block text-truncate" style="max-width: 200px;">{{ $user->email }}</small>
                    <span class="badge {{ $user->isAdmin() ? 'badge-role-admin' : ($user->isMarketing() ? 'bg-warning text-dark' : ($user->isPengelola() ? 'bg-success text-white' : 'badge-role-owner')) }} mt-1" style="font-size: 0.65rem;">
                        {{ strtoupper($user->role) }}
                    </span>
                </li>
                <li>
                    <a class="dropdown-menu-item dropdown-item d-flex align-items-center py-2" href="{{ route('profile.show') }}">
                        <i class="bi bi-person me-2 text-warning"></i> Profil Saya
                    </a>
                </li>
                <li>
                    <a class="dropdown-menu-item dropdown-item d-flex align-items-center py-2" href="{{ route('welcome') }}" target="_blank">
                        <i class="bi bi-globe me-2 text-warning"></i> Lihat Welcome Page
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
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

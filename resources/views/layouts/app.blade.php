<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - ATRIPO CARZONE Showroom Mobil Bekas</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom Gold/Dark Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Mobile Sidebar Offcanvas (Placed at top-level under body for backdrop & touch reliability) -->
    <div class="offcanvas offcanvas-start border-0 shadow" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="width: 290px;">
        <div class="offcanvas-header bg-white border-bottom py-3 px-3">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Atripo Carzone" class="me-2" style="height: 32px; width: auto; object-fit: contain;">
                <h5 class="offcanvas-title text-dark fw-extrabold mb-0" id="mobileSidebarLabel">
                    ATRIPO <span class="text-warning">CARZONE</span>
                </h5>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Tutup Menu"></button>
        </div>
        <div class="offcanvas-body p-0 bg-white">
            @include('layouts.sidebar')
        </div>
    </div>

    <div class="d-flex min-vh-100">
        <!-- Desktop Sidebar -->
        <div class="d-none d-md-block flex-shrink-0">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content Area -->
        <div class="flex-grow-1 d-flex flex-column main-content min-vh-100 bg-light">
            @include('layouts.topbar')

            <main class="container-fluid px-3 py-3 p-md-4 flex-grow-1">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <strong>[✓] {{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <strong>[✕] {{ session('error') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                        <strong>[!] {{ session('warning') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-top py-3 text-muted fs-7 d-print-none mt-auto">
                <div class="container-fluid px-3 px-md-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 text-center text-sm-start">
                        <div>
                            &copy; {{ date('Y') }} <strong class="text-dark fw-bold">ATRIPO CARZONE</strong>. Hak Cipta Dilindungi.
                        </div>
                        <div class="small text-muted">
                            <i class="bi bi-geo-alt-fill text-warning me-1"></i> Showroom Mobil Bekas &bull; Cileunyi, Bandung
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS Bundle (Local asset with CDN fallback) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        if (typeof bootstrap === 'undefined') {
            document.write('<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/bootstrap.bundle.min.js"><\/script>');
        }
    </script>

    <!-- Dedicated Mobile Sidebar Controller -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarEl = document.getElementById('mobileSidebar');

            // Close offcanvas when clicking nav links inside mobile sidebar
            if (sidebarEl) {
                sidebarEl.querySelectorAll('a.nav-link').forEach(function (link) {
                    link.addEventListener('click', function () {
                        if (window.bootstrap && window.bootstrap.Offcanvas) {
                            const inst = window.bootstrap.Offcanvas.getInstance(sidebarEl);
                            if (inst) inst.hide();
                        }
                    });
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

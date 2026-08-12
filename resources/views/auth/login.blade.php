<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ATRIPO CARZONE Showroom Mobil Bekas</title>
    
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
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
            background-color: var(--theme-color-3, #FFFEE3);
            color: #212529;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Ambient Background Glow Blobs */
        .bg-glow-1 {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(250, 168, 125, 0.45) 0%, rgba(255, 254, 227, 0) 70%);
            top: -140px;
            left: -140px;
            animation: ambientFloat 12s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
        }

        .bg-glow-2 {
            position: absolute;
            width: 550px;
            height: 550px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(207, 232, 255, 0.6) 0%, rgba(255, 254, 227, 0) 70%);
            bottom: -160px;
            right: -160px;
            animation: ambientFloat 15s ease-in-out infinite reverse;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes ambientFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(40px, -30px) scale(1.1); }
        }

        /* Background Animated Road & Moving Cars (Positioned directly behind card) */
        .road-container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 2;
        }

        .road-line {
            position: absolute;
            bottom: 40%;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(250, 168, 125, 0.5) 15%, 
                rgba(224, 118, 56, 0.9) 50%, 
                rgba(250, 168, 125, 0.5) 85%, 
                transparent 100%);
            box-shadow: 0 0 20px rgba(224, 118, 56, 0.8);
        }

        .road-line-lower {
            bottom: 27%;
            opacity: 0.6;
        }

        .moving-car {
            position: absolute;
            width: 210px;
            height: auto;
            will-change: transform, opacity;
        }

        /* Pickup Truck Animation (White Hilux Double-Cab) - Upper Lane */
        .car-truck {
            animation: driveTruckLeftToRight 12s linear infinite;
            bottom: 39%;
            width: 235px;
            z-index: 2;
        }

        /* Yellow Rocky SUV Animation (Yellow Daihatsu Rocky SUV) - Lower Lane */
        .car-suv {
            animation: driveTruckLeftToRight 12s linear infinite -6s;
            bottom: 26%;
            width: 220px;
            z-index: 3;
        }

        .car-img {
            width: 100%;
            height: auto;
            filter: drop-shadow(0 8px 15px rgba(0, 0, 0, 0.35));
        }

        .headlight-beam-truck {
            position: absolute;
            right: -100px;
            bottom: 12px;
            width: 130px;
            height: 45px;
            background: linear-gradient(90deg, rgba(255, 254, 227, 0.95) 0%, rgba(255, 254, 227, 0) 100%);
            clip-path: polygon(0 35%, 100% 0, 100% 100%, 0 65%);
            pointer-events: none;
            filter: blur(2px);
        }

        @keyframes driveTruckLeftToRight {
            0% {
                transform: translateX(-280px) translateY(24px);
                opacity: 0;
            }
            4% {
                opacity: 1;
            }
            96% {
                opacity: 1;
            }
            100% {
                transform: translateX(calc(100vw + 280px)) translateY(24px);
                opacity: 0;
            }
        }

        /* Speed Trail Effect */
        .speed-trail {
            position: absolute;
            left: -70px;
            bottom: 16px;
            width: 80px;
            height: 10px;
            background: linear-gradient(90deg, rgba(250, 168, 125, 0) 0%, rgba(224, 118, 56, 0.8) 100%);
            border-radius: 5px;
            filter: blur(3px);
        }

        /* ULTRA-REALISTIC FROSTED GLASS LOGIN CARD (KACA BURAM SEHINGGA MOBIL TERLIHAT) */
        .login-card {
            background: rgba(255, 255, 255, 0.28) !important;
            backdrop-filter: blur(6px) saturate(160%);
            -webkit-backdrop-filter: blur(6px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.7) !important;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 1rem 3rem rgba(250, 168, 125, 0.25), inset 0 1px 0 0 rgba(255, 255, 255, 0.8);
            max-width: 960px;
            width: 100%;
            position: relative;
            z-index: 10;
            animation: cardEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(35px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-brand-panel {
            background: linear-gradient(135deg, rgba(255, 245, 235, 0.35) 0%, rgba(254, 217, 179, 0.45) 100%) !important;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            color: #212529;
            padding: 3.5rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            border-right: 3px solid rgba(250, 168, 125, 0.85);
        }

        .login-form-panel {
            background: rgba(255, 255, 255, 0.38) !important;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            padding: 3.5rem 3rem;
        }

        .gold-divider {
            height: 4px;
            width: 60px;
            background: #E07638;
            margin: 1.5rem 0;
            border-radius: 2px;
            animation: expandWidth 1s cubic-bezier(0.16, 1, 0.3, 1) 0.3s both;
        }

        @keyframes expandWidth {
            from { width: 0; opacity: 0; }
            to { width: 60px; opacity: 1; }
        }

        .location-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(250, 168, 125, 0.7);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .location-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(250, 168, 125, 0.3);
            background: rgba(255, 255, 255, 0.85);
        }

        /* Floating Interactive Live Badges */
        .floating-badge {
            position: absolute;
            z-index: 15;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(250, 168, 125, 0.6);
            padding: 0.5rem 1rem;
            border-radius: 50rem;
            font-size: 0.825rem;
            font-weight: 700;
            color: #212529;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            animation: floatBadge 5s ease-in-out infinite;
        }

        .badge-top-left {
            top: 20px;
            left: 30px;
            animation-delay: 0s;
        }

        .badge-bottom-right {
            bottom: 25px;
            right: 30px;
            animation-delay: 2.5s;
        }

        @keyframes floatBadge {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-7px); }
        }

        /* Floating Logo Animation */
        .brand-logo-img {
            animation: logoFloat 4s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* Staggered Element Entrance Animations */
        @keyframes fadeInElement {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-step-1 { animation: fadeInElement 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both; }
        .animate-step-2 { animation: fadeInElement 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.35s both; }
        .animate-step-3 { animation: fadeInElement 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.5s both; }
        .animate-step-4 { animation: fadeInElement 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.65s both; }

        /* Translucent Input Focus Animations */
        .form-control, .input-group-text {
            background-color: rgba(255, 255, 255, 0.55) !important;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(250, 168, 125, 0.4);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .input-group:focus-within .input-group-text {
            border-color: #E07638 !important;
            color: #E07638 !important;
            background-color: rgba(255, 245, 237, 0.95) !important;
        }

        .input-group:focus-within .form-control {
            border-color: #E07638 !important;
            box-shadow: 0 0 0 0.25rem rgba(250, 168, 125, 0.3) !important;
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        /* Interactive Button Hover & Press Animation */
        .btn-gold {
            background: linear-gradient(135deg, #FAA87D 0%, #E07638 100%);
            color: #FFFFFF;
            font-weight: 700;
            border: none;
            box-shadow: 0 4px 14px rgba(224, 118, 56, 0.45);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(224, 118, 56, 0.55);
            color: #FFFFFF;
        }

        .btn-gold:active {
            transform: translateY(0) scale(0.98);
        }
    </style>
</head>
<body>
    <!-- Background Ambient Glow Blobs -->
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    <!-- Floating Live Badges -->
    <div class="floating-badge badge-top-left d-none d-md-flex align-items-center">
        <i class="bi bi-shield-check text-warning me-2 fs-6"></i>
        <span>Showroom Mobil Bekas Terpercaya</span>
    </div>
    <div class="floating-badge badge-bottom-right d-none d-md-flex align-items-center">
        <i class="bi bi-car-front-fill text-success me-2 fs-6"></i>
        <span>Unit Armada Siap Jual</span>
    </div>

    <!-- Background Animated Road & Moving Cars (Visible through Frosted Glass) -->
    <div class="road-container">
        <div class="road-line"></div>
        <div class="road-line road-line-lower"></div>
        
        <!-- Moving Car 1: White Pickup Truck (User Image 1) -->
        <div class="moving-car car-truck">
            <div class="headlight-beam-truck"></div>
            <div class="speed-trail"></div>
            <img src="{{ asset('images/pickup-truck.png') }}" alt="Pickup Truck Moving" class="car-img">
        </div>

        <!-- Moving Car 2: Yellow Daihatsu Rocky SUV (User Image 2 - Staggered Loop) -->
        <div class="moving-car car-suv">
            <div class="headlight-beam-truck"></div>
            <div class="speed-trail"></div>
            <img src="{{ asset('images/yellow-suv.png') }}" alt="Yellow SUV Moving" class="car-img">
        </div>
    </div>

    <div class="container py-4">
        <!-- Frosted Glass Login Card -->
        <div class="card login-card mx-auto">
            <div class="row g-0">
                <!-- Left Panel: Branding & Showroom Visual -->
                <div class="col-lg-6 login-brand-panel d-none d-lg-flex">
                    <div>
                        <div class="d-flex align-items-center mb-3 animate-step-1">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Atripo Carzone" class="me-3 brand-logo-img" style="height: 60px; width: auto; object-fit: contain;">
                            <div>
                                <h2 class="fw-extrabold mb-0 tracking-tight text-dark">ATRIPO <span class="text-warning">CARZONE</span></h2>
                                <p class="text-warning-50 mb-0 small fw-semibold text-uppercase" style="letter-spacing: 1px;">Showroom Mobil Bekas</p>
                            </div>
                        </div>

                        <div class="gold-divider"></div>

                        <h4 class="fw-bold mb-3 text-dark animate-step-2">Sistem Informasi Penjualan & Persediaan</h4>
                        <p class="text-muted leading-relaxed animate-step-3" style="font-size: 0.95rem;">
                            Platform internal terpusat untuk pengelolaan persediaan armada kendaraan, pencatatan transaksi penjualan, dan pembuatan laporan operasional di Showroom Atripo Carzone Cileunyi, Bandung.
                        </p>
                    </div>

                    <div class="mt-5 animate-step-4">
                        <div class="p-3 rounded-3 location-card">
                            <div class="d-flex align-items-center small">
                                <i class="bi bi-geo-alt-fill text-warning me-2 fs-5"></i>
                                <div>
                                    <div class="fw-bold">Lokasi Showroom:</div>
                                    <div class="text-muted">Cileunyi, Kabupaten Bandung, Jawa Barat</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Login Form -->
                <div class="col-lg-6 login-form-panel">
                    <div class="mb-4 animate-step-1">
                        <div class="d-lg-none mb-3 text-center">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Atripo Carzone" class="mb-2 brand-logo-img" style="height: 55px; width: auto;">
                            <h3 class="fw-bold mb-0">ATRIPO <span class="text-warning">CARZONE</span></h3>
                            <p class="text-muted small">Showroom Mobil Bekas Cileunyi</p>
                        </div>

                        <h3 class="fw-bold text-dark mb-1">Selamat Datang</h3>
                        <p class="text-muted small">Silakan masuk ke akun internal Anda</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 small mb-4 animate-step-2" role="alert">
                            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 small mb-4 animate-step-2" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3 animate-step-2">
                            <label for="login" class="form-label fw-semibold text-secondary small">Username atau Email</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 @error('login') is-invalid @enderror" id="login" name="login" value="{{ old('login') }}" placeholder="Masukkan username atau email" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4 animate-step-3">
                            <label for="password" class="form-label fw-semibold text-secondary small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4 animate-step-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted small" for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="animate-step-4">
                            <button type="submit" class="btn btn-gold w-100 py-2.5 rounded-3 fw-bold text-uppercase tracking-wider">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Login Masuk
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 pt-3 border-top text-center text-muted animate-step-4" style="font-size: 0.8rem;">
                        <i class="bi bi-shield-lock-fill text-warning me-1"></i> Sistem Informasi Internal Atripo Carzone
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/bootstrap.bundle.min.js"></script>
</body>
</html>

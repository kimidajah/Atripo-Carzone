<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Showroom Atripo Carzone Cileunyi Bandung - Jual Beli Mobil Bekas Berkualitas, Siap Pakai, Garansi Terpercaya dengan Pembayaran Cash & Kredit Ringan.">
    <title>Atripo Carzone - Showroom Mobil Bekas Berkualitas Cileunyi Bandung</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* Welcome Public Page - LIGHT / CERAH THEME */
        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--theme-color-3, #FFFEE3);
            color: #212529;
            overflow-x: hidden;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* Glassmorphism Light Navbar */
        .welcome-navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(250, 168, 125, 0.3);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            z-index: 9999 !important;
        }

        .welcome-navbar .navbar-toggler {
            z-index: 10000 !important;
            cursor: pointer !important;
            pointer-events: auto !important;
            padding: 0.5rem 0.75rem;
            background-color: var(--theme-color-2, #FED9B3) !important;
            border: 1px solid var(--theme-color-1, #FAA87D) !important;
            border-radius: 8px;
        }

        .welcome-navbar .navbar-toggler:focus, 
        .welcome-navbar .navbar-toggler:active {
            box-shadow: 0 0 0 0.25rem rgba(250, 168, 125, 0.4) !important;
            outline: none !important;
        }

        @media (max-width: 991.98px) {
            .welcome-navbar .navbar-collapse {
                background: #FFFFFF;
                padding: 1.25rem;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
                margin-top: 0.75rem;
                border: 1px solid rgba(250, 168, 125, 0.4);
            }
        }

        /* Hero Section Styling (Light & Warm Palette) */
        .hero-section {
            position: relative;
            padding: 140px 0 90px 0;
            background: radial-gradient(circle at 50% 20%, #FFF5EB 0%, var(--theme-color-3, #FFFEE3) 70%);
            overflow: hidden;
        }

        .hero-title {
            font-size: 3.25rem;
            font-weight: 900;
            line-height: 1.15;
            color: #1A202C;
        }

        .hero-title .highlight {
            color: #E07638;
            background: linear-gradient(135deg, #E07638 0%, #FAA87D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.15rem;
            color: #4A5568;
            max-width: 680px;
            margin: 0 auto;
        }

        /* Light Card Search Glow */
        .search-card-glow {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(250, 168, 125, 0.5);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(250, 168, 125, 0.15), 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        /* Car Card Showcase Styling (Light Mode) */
        .car-card-public {
            background: #FFFFFF;
            border: 1px solid rgba(254, 217, 179, 0.6);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
        }

        .car-card-public:hover {
            transform: translateY(-8px);
            border-color: #FAA87D;
            box-shadow: 0 15px 30px rgba(250, 168, 125, 0.28), 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .car-card-public .img-container {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: #F8FAFC;
        }

        .car-card-public .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .car-card-public:hover .img-container img {
            transform: scale(1.08);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 0 15px rgba(250, 168, 125, 0.3);
            }
            50% {
                box-shadow: 0 0 30px rgba(250, 168, 125, 0.6);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.8s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
        }

        .animate-pulse {
            animation: pulseGlow 3s infinite ease-in-out;
        }

        /* Light Feature Card */
        .feature-card {
            background: #FFFFFF;
            border: 1px solid rgba(254, 217, 179, 0.6);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            background: #FFFDF8;
            border-color: #E07638;
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(250, 168, 125, 0.25);
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: var(--theme-color-2, #FED9B3);
            color: #E07638;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 1.25rem;
        }

        /* Brand Tab Buttons (Light) */
        .brand-tab-btn {
            background: #FFFFFF;
            color: #4A5568;
            border: 1px solid rgba(250, 168, 125, 0.5);
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.25s ease;
        }

        .brand-tab-btn:hover, .brand-tab-btn.active {
            background: var(--theme-color-1, #FAA87D);
            color: #212529;
            border-color: #FAA87D;
            box-shadow: 0 4px 15px rgba(250, 168, 125, 0.35);
        }

        @media (max-width: 767.98px) {
            .hero-title {
                font-size: 2.1rem;
            }
            .hero-section {
                padding: 100px 0 60px 0;
            }
        }
    </style>
</head>
<body>

    <!-- ==================== NAVBAR CERAH ==================== -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top welcome-navbar py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center me-4" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Atripo Carzone" class="me-2" style="height: 38px; width: auto;">
                <span class="fw-extrabold text-dark fs-4">ATRIPO <span class="brand-accent">CARZONE</span></span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarWelcomeContent" aria-controls="navbarWelcomeContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarWelcomeContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link text-dark me-2" href="#hero">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark me-2" href="#katalog">Mobil Tersedia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark me-2" href="#simulasi">Simulasi Kredit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark me-2" href="#keunggulan">Keunggulan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#kontak">Kontak & Lokasi</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-gold px-4 py-2 d-flex align-items-center shadow-sm w-100 w-lg-auto justify-content-center">
                            <i class="bi bi-speedometer2 me-2"></i> Ke Dashboard ({{ strtoupper(Auth::user()->role) }})
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-gold px-4 py-2 d-flex align-items-center w-100 w-lg-auto justify-content-center">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Sistem
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== HERO SECTION (TEMA CERAH) ==================== -->
    <section id="hero" class="hero-section text-center">
        <div class="container position-relative z-2">
            <!-- Badge Top -->
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white border border-warning text-dark shadow-sm mb-4 animate-pulse">
                <i class="bi bi-star-fill text-warning"></i>
                <span class="small fw-bold font-monospace">SHOWROOM MOBIL BEKAS TERPERCAYA CILEUNYI</span>
            </div>

            <!-- Headline Cerah -->
            <h1 class="hero-title mb-3 animate-fade-in">
                Temukan Mobil Bekas Impian<br><span class="highlight">Siap Pakai & Garansi Terjamin</span>
            </h1>

            <p class="hero-subtitle mb-5 animate-fade-in" style="animation-delay: 0.2s;">
                Koleksi unit kendaraan bekas berkualitas tinggi. Bebas banjir, bebas tabrakan, inspeksi 150+ titik dengan pilihan skema pembayaran <strong class="text-dark">Cash & Kredit DP Ringan</strong>.
            </p>

            <!-- Search Form Card -->
            <div class="search-card-glow p-3 p-md-4 mb-5 text-start animate-fade-in" style="max-width: 920px; margin: 0 auto; animation-delay: 0.3s;">
                <form action="{{ route('welcome') }}#katalog" method="GET" class="row g-2 align-items-end">
                    <div class="col-12 col-md-5">
                        <label class="form-label small text-muted fw-semibold mb-1"><i class="bi bi-search me-1"></i> Cari Merek / Tipe / Nopol</label>
                        <input type="text" name="search" class="form-control bg-light text-dark border-secondary border-opacity-25 py-2.5" placeholder="Contoh: Avanza, Civic, Pajero..." value="{{ request('search') }}">
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label small text-muted fw-semibold mb-1"><i class="bi bi-tag me-1"></i> Pilih Merek</label>
                        <select name="brand" class="form-select bg-light text-dark border-secondary border-opacity-25 py-2.5">
                            <option value="all">Semua Merek</option>
                            @foreach($brands as $b)
                                <option value="{{ $b }}" {{ request('brand') == $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 col-md-4">
                        <button type="submit" class="btn btn-gold w-100 py-2.5 d-flex align-items-center justify-content-center fs-6">
                            <i class="bi bi-search me-2"></i> Cari Mobil Tersedia
                        </button>
                    </div>
                </form>
            </div>

            <!-- Stats Bar -->
            <div class="row g-3 justify-content-center text-center animate-fade-in" style="animation-delay: 0.4s; max-width: 800px; margin: 0 auto;">
                <div class="col-4 col-md-4">
                    <div class="p-3 border border-warning border-opacity-50 rounded-3 bg-white shadow-sm">
                        <h3 class="fw-extrabold text-warning mb-0 fs-2">{{ $totalAvailable }}</h3>
                        <small class="text-muted fw-semibold">Mobil Ready (Tersedia)</small>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="p-3 border border-success border-opacity-50 rounded-3 bg-white shadow-sm">
                        <h3 class="fw-extrabold text-success mb-0 fs-2">100%</h3>
                        <small class="text-muted fw-semibold">Surat & Dokumen Legal</small>
                    </div>
                </div>
                <div class="col-4 col-md-4">
                    <div class="p-3 border border-info border-opacity-50 rounded-3 bg-white shadow-sm">
                        <h3 class="fw-extrabold text-primary mb-0 fs-2">DP 10%</h3>
                        <small class="text-muted fw-semibold">Skema Kredit Ringan</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== KATALOG MOBIL TERSEDIA (TEMA CERAH) ==================== -->
    <section id="katalog" class="py-5" style="background: #FFFFFF;">
        <div class="container py-4">
            <div class="text-center mb-4">
                <span class="badge bg-warning bg-opacity-20 text-dark border border-warning px-3 py-1.5 mb-2 font-monospace">UNIT READY STOK</span>
                <h2 class="fw-extrabold text-dark display-6">Armada Mobil Tersedia</h2>
                <p class="text-muted">Menampilkan daftar unit mobil bekas yang siap Anda survey dan bawa pulang</p>
            </div>

            <!-- Brand Filter Tabs -->
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                <a href="{{ route('welcome') }}#katalog" class="brand-tab-btn {{ !request('brand') || request('brand') == 'all' ? 'active' : '' }}">
                    Semua Merek ({{ $totalAvailable }})
                </a>
                @foreach($brands as $b)
                    <a href="{{ route('welcome', ['brand' => $b]) }}#katalog" class="brand-tab-btn {{ request('brand') == $b ? 'active' : '' }}">
                        {{ $b }}
                    </a>
                @endforeach
            </div>

            <!-- Car Cards Grid (Light Mode) -->
            <div class="row g-4">
                @forelse($cars as $car)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="car-card-public h-100 d-flex flex-column justify-content-between">
                            <!-- Image Box -->
                            <div class="img-container">
                                @if($car->image && Storage::disk('public')->exists($car->image))
                                    <img src="{{ asset('uploads/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model_type }}">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted bg-light">
                                        <i class="bi bi-car-front display-4 text-warning opacity-75"></i>
                                        <span class="small text-muted mt-1">ATRIPO CARZONE</span>
                                    </div>
                                @endif

                                <!-- Status Badge Overlay -->
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge badge-available shadow-sm px-2.5 py-1.5"><i class="bi bi-check-circle-fill me-1"></i> TERSEDIA</span>
                                </div>

                                <!-- Year Badge Overlay -->
                                <div class="position-absolute bottom-0 start-0 m-2">
                                    <span class="badge bg-dark text-white font-monospace border border-secondary">{{ $car->year }}</span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                                <div>
                                    <div class="small text-warning text-uppercase fw-bold font-monospace">{{ $car->brand }}</div>
                                    <h5 class="fw-bold text-dark mb-2 text-truncate" title="{{ $car->model_type }}">{{ $car->model_type }}</h5>
                                    
                                    <div class="fw-extrabold text-warning fs-4 mb-3">{{ $car->formatted_price }}</div>

                                    <div class="row g-2 text-muted small border-top pt-2 mb-3">
                                        <div class="col-6">
                                            <i class="bi bi-gear-fill me-1 text-warning"></i> {{ $car->transmission }}
                                        </div>
                                        <div class="col-6">
                                            <i class="bi bi-palette-fill me-1 text-warning"></i> {{ $car->color }}
                                        </div>
                                        <div class="col-12 mt-1">
                                            <i class="bi bi-credit-card-2-front-fill me-1 text-warning"></i> Nopol: <span class="font-monospace text-dark fw-semibold">{{ $car->plate_number }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2 border-top pt-2">
                                    <button type="button" class="btn btn-outline-gold btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#carDetailModal{{ $car->id }}">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </button>
                                    <a href="https://wa.me/6281234567890?text=Halo%20Atripo%20Carzone,%20saya%20tertarik%20dengan%20mobil%20{{ urlencode($car->brand . ' ' . $car->model_type . ' (' . $car->plate_number . ')') }}" target="_blank" class="btn btn-gold btn-sm" title="Tanya via WA">
                                        <i class="bi bi-whatsapp"></i> WA
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Detail Mobil (Light Mode) -->
                        <div class="modal fade" id="carDetailModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content bg-white text-dark border-0 shadow-lg">
                                    <div class="modal-header bg-light border-bottom">
                                        <h5 class="modal-title fw-bold text-dark">{{ $car->brand }} {{ $car->model_type }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                @if($car->image && Storage::disk('public')->exists($car->image))
                                                    <img src="{{ asset('uploads/' . $car->image) }}" alt="{{ $car->brand }}" class="img-fluid rounded-3 border w-100" style="height: 250px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light text-dark p-5 rounded-3 d-flex flex-column align-items-center justify-content-center text-center h-100 border" style="min-height: 200px;">
                                                        <i class="bi bi-car-front display-1 text-warning mb-2"></i>
                                                        <span class="small text-muted">ATRIPO CARZONE</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <span class="badge badge-available mb-2">STATUS: TERSEDIA (READY)</span>
                                                <h3 class="fw-extrabold text-warning mb-3">{{ $car->formatted_price }}</h3>

                                                <div class="bg-light p-3 rounded-3 border mb-3">
                                                    <h6 class="fw-bold text-dark mb-2">Spesifikasi Kendaraan</h6>
                                                    <ul class="list-unstyled mb-0 small text-secondary">
                                                        <li class="mb-1"><i class="bi bi-calendar-event me-2 text-warning"></i> Tahun Produksi: <strong class="text-dark">{{ $car->year }}</strong></li>
                                                        <li class="mb-1"><i class="bi bi-gear-fill me-2 text-warning"></i> Transmisi: <strong class="text-dark">{{ $car->transmission }}</strong></li>
                                                        <li class="mb-1"><i class="bi bi-palette-fill me-2 text-warning"></i> Warna Bodi: <strong class="text-dark">{{ $car->color }}</strong></li>
                                                        <li class="mb-1"><i class="bi bi-credit-card-2-front-fill me-2 text-warning"></i> Nomor Polisi: <strong class="text-dark font-monospace">{{ $car->plate_number }}</strong></li>
                                                    </ul>
                                                </div>

                                                <!-- Estimasi Kredit Quick Preview -->
                                                <div class="p-3 bg-warning bg-opacity-10 border border-warning rounded-3 small">
                                                    <div class="fw-bold text-dark mb-1"><i class="bi bi-calculator me-1"></i> Estimasi Cicilan Kredit:</div>
                                                    <div class="text-muted">DP 20%: <strong class="text-dark">Rp {{ number_format($car->price * 0.20, 0, ',', '.') }}</strong></div>
                                                    <div class="text-muted">Angsuran (36 Bln): <strong class="text-warning fw-bold">Rp {{ number_format((($car->price * 0.80) + (($car->price * 0.80) * 0.10 * 3)) / 36, 0, ',', '.') }}/Bln</strong></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light border-top">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <a href="https://wa.me/6281234567890?text=Halo%20Atripo%20Carzone,%20saya%20ingin%20tanya%20detail%20dan%20skema%20kredit%20mobil%20{{ urlencode($car->brand . ' ' . $car->model_type . ' (' . $car->plate_number . ')') }}" target="_blank" class="btn btn-gold">
                                            <i class="bi bi-whatsapp me-1"></i> Hubungi Sales via WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted bg-light rounded-3 border">
                        <i class="bi bi-inbox display-4 d-block mb-3 text-warning"></i>
                        <h5>Belum Ada Mobil yang Sesuai Pilihan</h5>
                        <p class="small text-muted mb-0">Silakan ubah kata kunci pencarian atau pilih opsi semua merek.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ==================== INTERACTIVE CREDIT SIMULATOR (CERAH) ==================== -->
    <section id="simulasi" class="py-5" style="background: linear-gradient(135deg, #FFFEE3 0%, #FED9B3 100%);">
        <div class="container py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-5">
                    <span class="badge bg-white text-dark border border-warning fw-bold px-3 py-1.5 mb-2 font-monospace">SIMULASI ANGSURAN</span>
                    <h2 class="fw-extrabold text-dark display-6 mb-3">Hitung Estimasi Cicilan Kredit Anda</h2>
                    <p class="text-secondary mb-4">
                        Gunakan kalkulator simulasi di bawah ini untuk menghitung perkiraan Uang Muka (DP) dan Angsuran bulanan sesuai harga mobil pilihan Anda di Showroom Atripo Carzone.
                    </p>
                    <div class="d-flex flex-column gap-3 text-dark">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                            <span class="fw-semibold">Suku Bunga Flat Kompetitif per Tahun</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                            <span class="fw-semibold">Pilihan Tenor Fleksibel dari 12 hingga 60 Bulan</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                            <span class="fw-semibold">Persyaratan Dokumen Mudah (KTP, KK, Slip Gaji, NPWP)</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card border-0 shadow-lg p-4 p-md-5 rounded-4 bg-white">
                        <h4 class="fw-bold text-dark mb-4"><i class="bi bi-calculator-fill text-warning me-2"></i> Kalkulator Kredit Mobil</h4>
                        
                        <form id="creditSimForm" onsubmit="return false;">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label small text-muted fw-semibold">Harga Mobil (Rp)</label>
                                    <input type="number" id="simPrice" class="form-control bg-light text-dark border-secondary border-opacity-25" value="250000000" min="10000000" step="5000000">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label small text-muted fw-semibold">Uang Muka DP (%)</label>
                                    <input type="number" id="simDpPercent" class="form-control bg-light text-dark border-secondary border-opacity-25" value="20" min="10" max="80">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label small text-muted fw-semibold">Bunga (%/Thn)</label>
                                    <input type="number" id="simRate" class="form-control bg-light text-dark border-secondary border-opacity-25" value="10" min="1" max="30" step="0.5">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small text-muted fw-semibold">Tenor Cicilan (Bulan)</label>
                                    <select id="simTenor" class="form-select bg-light text-dark border-secondary border-opacity-25">
                                        <option value="12">12 Bulan (1 Tahun)</option>
                                        <option value="24">24 Bulan (2 Tahun)</option>
                                        <option value="36" selected>36 Bulan (3 Tahun)</option>
                                        <option value="48">48 Bulan (4 Tahun)</option>
                                        <option value="60">60 Bulan (5 Tahun)</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <div class="p-3 bg-warning bg-opacity-15 rounded-3 border border-warning mt-4 text-center">
                            <div class="text-muted small text-uppercase font-monospace mb-1 fw-bold">Perkiraan Angsuran Per Bulan</div>
                            <h2 id="simInstallmentResult" class="fw-extrabold text-warning mb-1 display-6">Rp 6.944.444</h2>
                            <div class="small text-muted" id="simDpResult">DP Nominal: Rp 50.000.000 (20%)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== KEUNGGULAN (CERAH) ==================== -->
    <section id="keunggulan" class="py-5" style="background: #FFFFFF;">
        <div class="container py-4 text-center">
            <span class="badge bg-warning bg-opacity-20 text-dark fw-bold px-3 py-1.5 mb-2 font-monospace">MENGAPA KAMI?</span>
            <h2 class="fw-extrabold text-dark display-6 mb-5">Keunggulan Atripo Carzone</h2>

            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="feature-card h-100 text-start">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Inspeksi 150+ Titik</h5>
                        <p class="text-muted small mb-0">Setiap mobil melewati uji kelayakan mesin, transmisi, sasis, serta dijamin bebas banjir dan tabrakan besar.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="feature-card h-100 text-start">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-check"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Surat & Dokumen Legitim</h5>
                        <p class="text-muted small mb-0">Keabsahan BPKB, STNK, dan Faktur terjamin 100% lengkap dan siap untuk proses balik nama kendaraan.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="feature-card h-100 text-start">
                        <div class="feature-icon">
                            <i class="bi bi-credit-card-2-front"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Kredit DP & Bunga Ringan</h5>
                        <p class="text-muted small mb-0">Bekerja sama dengan leasing terkemuka. Bantuan pengajuan berkas hingga di-approve dengan proses cepat.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="feature-card h-100 text-start">
                        <div class="feature-icon">
                            <i class="bi bi-tools"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Garansi Showroom</h5>
                        <p class="text-muted small mb-0">Jaminan garansi mesin & garansi kepuasan pelanggan untuk memastikan kenyamanan berkendara Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== KONTAK & LOKASI (CERAH) ==================== -->
    <section id="kontak" class="py-5" style="background: var(--theme-color-3, #FFFEE3);">
        <div class="container py-4">
            <div class="search-card-glow p-4 p-md-5">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="badge bg-warning bg-opacity-20 text-dark fw-bold px-3 py-1.5 mb-2 font-monospace">KUNJUNGI SHOWROOM</span>
                        <h3 class="fw-extrabold text-dark mb-3">Siap Menemukan Mobil Bekas Pilihan Anda?</h3>
                        <p class="text-muted mb-4">
                            Kunjungi lokasi showroom kami di Cileunyi Bandung untuk langsung melakukan cek fisik dan test drive kendaraan favorit Anda.
                        </p>

                        <div class="d-flex flex-column gap-2 text-dark mb-4">
                            <div><i class="bi bi-geo-alt-fill text-warning me-2"></i> <strong>Alamat:</strong> Jl. Raya Cileunyi, Kabupaten Bandung, Jawa Barat</div>
                            <div><i class="bi bi-clock-fill text-warning me-2"></i> <strong>Jam Operasional:</strong> Senin - Minggu (08:00 - 18:00 WIB)</div>
                            <div><i class="bi bi-telephone-fill text-warning me-2"></i> <strong>Telepon / WA:</strong> 0812-3456-7890</div>
                        </div>
                    </div>

                    <div class="col-lg-5 text-center text-lg-end">
                        <a href="https://wa.me/6281234567890?text=Halo%20Atripo%20Carzone,%20saya%20ingin%20tanya%20stok%20mobil%20yang%20tersedia" target="_blank" class="btn btn-gold btn-lg px-4 py-3 fw-bold shadow">
                            <i class="bi bi-whatsapp me-2 fs-5"></i> Hubungi Kami Via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER CERAH ==================== -->
    <footer class="py-4 border-top" style="background: #FFFFFF;">
        <div class="container text-center text-muted small">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div>
                    &copy; {{ date('Y') }} <strong class="text-dark">ATRIPO CARZONE SHOWROOM</strong>. Hak Cipta Dilindungi.
                </div>
                <div class="d-flex gap-3">
                    <a href="#hero" class="text-muted text-decoration-none">Beranda</a>
                    <a href="#katalog" class="text-muted text-decoration-none">Katalog Mobil</a>
                    <a href="{{ route('login') }}" class="text-warning text-decoration-none fw-bold">Login Staff</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3.3 JS Bundle (Local with CDN fallback) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        if (typeof bootstrap === 'undefined') {
            document.write('<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/bootstrap.bundle.min.js"><\/script>');
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggler = document.querySelector('.welcome-navbar .navbar-toggler');
            const collapseEl = document.getElementById('navbarWelcomeContent');
            if (toggler && collapseEl) {
                toggler.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (collapseEl.classList.contains('show')) {
                        collapseEl.classList.remove('show');
                    } else {
                        collapseEl.classList.add('show');
                    }
                });

                // Auto-close menu when clicking a link inside mobile dropdown
                collapseEl.querySelectorAll('a.nav-link, a.btn').forEach(function (link) {
                    link.addEventListener('click', function () {
                        collapseEl.classList.remove('show');
                    });
                });
            }
        });
    </script>

    <!-- Interactive Credit Calculator JS -->
    <script>
        function calculateCredit() {
            const price = parseFloat(document.getElementById('simPrice').value) || 0;
            const dpPercent = parseFloat(document.getElementById('simDpPercent').value) || 0;
            const rateYear = parseFloat(document.getElementById('simRate').value) || 0;
            const tenorMonths = parseInt(document.getElementById('simTenor').value) || 36;

            const dpAmount = price * (dpPercent / 100);
            const loanPrincipal = price - dpAmount;
            
            const totalInterest = loanPrincipal * (rateYear / 100) * (tenorMonths / 12);
            const totalLoan = loanPrincipal + totalInterest;
            const monthlyInstallment = totalLoan / tenorMonths;

            document.getElementById('simInstallmentResult').innerText = 'Rp ' + Math.round(monthlyInstallment).toLocaleString('id-ID');
            document.getElementById('simDpResult').innerText = 'DP Nominal: Rp ' + Math.round(dpAmount).toLocaleString('id-ID') + ' (' + dpPercent + '%)';
        }

        document.getElementById('simPrice').addEventListener('input', calculateCredit);
        document.getElementById('simDpPercent').addEventListener('input', calculateCredit);
        document.getElementById('simRate').addEventListener('input', calculateCredit);
        document.getElementById('simTenor').addEventListener('change', calculateCredit);

        calculateCredit();
    </script>
</body>
</html>

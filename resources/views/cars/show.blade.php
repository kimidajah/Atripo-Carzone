@extends('layouts.app')

@section('title', 'Detail Mobil - ' . $car->brand . ' ' . $car->model_type)

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 page-header-title">Detail Kendaraan</h3>
        <p class="text-muted small mb-0 page-header-subtitle">Informasi spesifikasi lengkap unit kendaraan Showroom MobilQ</p>
    </div>
    <div class="d-flex flex-wrap gap-2 w-100 w-sm-auto">
        <a href="{{ route('cars.index') }}" class="btn btn-outline-gold flex-grow-1 flex-sm-grow-0 text-center">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke List
        </a>
        @if(Auth::user()->canManageCars())
            <a href="{{ route('cars.edit', $car) }}" class="btn btn-gold flex-grow-1 flex-sm-grow-0 text-center">
                <i class="bi bi-pencil me-1"></i> Edit Mobil
            </a>
        @endif
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Big Image Display -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm overflow-hidden h-100">
            @if($car->image && Storage::disk('public')->exists($car->image))
                <img src="{{ asset('uploads/' . $car->image) }}" alt="{{ $car->brand }}" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 280px;">
            @else
                <div class="bg-dark text-white p-5 d-flex flex-column align-items-center justify-content-center h-100 min-vh-40 text-center">
                    <i class="bi bi-car-front display-1 text-warning mb-3"></i>
                    <h5 class="fw-bold text-white mb-1">MOBILQ</h5>
                    <span class="text-muted small">Foto Belum Diunggah</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Right Column: Specs & Status Details -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start gap-2 mb-3">
                    <div>
                        <span class="badge bg-dark text-warning border border-warning px-3 py-1 mb-2">{{ strtoupper($car->brand) }}</span>
                        <h2 class="fw-extrabold text-dark mb-0 fs-3 fs-sm-2">{{ $car->brand }} {{ $car->model_type }}</h2>
                    </div>
                    <div>
                        @if($car->status === 'tersedia')
                            <span class="badge badge-available px-3 py-2 fs-6">TERSEDIA</span>
                        @elseif($car->status === 'dipesan')
                            <span class="badge badge-reserved px-3 py-2 fs-6">DIPESAN</span>
                        @elseif($car->status === 'pending')
                            <span class="badge bg-secondary px-3 py-2 fs-6">PENDING</span>
                        @else
                            <span class="badge badge-sold px-3 py-2 fs-6">TERJUAL</span>
                        @endif
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 mb-4 border border-warning border-opacity-50">
                    <div class="text-muted small text-uppercase font-monospace">Harga Penawaran / Jual</div>
                    <h2 class="fw-extrabold text-warning mb-0">{{ $car->formatted_price }}</h2>
                </div>

                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Spesifikasi Kendaraan</h6>

                <div class="row g-3 text-dark">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-muted d-block mb-1">Tahun Produksi</small>
                            <span class="fw-bold fs-6">{{ $car->year }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-muted d-block mb-1">Jenis Transmisi</small>
                            <span class="fw-bold fs-6">{{ $car->transmission }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-muted d-block mb-1">Warna Bodi</small>
                            <span class="fw-bold fs-6">{{ $car->color }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-muted d-block mb-1">Nomor Polisi (Nopol)</small>
                            <span class="fw-bold fs-6 font-monospace">{{ $car->plate_number }}</span>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between text-muted small">
                    <span><i class="bi bi-calendar-event me-1"></i> Input: {{ $car->created_at->format('d M Y, H:i') }}</span>
                    <span><i class="bi bi-clock-history me-1"></i> Update: {{ $car->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

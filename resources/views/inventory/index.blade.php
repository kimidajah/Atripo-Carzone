@extends('layouts.app')

@section('title', 'Stok Mobil / Persediaan')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 page-header-title">Stok Mobil & Status Persediaan</h3>
        <p class="text-muted small mb-0 page-header-subtitle">Memantau kondisi stok armada secara real-time di Atripo Carzone Cileunyi</p>
    </div>
    <div class="d-flex flex-wrap gap-2 w-100 w-sm-auto">
        <!-- View Switcher Buttons -->
        <div class="btn-group flex-grow-1 flex-sm-grow-0" role="group" aria-label="Modus Tampilan">
            <a href="{{ request()->fullUrlWithQuery(['view' => 'table']) }}" class="btn btn-sm {{ request('view', 'table') == 'table' ? 'btn-gold' : 'btn-outline-gold' }}" title="Tampilan Tabel">
                <i class="bi bi-table me-1"></i> Tabel
            </a>
            <a href="{{ request()->fullUrlWithQuery(['view' => 'card']) }}" class="btn btn-sm {{ request('view') == 'card' ? 'btn-gold' : 'btn-outline-gold' }}" title="Tampilan Card (Gambar Besar)">
                <i class="bi bi-grid-fill me-1"></i> Card
            </a>
        </div>

        @if(Auth::user()->canManageCars())
            <a href="{{ route('cars.create') }}" class="btn btn-gold btn-sm px-3 d-flex align-items-center justify-content-center flex-grow-1 flex-sm-grow-0">
                <i class="bi bi-plus-circle me-1"></i> Tambah Unit Mobil
            </a>
        @endif
    </div>
</div>

<!-- Summary Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-dark">
            <div class="text-muted small fw-bold text-uppercase">Total Armada</div>
            <h3 class="fw-extrabold mb-0 text-dark fs-4 fs-sm-3">{{ $totalCars }}</h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-success">
            <div class="text-muted small fw-bold text-uppercase">Tersedia</div>
            <h3 class="fw-extrabold mb-0 text-success fs-4 fs-sm-3">{{ $availableCount }}</h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-warning">
            <div class="text-muted small fw-bold text-uppercase">Dipesan / Pending</div>
            <h3 class="fw-extrabold mb-0 text-warning fs-4 fs-sm-3">{{ $reservedCount + ($pendingCount ?? 0) }}</h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-secondary">
            <div class="text-muted small fw-bold text-uppercase">Terjual</div>
            <h3 class="fw-extrabold mb-0 text-secondary fs-4 fs-sm-3">{{ $soldCount }}</h3>
        </div>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('inventory.index') }}" method="GET" class="row g-2 align-items-center">
            <input type="hidden" name="view" value="{{ request('view', 'table') }}">
            <div class="col-12 col-md-7">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari nopol, merek, atau tipe kendaraan..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select bg-light" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status Persediaan</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia (Ready)</option>
                    <option value="dipesan" {{ request('status') == 'dipesan' ? 'selected' : '' }}>Dipesan (Booked)</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="terjual" {{ request('status') == 'terjual' ? 'selected' : '' }}>Terjual (Sold)</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <button type="submit" class="btn btn-gold w-100"><i class="bi bi-filter me-1"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

@if(request('view') == 'card')
    <!-- ==================== TAMPILAN CARD GRID (GAMBAR BESAR) ==================== -->
    <div class="row g-3 g-md-4 mb-4">
        @forelse($cars as $car)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100 overflow-hidden card-stat">
                    <!-- Image Box with Badge -->
                    <div class="position-relative bg-dark" style="height: 200px; overflow: hidden;">
                        @if($car->image && Storage::disk('public')->exists($car->image))
                            <img src="{{ asset('uploads/' . $car->image) }}" alt="{{ $car->brand }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted">
                                <i class="bi bi-car-front text-warning display-4"></i>
                                <span class="small text-white-50 mt-1">ATRIPO CARZONE</span>
                            </div>
                        @endif
                        
                        <!-- Status Badge Overlay -->
                        <div class="position-absolute top-0 end-0 m-2">
                            @if($car->status === 'tersedia')
                                <span class="badge badge-available shadow-sm px-2.5 py-1.5">TERSEDIA</span>
                            @elseif($car->status === 'dipesan')
                                <span class="badge badge-reserved shadow-sm px-2.5 py-1.5">DIPESAN</span>
                            @elseif($car->status === 'pending')
                                <span class="badge bg-secondary shadow-sm px-2.5 py-1.5">PENDING</span>
                            @else
                                <span class="badge badge-sold shadow-sm px-2.5 py-1.5">TERJUAL</span>
                            @endif
                        </div>

                        <!-- Year Badge Overlay -->
                        <div class="position-absolute bottom-0 start-0 m-2">
                            <span class="badge bg-dark bg-opacity-75 text-white font-monospace border border-secondary">{{ $car->year }}</span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="small text-muted text-uppercase fw-bold">{{ $car->brand }}</div>
                            <h5 class="fw-bold text-dark mb-1 text-truncate" title="{{ $car->model_type }}">{{ $car->model_type }}</h5>
                            <div class="fw-extrabold text-warning fs-5 mb-3">{{ $car->formatted_price }}</div>

                            <!-- Specs List -->
                            <div class="row g-2 text-muted small border-top pt-2 mb-3">
                                <div class="col-6">
                                    <i class="bi bi-gear-fill me-1 text-warning"></i> {{ $car->transmission }}
                                </div>
                                <div class="col-6">
                                    <i class="bi bi-palette-fill me-1 text-warning"></i> {{ $car->color }}
                                </div>
                                <div class="col-12 mt-1">
                                    <i class="bi bi-credit-card-2-front-fill me-1 text-warning"></i> Nopol: <span class="font-monospace fw-bold text-dark">{{ $car->plate_number }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="border-top pt-2">
                            <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-outline-dark w-100" title="Detail Unit">
                                <i class="bi bi-eye me-1"></i> Detail Unit Mobil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted bg-white rounded shadow-sm">
                <i class="bi bi-boxes display-6 d-block mb-2 text-secondary"></i>
                Belum ada data persediaan stok mobil yang sesuai.
            </div>
        @endforelse
    </div>
@else
    <!-- ==================== TAMPILAN TABEL ==================== -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Foto</th>
                            <th>Merek & Tipe</th>
                            <th>Tahun</th>
                            <th>No. Polisi</th>
                            <th>Harga Jual</th>
                            <th>Status Stok</th>
                            <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cars as $car)
                            <tr>
                                <td>
                                    @if($car->image && Storage::disk('public')->exists($car->image))
                                        <img src="{{ asset('uploads/' . $car->image) }}" alt="{{ $car->brand }}" class="rounded img-thumbnail" style="width: 65px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center text-muted" style="width: 65px; height: 48px;">
                                            <i class="bi bi-car-front fs-4"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $car->brand }} {{ $car->model_type }}</div>
                                    <small class="text-muted">Transmisi: {{ $car->transmission }} | Warna: {{ $car->color }}</small>
                                </td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">{{ $car->year }}</span></td>
                                <td class="text-nowrap"><span class="font-monospace fw-semibold">{{ $car->plate_number }}</span></td>
                                <td class="fw-bold text-warning text-nowrap">{{ $car->formatted_price }}</td>
                                <td class="text-nowrap">
                                    @if($car->status === 'tersedia')
                                        <span class="badge badge-available">TERSEDIA</span>
                                    @elseif($car->status === 'dipesan')
                                        <span class="badge badge-reserved">DIPESAN</span>
                                    @elseif($car->status === 'pending')
                                        <span class="badge bg-secondary">PENDING</span>
                                    @else
                                        <span class="badge badge-sold">TERJUAL</span>
                                    @endif
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-outline-dark" title="Detail Unit">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-boxes display-6 d-block mb-2 text-secondary"></i>
                                    Belum ada data persediaan stok mobil yang sesuai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@if($cars->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $cars->links() }}
    </div>
@endif
@endsection

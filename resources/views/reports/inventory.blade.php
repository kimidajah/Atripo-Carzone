@extends('layouts.app')

@section('title', 'Laporan Stok & Persediaan')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 page-header-title">Laporan Stok & Persediaan</h3>
        <p class="text-muted small mb-0 page-header-subtitle">Laporan kondisi fisik stok kendaraan dan status ketersediaan armada</p>
    </div>
    <div class="d-flex flex-wrap gap-2 w-100 w-sm-auto">
        <a href="{{ route('reports.inventory', array_merge(request()->all(), ['print' => 1])) }}" target="_blank" class="btn btn-outline-gold flex-grow-1 flex-sm-grow-0 text-center">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </a>
        <a href="{{ route('reports.inventory', array_merge(request()->all(), ['pdf' => 1])) }}" target="_blank" class="btn btn-gold flex-grow-1 flex-sm-grow-0 text-center">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
        </a>
    </div>
</div>

<!-- Filter Form -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('reports.inventory') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-6 col-md-5">
                <select name="status" class="form-select bg-light">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status Persediaan</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia (Ready)</option>
                    <option value="dipesan" {{ request('status') == 'dipesan' ? 'selected' : '' }}>Dipesan (Booked)</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="terjual" {{ request('status') == 'terjual' ? 'selected' : '' }}>Terjual (Sold)</option>
                </select>
            </div>
            <div class="col-6 col-md-4">
                <select name="brand" class="form-select bg-light">
                    <option value="all" {{ request('brand') == 'all' ? 'selected' : '' }}>Semua Merek</option>
                    @foreach($brands as $b)
                        <option value="{{ $b }}" {{ request('brand') == $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <button type="submit" class="btn btn-gold w-100"><i class="bi bi-filter me-1"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-dark">
            <div class="text-muted small fw-bold text-uppercase">Total Unit</div>
            <h3 class="fw-extrabold mb-0 text-dark fs-4 fs-sm-3">{{ $totalCars }}</h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-success">
            <div class="text-muted small fw-bold text-uppercase">Mobil Tersedia</div>
            <h3 class="fw-extrabold mb-0 text-success fs-4 fs-sm-3">{{ $availableCount }}</h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-warning">
            <div class="text-muted small fw-bold text-uppercase">Mobil Dipesan</div>
            <h3 class="fw-extrabold mb-0 text-warning fs-4 fs-sm-3">{{ $reservedCount }}</h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-secondary">
            <div class="text-muted small fw-bold text-uppercase">Mobil Terjual</div>
            <h3 class="fw-extrabold mb-0 text-secondary fs-4 fs-sm-3">{{ $soldCount }}</h3>
        </div>
    </div>
</div>

<!-- Table Report -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;" class="text-center">No</th>
                        <th>Mobil & Tipe</th>
                        <th>Tahun</th>
                        <th>Transmisi</th>
                        <th>No. Polisi</th>
                        <th>Harga Jual</th>
                        <th>Status Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $index => $car)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $car->brand }} {{ $car->model_type }}</div>
                                <small class="text-muted">Warna: {{ $car->color }}</small>
                            </td>
                            <td class="text-nowrap">{{ $car->year }}</td>
                            <td class="text-nowrap">{{ $car->transmission }}</td>
                            <td class="font-monospace fw-bold text-nowrap">{{ $car->plate_number }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                Tidak ada data stok kendaraan pada filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

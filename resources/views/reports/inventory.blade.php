@extends('layouts.app')

@section('title', 'Laporan Persediaan Stok Mobil')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Laporan Persediaan Mobil</h3>
        <p class="text-muted small mb-0">Rekapitulasi persediaan kendaraan armada Atripo Carzone Cileunyi</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('reports.inventory', array_merge(request()->all(), ['print' => 1])) }}" target="_blank" class="btn btn-outline-gold">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </a>
        <a href="{{ route('reports.inventory', array_merge(request()->all(), ['pdf' => 1])) }}" target="_blank" class="btn btn-gold">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
        </a>
    </div>
</div>

<!-- Filter Box -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('reports.inventory') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <select name="status" class="form-select bg-light">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status Persediaan</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia (Ready)</option>
                    <option value="dipesan" {{ request('status') == 'dipesan' ? 'selected' : '' }}>Dipesan (Booked)</option>
                    <option value="terjual" {{ request('status') == 'terjual' ? 'selected' : '' }}>Terjual (Sold)</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="brand" class="form-select bg-light">
                    <option value="all" {{ request('brand') == 'all' ? 'selected' : '' }}>Semua Merek</option>
                    @foreach($brands as $b)
                        <option value="{{ $b }}" {{ request('brand') == $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
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
            <h3 class="fw-extrabold mb-0 text-dark">{{ $totalCars }}</h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-success">
            <div class="text-muted small fw-bold text-uppercase">Mobil Tersedia</div>
            <h3 class="fw-extrabold mb-0 text-success">{{ $availableCount }}</h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-warning">
            <div class="text-muted small fw-bold text-uppercase">Mobil Dipesan</div>
            <h3 class="fw-extrabold mb-0 text-warning">{{ $reservedCount }}</h3>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm p-3 text-center bg-white border-bottom border-4 border-secondary">
            <div class="text-muted small fw-bold text-uppercase">Mobil Terjual</div>
            <h3 class="fw-extrabold mb-0 text-secondary">{{ $soldCount }}</h3>
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
                            <td>{{ $car->year }}</td>
                            <td>{{ $car->transmission }}</td>
                            <td class="font-monospace fw-bold">{{ $car->plate_number }}</td>
                            <td class="fw-bold text-warning">{{ $car->formatted_price }}</td>
                            <td>
                                @if($car->status === 'tersedia')
                                    <span class="badge badge-available">TERSDIA</span>
                                @elseif($car->status === 'dipesan')
                                    <span class="badge badge-reserved">DIPESAN</span>
                                @else
                                    <span class="badge badge-sold">TERJUAL</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                Tidak ada data persediaan kendaraan yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Laporan Pengelolaan Armada (Mobil Masuk & Keluar)')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 page-header-title">Laporan Pengelolaan Armada</h3>
        <p class="text-muted small mb-0 page-header-subtitle">Rekapitulasi jumlah unit mobil yang masuk (di-input) dan keluar (terjual) berdasarkan periode tanggal</p>
    </div>
    <div class="d-flex flex-wrap gap-2 w-100 w-sm-auto">
        <a href="{{ route('reports.management', array_merge(request()->all(), ['print' => 1])) }}" target="_blank" class="btn btn-outline-gold flex-grow-1 flex-sm-grow-0 text-center">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </a>
        <a href="{{ route('reports.management', array_merge(request()->all(), ['pdf' => 1])) }}" target="_blank" class="btn btn-gold flex-grow-1 flex-sm-grow-0 text-center">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
        </a>
    </div>
</div>

<!-- Filter Date Range -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('reports.management') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-6 col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control bg-light" value="{{ $startDate }}">
            </div>
            <div class="col-6 col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control bg-light" value="{{ $endDate }}">
            </div>
            <div class="col-12 col-md-4">
                <button type="submit" class="btn btn-gold w-100"><i class="bi bi-calendar-check me-1"></i> Tampilkan Laporan</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-info">
            <div class="text-muted small fw-bold text-uppercase"><i class="bi bi-arrow-down-left-circle-fill text-info me-1"></i> Mobil Masuk Periode Ini</div>
            <h3 class="fw-extrabold mb-0 text-dark fs-4 fs-sm-3">{{ $totalIncoming }} Unit</h3>
            <small class="text-muted">Unit kendaraan baru yang di-input</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-warning">
            <div class="text-muted small fw-bold text-uppercase"><i class="bi bi-arrow-up-right-circle-fill text-warning me-1"></i> Mobil Keluar / Terjual</div>
            <h3 class="fw-extrabold mb-0 text-dark fs-4 fs-sm-3">{{ $totalOutgoing }} Unit</h3>
            <small class="text-muted">Unit kendaraan yang berhasil terjual</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-success">
            <div class="text-muted small fw-bold text-uppercase"><i class="bi bi-check-circle-fill text-success me-1"></i> Stok Tersedia Saat Ini</div>
            <h3 class="fw-extrabold mb-0 text-success fs-4 fs-sm-3">{{ $currentAvailable }} Unit</h3>
            <small class="text-muted">Unit ready untuk dijual di showroom</small>
        </div>
    </div>
</div>

<!-- Section 1: Data Mobil Masuk -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-0">
        <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-box-arrow-in-down me-2 text-info"></i>Daftar Mobil Masuk (Di-input / Registrasi Baru)
        </h5>
        <small class="text-muted">Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;" class="text-center">No</th>
                        <th>Tanggal Masuk</th>
                        <th>Merek & Tipe</th>
                        <th>Tahun</th>
                        <th>Transmisi / Warna</th>
                        <th>No. Polisi</th>
                        <th class="text-end">Harga Stok</th>
                        <th>Status Saat Ini</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($carsIncoming as $index => $car)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-nowrap">{{ $car->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="fw-bold">{{ $car->brand }} {{ $car->model_type }}</div>
                            </td>
                            <td class="text-nowrap">{{ $car->year }}</td>
                            <td>{{ $car->transmission }} | {{ $car->color }}</td>
                            <td class="font-monospace fw-bold text-nowrap">{{ $car->plate_number }}</td>
                            <td class="text-end fw-bold text-warning text-nowrap">{{ $car->formatted_price }}</td>
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
                            <td colspan="8" class="text-center py-4 text-muted">
                                Tidak ada data mobil masuk (di-input) pada periode tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Section 2: Data Mobil Keluar (Terjual) -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-0">
        <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-box-arrow-up-right me-2 text-warning"></i>Daftar Mobil Keluar (Terjual / Transaksi Penjualan)
        </h5>
        <small class="text-muted">Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;" class="text-center">No</th>
                        <th>Tanggal Keluar</th>
                        <th>No Invoice</th>
                        <th>Kendaraan Terjual</th>
                        <th>Pelanggan Pembeli</th>
                        <th>Skema Bayar</th>
                        <th class="text-end">Harga Penjualan Deal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesOutgoing as $index => $sale)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-nowrap">{{ $sale->sale_date->format('d/m/Y') }}</td>
                            <td class="fw-bold font-monospace text-nowrap">{{ $sale->invoice_number }}</td>
                            <td>
                                <div class="fw-bold">{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }}</div>
                                <small class="text-muted">Nopol: {{ $sale->car->plate_number ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $sale->customer->name ?? '-' }}</div>
                                <small class="text-muted">{{ $sale->customer->phone ?? '' }}</small>
                            </td>
                            <td class="text-nowrap">
                                @if($sale->payment_type === 'credit')
                                    <span class="badge bg-warning text-dark">KREDIT ({{ $sale->tenor_months }} Bln)</span>
                                @else
                                    <span class="badge bg-success">CASH / LUNAS</span>
                                @endif
                            </td>
                            <td class="text-end fw-bold text-warning text-nowrap">{{ $sale->formatted_price }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Tidak ada transaksi mobil keluar (terjual) pada periode tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

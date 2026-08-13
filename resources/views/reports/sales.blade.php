@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 page-header-title">Laporan Penjualan</h3>
        <p class="text-muted small mb-0 page-header-subtitle">Rekapitulasi transaksi penjualan kendaraan (Cash & Kredit) berdasarkan periode tanggal</p>
    </div>
    <div class="d-flex flex-wrap gap-2 w-100 w-sm-auto">
        <a href="{{ route('reports.sales', array_merge(request()->all(), ['print' => 1])) }}" target="_blank" class="btn btn-outline-gold flex-grow-1 flex-sm-grow-0 text-center">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </a>
        <a href="{{ route('reports.sales', array_merge(request()->all(), ['pdf' => 1])) }}" target="_blank" class="btn btn-gold flex-grow-1 flex-sm-grow-0 text-center">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
        </a>
    </div>
</div>

<!-- Filter Date Range -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('reports.sales') }}" method="GET" class="row g-2 align-items-end">
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

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-warning">
            <div class="text-muted small fw-bold text-uppercase">Total Transaksi Selesai</div>
            <h3 class="fw-extrabold mb-0 text-dark fs-4 fs-sm-3">{{ $totalTransactions }} Transaksi</h3>
            <small class="text-muted">Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</small>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-success">
            <div class="text-muted small fw-bold text-uppercase">Total Nilai Penjualan Deal (Omset)</div>
            <h3 class="fw-extrabold mb-0 text-success fs-4 fs-sm-3">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <small class="text-muted">Akumulasi nilai penjualan kendaraan</small>
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
                        <th>Tanggal</th>
                        <th>No Invoice</th>
                        <th>Kendaraan Terjual</th>
                        <th>Pelanggan Pembeli</th>
                        <th>Skema Bayar</th>
                        <th class="text-end">Harga Penjualan Deal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $index => $sale)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-nowrap">{{ $sale->sale_date->format('d/m/Y') }}</td>
                            <td class="fw-bold font-monospace text-nowrap">{{ $sale->invoice_number }}</td>
                            <td>
                                <div class="fw-bold">{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }}</div>
                                <small class="text-muted">Nopol: {{ $sale->car->plate_number ?? '-' }} ({{ $sale->car->year ?? '' }})</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $sale->customer->name ?? '-' }}</div>
                                @if($sale->customer && $sale->customer->nik)
                                    <small class="text-muted d-block font-monospace" style="font-size: 0.75rem;">NIK: {{ $sale->customer->nik }}</small>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                @if($sale->payment_type === 'credit')
                                    <span class="badge bg-warning text-dark">KREDIT ({{ $sale->tenor_months }} Bln)</span>
                                    <div class="small text-muted mt-1" style="font-size: 0.75rem;">
                                        DP: {{ $sale->formatted_dp_amount }}
                                    </div>
                                @else
                                    <span class="badge bg-success">CASH / LUNAS</span>
                                @endif
                            </td>
                            <td class="text-end fw-bold text-warning text-nowrap">{{ $sale->formatted_price }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                Tidak ada data transaksi penjualan pada periode yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($sales->count() > 0)
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="6" class="text-end fw-bold fs-6 text-nowrap">TOTAL PENJUALAN PERIODE INI:</td>
                            <td class="text-end fw-extrabold fs-5 text-dark text-nowrap">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

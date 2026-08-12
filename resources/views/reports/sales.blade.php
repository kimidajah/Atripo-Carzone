@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Laporan Penjualan</h3>
        <p class="text-muted small mb-0">Rekapitulasi transaksi penjualan kendaraan berdasarkan periode tanggal</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('reports.sales', array_merge(request()->all(), ['print' => 1])) }}" target="_blank" class="btn btn-outline-gold">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </a>
        <a href="{{ route('reports.sales', array_merge(request()->all(), ['pdf' => 1])) }}" target="_blank" class="btn btn-gold">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
        </a>
    </div>
</div>

<!-- Filter Date Range -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('reports.sales') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control bg-light" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control bg-light" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-gold w-100"><i class="bi bi-calendar-check me-1"></i> Tampilkan Laporan</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-warning">
            <div class="text-muted small fw-bold text-uppercase">Total Transaksi Selesai</div>
            <h3 class="fw-extrabold mb-0 text-dark">{{ $totalTransactions }} Transaksi</h3>
            <small class="text-muted">Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3 bg-white border-start border-4 border-success">
            <div class="text-muted small fw-bold text-uppercase">Total Nilai Penjualan (Omset)</div>
            <h3 class="fw-extrabold mb-0 text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <small class="text-muted">Akumulasi penerimaan penjualan</small>
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
                        <th>Metode</th>
                        <th class="text-end">Harga Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $index => $sale)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                            <td class="fw-bold font-monospace">{{ $sale->invoice_number }}</td>
                            <td>
                                <div class="fw-bold">{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }}</div>
                                <small class="text-muted">Nopol: {{ $sale->car->plate_number ?? '-' }} ({{ $sale->car->year ?? '' }})</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $sale->customer->name ?? '-' }}</div>
                                <small class="text-muted">{{ $sale->customer->phone ?? '' }}</small>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ strtoupper($sale->payment_method) }}</span></td>
                            <td class="text-end fw-bold text-warning">{{ $sale->formatted_price }}</td>
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
                            <td colspan="6" class="text-end fw-bold fs-6">TOTAL PENJUALAN PERIODE INI:</td>
                            <td class="text-end fw-extrabold fs-5 text-dark">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

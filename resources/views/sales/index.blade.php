@extends('layouts.app')

@section('title', 'Riwayat Transaksi Penjualan')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 page-header-title">Riwayat Transaksi Penjualan</h3>
        <p class="text-muted small mb-0 page-header-subtitle">Daftar seluruh transaksi penjualan kendaraan di Showroom MobilQ (Cash & Kredit)</p>
    </div>
    @if(Auth::user()->canManageSales())
        <a href="{{ route('sales.create') }}" class="btn btn-gold px-3 w-100 w-sm-auto text-center">
            <i class="bi bi-cart-plus me-1"></i> Transaksi Penjualan Baru
        </a>
    @endif
</div>

<!-- Search & Filter Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('sales.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-12 col-md-3">
                <label class="form-label small fw-semibold text-muted mb-1">Cari Transaksi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="No Invoice, nopol, NIK, atau pelanggan..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold text-muted mb-1">Skema Bayar</label>
                <select name="payment_type" class="form-select bg-light">
                    <option value="all">Semua Skema</option>
                    <option value="cash" {{ request('payment_type') == 'cash' ? 'selected' : '' }}>Cash / Lunas</option>
                    <option value="credit" {{ request('payment_type') == 'credit' ? 'selected' : '' }}>Kredit Mobil</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold text-muted mb-1">Mulai Tgl</label>
                <input type="date" name="start_date" class="form-control bg-light" value="{{ request('start_date') }}">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold text-muted mb-1">Akhir Tgl</label>
                <input type="date" name="end_date" class="form-control bg-light" value="{{ request('end_date') }}">
            </div>
            <div class="col-12 col-md-3">
                <div class="d-flex gap-1">
                    <button type="submit" class="btn btn-gold w-100"><i class="bi bi-filter me-1"></i> Filter</button>
                    <a href="{{ route('sales.index') }}" class="btn btn-light border" title="Reset Filter"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Table Listing -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No Invoice</th>
                        <th>Tanggal</th>
                        <th>Kendaraan</th>
                        <th>Pelanggan</th>
                        <th>Harga Deal</th>
                        <th>Skema & Metode</th>
                        <th>Dibuat Oleh</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td class="fw-bold text-dark font-monospace text-nowrap">{{ $sale->invoice_number }}</td>
                            <td class="text-nowrap">{{ $sale->sale_date->format('d/m/Y') }}</td>
                            <td>
                                <div class="fw-bold">{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }}</div>
                                <small class="text-muted">Nopol: {{ $sale->car->plate_number ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $sale->customer->name ?? '-' }}</div>
                                @if($sale->customer && $sale->customer->nik)
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">NIK: {{ $sale->customer->nik }}</small>
                                @else
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">{{ $sale->customer->phone ?? '' }}</small>
                                @endif
                            </td>
                            <td class="fw-bold text-warning text-nowrap">{{ $sale->formatted_price }}</td>
                            <td class="text-nowrap">
                                @if($sale->payment_type === 'credit')
                                    <span class="badge bg-warning text-dark border border-warning">
                                        <i class="bi bi-clock-history me-1"></i>KREDIT ({{ $sale->tenor_months }} bln)
                                    </span>
                                    <div class="small fw-bold text-dark mt-1" style="font-size: 0.775rem;">
                                        DP: {{ $sale->formatted_dp_amount }}
                                    </div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">
                                        Cicilan: {{ $sale->formatted_monthly_installment }}/bln
                                    </div>
                                @else
                                    <span class="badge bg-success border border-success">
                                        <i class="bi bi-cash-stack me-1"></i>CASH / LUNAS
                                    </span>
                                    <div class="small text-muted mt-1" style="font-size: 0.75rem;">
                                        Bayar via {{ strtoupper($sale->payment_method) }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-nowrap"><small class="text-muted">{{ $sale->user->name ?? '-' }}</small></td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-outline-gold" title="Lihat Invoice Detail">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-cart-x display-6 d-block mb-2 text-secondary"></i>
                                Belum ada riwayat transaksi penjualan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($sales->hasPages())
        <div class="card-footer bg-white py-3 border-0 d-flex justify-content-end">
            {{ $sales->links() }}
        </div>
    @endif
</div>
@endsection

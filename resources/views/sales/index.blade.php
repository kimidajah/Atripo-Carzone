@extends('layouts.app')

@section('title', 'Riwayat Transaksi Penjualan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Riwayat Transaksi Penjualan</h3>
        <p class="text-muted small mb-0">Daftar seluruh transaksi penjualan kendaraan di Showroom Atripo Carzone</p>
    </div>
    @if(Auth::user()->isAdmin())
        <a href="{{ route('sales.create') }}" class="btn btn-gold px-3">
            <i class="bi bi-cart-plus me-1"></i> Transaksi Penjualan Baru
        </a>
    @endif
</div>

<!-- Search & Filter Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('sales.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Cari Transaksi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="No Invoice, nama mobil, atau pelanggan..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control bg-light" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control bg-light" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-gold w-100 mt-4"><i class="bi bi-filter me-1"></i> Filter</button>
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
                        <th>Harga Penjualan</th>
                        <th>Metode</th>
                        <th>Dibuat Oleh</th>
                        <th class="text-center" style="width: 90px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td class="fw-bold text-dark">{{ $sale->invoice_number }}</td>
                            <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                            <td>
                                <div class="fw-bold">{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }}</div>
                                <small class="text-muted">Nopol: {{ $sale->car->plate_number ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $sale->customer->name ?? '-' }}</div>
                                <small class="text-muted">{{ $sale->customer->phone ?? '' }}</small>
                            </td>
                            <td class="fw-bold text-warning">{{ $sale->formatted_price }}</td>
                            <td><span class="badge bg-light text-dark border">{{ strtoupper($sale->payment_method) }}</span></td>
                            <td><small class="text-muted">{{ $sale->user->name ?? '-' }}</small></td>
                            <td class="text-center">
                                <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-outline-gold" title="Lihat Invoice Detail">
                                    <i class="bi bi-eye"></i> Detail
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

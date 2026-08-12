@extends('layouts.app')

@section('title', 'Detail Pelanggan - ' . $customer->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Detail Pelanggan</h3>
        <p class="text-muted small mb-0">Informasi identitas dan riwayat pembelian kendaraan</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('customers.index') }}" class="btn btn-outline-gold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        @if(Auth::user()->isAdmin())
            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-gold">
                <i class="bi bi-pencil me-1"></i> Edit Data
            </a>
        @endif
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Customer Profile -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm text-center p-4">
            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2.2rem; border: 3px solid #D4AF37;">
                {{ strtoupper(substr($customer->name, 0, 1)) }}
            </div>
            <h4 class="fw-bold text-dark mb-1">{{ $customer->name }}</h4>
            <p class="text-muted small mb-3">Terdaftar sejak {{ $customer->created_at->format('d M Y') }}</p>

            <div class="list-group list-group-flush text-start border-top pt-3">
                <div class="list-group-item px-0 border-0">
                    <small class="text-muted d-block">Nomor Telepon / WA</small>
                    <span class="fw-semibold font-monospace"><i class="bi bi-telephone text-warning me-1"></i>{{ $customer->phone }}</span>
                </div>
                <div class="list-group-item px-0 border-0">
                    <small class="text-muted d-block">Email</small>
                    <span class="fw-semibold"><i class="bi bi-envelope text-warning me-1"></i>{{ $customer->email ?? '-' }}</span>
                </div>
                <div class="list-group-item px-0 border-0">
                    <small class="text-muted d-block">Alamat Lengkap</small>
                    <span class="fw-semibold"><i class="bi bi-geo-alt text-warning me-1"></i>{{ $customer->address }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Purchase History -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0">Riwayat Pembelian Kendaraan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No. Invoice</th>
                                <th>Tanggal</th>
                                <th>Mobil Pembelian</th>
                                <th>Harga Penjualan</th>
                                <th>Metode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customer->sales as $sale)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $sale->invoice_number }}</td>
                                    <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                    <td>{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }} ({{ $sale->car->plate_number ?? '' }})</td>
                                    <td class="fw-bold text-warning">{{ $sale->formatted_price }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ strtoupper($sale->payment_method) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        Pelanggan ini belum memiliki riwayat pembelian kendaraan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

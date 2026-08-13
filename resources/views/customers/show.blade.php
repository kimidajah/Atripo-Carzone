@extends('layouts.app')

@section('title', 'Detail Pelanggan - ' . $customer->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1 page-header-title">Detail Pelanggan</h3>
        <p class="text-muted small mb-0 page-header-subtitle">Informasi identitas, berkas dokumen kredit, dan riwayat transaksi kendaraan</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('customers.index') }}" class="btn btn-outline-gold">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        @if(Auth::user()->canManageCustomers())
            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-gold">
                <i class="bi bi-pencil me-1"></i> Edit Data & Berkas
            </a>
        @endif
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Customer Profile & Credit Documents -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm text-center p-4 mb-4">
            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold mx-auto mb-3" style="width: 75px; height: 75px; font-size: 2rem; border: 3px solid #D4AF37;">
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

        <!-- Credit Documents Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-folder-check me-2 text-info"></i>Berkas & Dokumen Kredit
                </h6>
                @if($customer->has_credit_documents)
                    <span class="badge bg-success">Lengkap</span>
                @else
                    <span class="badge bg-secondary">Belum Upload</span>
                @endif
            </div>
            <div class="card-body p-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold small">NIK KTP</div>
                            <div class="text-muted small font-monospace">{{ $customer->nik ?? '-' }}</div>
                        </div>
                        @if($customer->ktp_url)
                            <a href="{{ $customer->ktp_url }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat KTP</a>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold small">Nomor Kartu Keluarga (KK)</div>
                            <div class="text-muted small font-monospace">{{ $customer->kk_number ?? '-' }}</div>
                        </div>
                        @if($customer->kk_url)
                            <a href="{{ $customer->kk_url }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat KK</a>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold small">Slip Gaji / Penghasilan</div>
                            <div class="text-muted small">Bukti penghasilan</div>
                        </div>
                        @if($customer->salary_slip_url)
                            <a href="{{ $customer->salary_slip_url }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat Slip Gaji</a>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center border-0">
                        <div>
                            <div class="fw-semibold small">Nomor NPWP</div>
                            <div class="text-muted small font-monospace">{{ $customer->npwp_number ?? '-' }}</div>
                        </div>
                        @if($customer->npwp_url)
                            <a href="{{ $customer->npwp_url }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Lihat NPWP</a>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Right Column: Purchase History -->
    <div class="col-lg-7">
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
                                <th>Harga Deal</th>
                                <th>Skema Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customer->sales as $sale)
                                <tr>
                                    <td class="fw-bold text-dark">
                                        <a href="{{ route('sales.show', $sale) }}" class="text-decoration-none text-gold">
                                            {{ $sale->invoice_number }}
                                        </a>
                                    </td>
                                    <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                    <td>{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }} ({{ $sale->car->plate_number ?? '' }})</td>
                                    <td class="fw-bold text-warning">{{ $sale->formatted_price }}</td>
                                    <td>
                                        @if($sale->payment_type === 'credit')
                                            <span class="badge bg-warning text-dark border"><i class="bi bi-clock-history me-1"></i>KREDIT ({{ $sale->tenor_months }} bln)</span>
                                        @else
                                            <span class="badge bg-success border"><i class="bi bi-cash-stack me-1"></i>CASH / LUNAS</span>
                                        @endif
                                    </td>
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

@extends('layouts.app')

@section('title', 'Invoice Transaksi - ' . $sale->invoice_number)

@push('styles')
<style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 8mm 10mm;
        }

        body, html {
            background: #ffffff !important;
            font-size: 10pt !important;
            color: #000000 !important;
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
        }

        .sidebar, .topbar, footer, .d-print-none, .btn-print, .alert {
            display: none !important;
        }

        .main-content {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .invoice-box {
            padding: 0 !important;
        }

        .invoice-header-row {
            padding-bottom: 8px !important;
            margin-bottom: 12px !important;
        }

        .info-card-box {
            padding: 10px 12px !important;
        }

        .row-info-section {
            margin-bottom: 12px !important;
        }

        .table {
            margin-bottom: 12px !important;
        }

        .table th, .table td {
            padding: 5px 8px !important;
            font-size: 9.5pt !important;
        }

        .notes-box {
            padding: 8px 12px !important;
            margin-bottom: 12px !important;
        }

        .signature-section {
            margin-top: 20px !important;
            padding-top: 0 !important;
            page-break-inside: avoid !important;
        }

        .signature-space {
            margin-bottom: 35px !important;
        }

        .bg-light {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .badge {
            border: 1px solid #6c757d !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header (Hidden when printing) -->
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 d-print-none">
    <div>
        <h3 class="fw-bold mb-1 page-header-title">Invoice Transaksi Penjualan</h3>
        <p class="text-muted small mb-0 page-header-subtitle">Bukti resmi transaksi penjualan kendaraan MobilQ</p>
    </div>
    <div class="d-flex flex-wrap gap-2 w-100 w-sm-auto">
        <a href="{{ route('sales.index') }}" class="btn btn-outline-gold flex-grow-1 flex-sm-grow-0 text-center">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
        <button onclick="window.print()" class="btn btn-gold btn-print flex-grow-1 flex-sm-grow-0 text-center">
            <i class="bi bi-printer me-1"></i> Cetak Invoice
        </button>
    </div>
</div>

<!-- Printable Invoice Card Container -->
<div class="card border-0 shadow-sm p-3 p-md-4 text-dark invoice-box">
    <!-- Invoice Header -->
    <div class="row align-items-center border-bottom pb-3 mb-3 invoice-header-row g-2">
        <div class="col-12 col-sm-6">
            <div class="d-flex align-items-center mb-1">
                <i class="bi bi-car-front-fill text-warning me-2 fs-2"></i>
                <h3 class="fw-extrabold mb-0 fs-3">MOBIL<span class="text-warning">Q</span></h3>
            </div>
            <p class="text-muted small mb-0" style="font-size: 0.825rem;">
                Jl. Raya Cileunyi, Kabupaten Bandung, Jawa Barat<br>
                Telp/WA: 0812-3456-7890 | Email: info@mobilq.com
            </p>
        </div>
        <div class="col-12 col-sm-6 text-sm-end">
            <h4 class="fw-bold text-uppercase text-warning mb-1 fs-5">INVOICE PENJUALAN {{ strtoupper($sale->payment_type) }}</h4>
            <div class="fw-bold fs-5 text-dark font-monospace">{{ $sale->invoice_number }}</div>
            <small class="text-muted">Tanggal: {{ $sale->sale_date->format('d F Y') }}</small>
        </div>
    </div>

    <!-- Customer & Transaction Info -->
    <div class="row mb-3 g-3 row-info-section">
        <div class="col-12 col-sm-6">
            <div class="p-3 bg-light rounded border h-100 info-card-box">
                <h6 class="fw-bold text-uppercase text-muted small mb-2" style="font-size: 0.75rem;">Informasi Pembeli / Pelanggan</h6>
                <h5 class="fw-bold text-dark mb-1 fs-6">{{ $sale->customer->name ?? '-' }}</h5>
                <p class="text-muted small mb-1" style="font-size: 0.825rem;"><i class="bi bi-telephone text-warning me-1"></i> {{ $sale->customer->phone ?? '-' }}</p>
                <p class="text-muted small mb-1" style="font-size: 0.825rem;"><i class="bi bi-geo-alt text-warning me-1"></i> {{ $sale->customer->address ?? '-' }}</p>
                @if($sale->customer->nik)
                    <p class="text-muted small mb-0" style="font-size: 0.825rem;"><i class="bi bi-card-heading text-warning me-1"></i> NIK KTP: {{ $sale->customer->nik }}</p>
                @endif
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="p-3 bg-light rounded border h-100 info-card-box">
                <h6 class="fw-bold text-uppercase text-muted small mb-2" style="font-size: 0.75rem;">Rincian Pembayaran</h6>
                <div class="d-flex justify-content-between mb-1" style="font-size: 0.85rem;">
                    <span class="text-muted">Skema Pembelian:</span>
                    @if($sale->payment_type === 'credit')
                        <span class="badge bg-warning text-dark font-monospace"><i class="bi bi-clock-history me-1"></i>KREDIT MOBIL</span>
                    @else
                        <span class="badge bg-success font-monospace"><i class="bi bi-cash-stack me-1"></i>CASH / LUNAS</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between mb-1" style="font-size: 0.85rem;">
                    <span class="text-muted">Metode Pembayaran:</span>
                    <span class="fw-bold text-uppercase">{{ $sale->payment_method }}</span>
                </div>
                <div class="d-flex justify-content-between" style="font-size: 0.85rem;">
                    <span class="text-muted">Dibuat Oleh Admin:</span>
                    <span class="fw-semibold">{{ $sale->user->name ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Rincian Skema Kredit jika transaksi Kredit -->
    @if($sale->payment_type === 'credit')
        <div class="card border-warning mb-3">
            <div class="card-header bg-warning bg-opacity-10 py-2">
                <h6 class="fw-bold mb-0 text-dark small text-uppercase">
                    <i class="bi bi-calculator-fill me-1 text-warning"></i>Rincian Skema Kredit Mobil
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2 text-center">
                    <div class="col-6 col-md-3 border-end">
                        <div class="text-muted small">Harga Mobil Deal</div>
                        <div class="fw-bold text-dark">{{ $sale->formatted_price }}</div>
                    </div>
                    <div class="col-6 col-md-3 border-end">
                        <div class="text-muted small">Uang Muka (DP)</div>
                        <div class="fw-bold text-success">{{ $sale->formatted_dp_amount }}</div>
                    </div>
                    <div class="col-6 col-md-3 border-end">
                        <div class="text-muted small">Tenor & Bunga (%/thn)</div>
                        <div class="fw-bold text-dark">{{ $sale->tenor_months }} Bulan ({{ $sale->interest_rate_per_year }}%)</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted small">Angsuran / Bulan</div>
                        <div class="fw-bold text-warning fs-6">{{ $sale->formatted_monthly_installment }}</div>
                    </div>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between small text-muted px-2">
                    <span>Pokok Utang: <strong>{{ $sale->formatted_principal_amount }}</strong></span>
                    <span>Total Nominal Bunga: <strong>{{ $sale->formatted_total_interest }}</strong></span>
                </div>
            </div>
        </div>
    @endif

    <!-- Vehicle Details Table -->
    <h6 class="fw-bold text-dark mb-2 fs-6">Kendaraan Yang Dibeli</h6>
    <div class="table-responsive mb-3">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Deskripsi Kendaraan</th>
                    <th>Spesifikasi</th>
                    <th>No. Polisi</th>
                    <th class="text-end">Harga Penjualan Deal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="fw-bold fs-6">{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }}</div>
                        <small class="text-muted">Tahun {{ $sale->car->year ?? '-' }}</small>
                    </td>
                    <td>
                        <span>Warna: {{ $sale->car->color ?? '-' }}</span><br>
                        <small class="text-muted">Transmisi: {{ $sale->car->transmission ?? '-' }}</small>
                    </td>
                    <td class="font-monospace fw-bold">{{ $sale->car->plate_number ?? '-' }}</td>
                    <td class="text-end fw-extrabold fs-5 text-warning">{{ $sale->formatted_price }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold fs-6">
                        {{ $sale->payment_type === 'credit' ? 'TOTAL ANGSURAN PER BULAN:' : 'TOTAL PEMBAYARAN LUNAS:' }}
                    </td>
                    <td class="text-end fw-extrabold fs-5 text-dark">
                        {{ $sale->payment_type === 'credit' ? $sale->formatted_monthly_installment : $sale->formatted_price }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Customer Credit Documents Preview (D-PRINT-NONE) -->
    @if($sale->customer && $sale->customer->has_credit_documents)
        <div class="card border-info mb-3 d-print-none">
            <div class="card-header bg-info bg-opacity-10 py-2 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark small text-uppercase">
                    <i class="bi bi-folder-check me-1 text-info"></i>Berkas Data Diri Pelanggan Kredit
                </h6>
                <a href="{{ route('customers.show', $sale->customer->id) }}" class="btn btn-sm btn-outline-info">Detail Pelanggan</a>
            </div>
            <div class="card-body p-3">
                <div class="row g-2 small">
                    <div class="col-md-3">
                        <strong>NIK KTP:</strong> {{ $sale->customer->nik ?? '-' }}<br>
                        @if($sale->customer->ktp_url)
                            <a href="{{ $sale->customer->ktp_url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1 py-0 px-2"><i class="bi bi-eye"></i> Lihat KTP</a>
                        @else
                            <span class="text-muted">(Belum ada file KTP)</span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <strong>No. KK:</strong> {{ $sale->customer->kk_number ?? '-' }}<br>
                        @if($sale->customer->kk_url)
                            <a href="{{ $sale->customer->kk_url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1 py-0 px-2"><i class="bi bi-eye"></i> Lihat KK</a>
                        @else
                            <span class="text-muted">(Belum ada file KK)</span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <strong>Slip Gaji:</strong><br>
                        @if($sale->customer->salary_slip_url)
                            <a href="{{ $sale->customer->salary_slip_url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1 py-0 px-2"><i class="bi bi-eye"></i> Lihat Slip Gaji</a>
                        @else
                            <span class="text-muted">(Belum ada file Slip Gaji)</span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <strong>NPWP:</strong> {{ $sale->customer->npwp_number ?? '-' }}<br>
                        @if($sale->customer->npwp_url)
                            <a href="{{ $sale->customer->npwp_url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1 py-0 px-2"><i class="bi bi-eye"></i> Lihat NPWP</a>
                        @else
                            <span class="text-muted">(Belum ada file NPWP)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($sale->notes)
        <div class="p-2.5 bg-light rounded border mb-3 notes-box">
            <h6 class="fw-bold text-dark small text-uppercase mb-1" style="font-size: 0.75rem;">Catatan Tambahan:</h6>
            <p class="text-muted mb-0 small" style="font-size: 0.825rem;">{{ $sale->notes }}</p>
        </div>
    @endif

    <!-- Signatures -->
    <div class="row text-center mt-4 pt-2 signature-section">
        <div class="col-6">
            <p class="text-muted signature-space mb-4">Pembeli,</p>
            <p class="fw-bold text-dark mb-0">({{ $sale->customer->name ?? 'Pelanggan' }})</p>
        </div>
        <div class="col-6">
            <p class="text-muted signature-space mb-4">Hormat Kami (MobilQ),</p>
            <p class="fw-bold text-dark mb-0">({{ $sale->user->name ?? 'Admin MobilQ' }})</p>
        </div>
    </div>
</div>
@endsection

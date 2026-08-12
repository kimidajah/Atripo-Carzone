@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Dashboard Admin</h3>
        <p class="text-muted small mb-0">Ringkasan kondisi dan aktivitas operasional Showroom Atripo Carzone Cileunyi</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('sales.create') }}" class="btn btn-gold px-3">
            <i class="bi bi-cart-plus me-1"></i> Transaksi Baru
        </a>
        <a href="{{ route('cars.create') }}" class="btn btn-outline-gold px-3">
            <i class="bi bi-plus-circle me-1"></i> Tambah Mobil
        </a>
    </div>
</div>

<!-- KPI Statistic Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-stat p-3 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Mobil</div>
                    <h2 class="fw-bold mb-0 text-dark">{{ $totalCars }}</h2>
                    <small class="text-muted">Unit terdata di showroom</small>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-car-front"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-stat p-3 bg-white h-100" style="border-left-color: #198754;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Mobil Tersedia</div>
                    <h2 class="fw-bold mb-0 text-success">{{ $availableCars }}</h2>
                    <small class="text-muted">Siap untuk dijual</small>
                </div>
                <div class="stat-icon" style="background: #E8F5E9; color: #2E7D32;">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-stat p-3 bg-white h-100" style="border-left-color: #ffc107;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Mobil Dipesan</div>
                    <h2 class="fw-bold mb-0 text-warning">{{ $reservedCars }}</h2>
                    <small class="text-muted">Dalam proses/booking</small>
                </div>
                <div class="stat-icon" style="background: #FFF8E1; color: #F57F17;">
                    <i class="bi bi-bookmark-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-stat p-3 bg-white h-100" style="border-left-color: #0d6efd;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Mobil Terjual</div>
                    <h2 class="fw-bold mb-0 text-primary">{{ $soldCars }}</h2>
                    <small class="text-muted">Transaksi selesai</small>
                </div>
                <div class="stat-icon" style="background: #E3F2FD; color: #1565C0;">
                    <i class="bi bi-bag-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Sales Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Grafik Penjualan Bulanan</h5>
                <span class="badge bg-light text-dark border">Performa Transaksi</span>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="260"></canvas>
            </div>
        </div>
    </div>

    <!-- Revenue Summary -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0">Total Pendapatan Penjualan</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-center text-center p-4">
                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <div class="text-muted small text-uppercase mb-1 fw-bold">Akumulasi Penjualan</div>
                    <h3 class="fw-extrabold text-warning mb-0">Rp {{ number_format($totalSalesRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="row text-center g-2">
                    <div class="col-6">
                        <div class="p-2 border rounded">
                            <div class="text-muted small">Transaksi</div>
                            <div class="fw-bold fs-5 text-dark">{{ $totalSalesCount }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 p-2 border rounded">
                            <div class="text-muted small">Mobil Terjual</div>
                            <div class="fw-bold fs-5 text-dark">{{ $soldCars }} Unit</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Mobil Terbaru -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Data Mobil Terbaru</h5>
                <a href="{{ route('cars.index') }}" class="btn btn-sm btn-outline-gold">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mobil</th>
                                <th>Tahun</th>
                                <th>Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCars as $car)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $car->brand }} {{ $car->model_type }}</div>
                                        <small class="text-muted">{{ $car->plate_number }}</small>
                                    </td>
                                    <td>{{ $car->year }}</td>
                                    <td class="fw-semibold text-warning">{{ $car->formatted_price }}</td>
                                    <td>
                                        @if($car->status === 'tersedia')
                                            <span class="badge badge-available">TERSEDIA</span>
                                        @elseif($car->status === 'dipesan')
                                            <span class="badge badge-reserved">DIPESAN</span>
                                        @else
                                            <span class="badge badge-sold">TERJUAL</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada data mobil.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Transaksi Terbaru</h5>
                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-gold">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Mobil</th>
                                <th>Pelanggan</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $sale->sale_date->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $sale->invoice_number }}</small>
                                    </td>
                                    <td>{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }}</td>
                                    <td>{{ $sale->customer->name ?? '-' }}</td>
                                    <td class="fw-bold text-dark">{{ $sale->formatted_price }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada transaksi penjualan.</td>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pendapatan Penjualan (Rp)',
                    data: {!! json_encode($chartRevenue) !!},
                    backgroundColor: 'rgba(250, 168, 125, 0.85)',
                    borderColor: '#E07638',
                    borderWidth: 1.5,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toLocaleString('id-ID') + ' Jt';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush

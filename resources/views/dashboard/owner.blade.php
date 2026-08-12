@extends('layouts.app')

@section('title', 'Dashboard Pemilik (Monitoring)')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Dashboard Monitoring Pemilik</h3>
        <p class="text-muted small mb-0">Pemantauan kinerja operasional dan laporan persediaan Showroom Atripo Carzone</p>
    </div>
    <div>
        <span class="badge bg-dark text-warning border border-warning px-3 py-2 fs-6">
            <i class="bi bi-eye-fill me-1"></i> Mode Pemilik (Monitoring Only)
        </span>
    </div>
</div>

<!-- KPI Statistic Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card card-stat p-3 bg-white h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Unit Persediaan</div>
                    <h2 class="fw-bold mb-0 text-dark">{{ $totalCars }}</h2>
                    <small class="text-muted">Mobil terdaftar</small>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-car-front"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card card-stat p-3 bg-white h-100" style="border-left-color: #198754;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Stok Tersedia</div>
                    <h2 class="fw-bold mb-0 text-success">{{ $availableCars }}</h2>
                    <small class="text-muted">Siap untuk dijual</small>
                </div>
                <div class="stat-icon" style="background: #E8F5E9; color: #2E7D32;">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card card-stat p-3 bg-white h-100" style="border-left-color: #0d6efd;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Penjualan</div>
                    <h2 class="fw-bold mb-0 text-primary">Rp {{ number_format($totalSalesRevenue, 0, ',', '.') }}</h2>
                    <small class="text-muted">{{ $totalSalesCount }} Transaksi Selesai</small>
                </div>
                <div class="stat-icon" style="background: #E3F2FD; color: #1565C0;">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Sales Trend Chart -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0">Tren Penjualan Showroom</h5>
            </div>
            <div class="card-body">
                <canvas id="ownerSalesChart" height="260"></canvas>
            </div>
        </div>
    </div>

    <!-- Inventory Distribution Chart -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0">Komposisi Persediaan Kendaraan</h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="statusDoughnutChart" height="240"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Performance & Recent Activity Overview -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Ringkasan Penjualan Terakhir</h5>
        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-gold">Lihat Semua Riwayat</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No Invoice</th>
                        <th>Tanggal</th>
                        <th>Kendaraan</th>
                        <th>Pelanggan</th>
                        <th>Nominal Penjualan</th>
                        <th>Metode Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales as $sale)
                        <tr>
                            <td class="fw-bold text-dark">{{ $sale->invoice_number }}</td>
                            <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                            <td>{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }} ({{ $sale->car->plate_number ?? '' }})</td>
                            <td>{{ $sale->customer->name ?? '-' }}</td>
                            <td class="fw-bold text-warning">{{ $sale->formatted_price }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ strtoupper($sale->payment_method) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi penjualan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sales Trend Line Chart
        const ctxSales = document.getElementById('ownerSalesChart').getContext('2d');
        new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Omset Penjualan (Rp)',
                    data: {!! json_encode($chartRevenue) !!},
                    borderColor: '#FAA87D',
                    backgroundColor: 'rgba(250, 168, 125, 0.18)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(val) { return 'Rp ' + (val/1000000).toLocaleString() + 'Jt'; }
                        }
                    }
                }
            }
        });

        // Status Doughnut Chart
        const ctxDoughnut = document.getElementById('statusDoughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Dipesan', 'Terjual'],
                datasets: [{
                    data: [{{ $availableCars }}, {{ $reservedCars }}, {{ $soldCars }}],
                    backgroundColor: ['#198754', '#ffc107', '#6c757d'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>
@endpush

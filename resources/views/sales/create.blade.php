@extends('layouts.app')

@section('title', 'Transaksi Penjualan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold mb-1">Transaksi Penjualan Baru</h3>
                <p class="text-muted small mb-0">Catat transaksi penjualan kendaraan resmi Showroom Atripo Carzone</p>
            </div>
            <a href="{{ route('sales.index') }}" class="btn btn-outline-gold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                @if($availableCars->isEmpty())
                    <div class="alert alert-warning border-0 p-4 text-center">
                        <i class="bi bi-exclamation-triangle-fill display-5 d-block mb-2 text-warning"></i>
                        <h5 class="fw-bold">Tidak Ada Mobil Tersedia</h5>
                        <p class="mb-3">Saat ini tidak ada unit mobil dengan status TERSEDIA atau DIPESAN yang dapat dijual.</p>
                        <a href="{{ route('cars.create') }}" class="btn btn-gold btn-sm px-3">+ Tambah Mobil Baru</a>
                    </div>
                @else
                    <form action="{{ route('sales.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3 mb-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Pilih Unit Kendaraan & Pelanggan</h6>

                            <div class="col-md-12">
                                <label for="car_id" class="form-label fw-semibold">Mobil Yang Dijual <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg @error('car_id') is-invalid @enderror" id="car_id" name="car_id" required onchange="updatePrice(this)">
                                    <option value="" data-price="0">-- Pilih Mobil Tersedia --</option>
                                    @foreach($availableCars as $car)
                                        <option value="{{ $car->id }}" data-price="{{ (int)$car->price }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                            {{ $car->brand }} {{ $car->model_type }} ({{ $car->year }}) - Nopol: {{ $car->plate_number }} | Harga Stok: {{ $car->formatted_price }} [Status: {{ strtoupper($car->status) }}]
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Hanya menampilkan kendaraan yang belum berstatus TERJUAL.</small>
                                @error('car_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="customer_id" class="form-label fw-semibold mb-1">Pelanggan Pembeli <span class="text-danger">*</span></label>
                                    <a href="{{ route('customers.create') }}" class="small text-warning fw-bold text-decoration-none" target="_blank">+ Pelanggan Baru</a>
                                </div>
                                <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} - {{ $customer->phone }} ({{ $customer->address }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <h6 class="fw-bold text-dark border-bottom pb-2 my-4">Rincian Transaksi & Pembayaran</h6>

                            <div class="col-md-4">
                                <label for="sale_date" class="form-label fw-semibold">Tanggal Transaksi <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('sale_date') is-invalid @enderror" id="sale_date" name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required>
                                @error('sale_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="sale_price" class="form-label fw-semibold">Harga Penjualan Deal (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" step="100000" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" placeholder="Masukkan harga kesepakatan" required>
                                </div>
                                @error('sale_price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="payment_method" class="form-label fw-semibold">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash / Tunai</option>
                                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <label for="notes" class="form-label fw-semibold">Catatan Transaksi (Opsional)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Contoh: Pembayaran lunas via transfer Bank BCA, termasuk pengurusan balik nama.">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded border mb-4">
                            <div class="d-flex align-items-center text-dark">
                                <i class="bi bi-info-circle-fill text-warning me-2 fs-5"></i>
                                <div class="small">
                                    <strong>Perhatian Logika Transaksi:</strong> Setelah transaksi disimpan, status kendaraan yang dipilih akan <strong>secara otomatis diperbarui menjadi TERJUAL</strong> dan tidak dapat dijual kembali.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-gold px-4">
                                <i class="bi bi-check-circle me-1"></i> Simpan Transaksi Penjualan
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updatePrice(select) {
        const selectedOption = select.options[select.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        const priceInput = document.getElementById('sale_price');
        if (price && price > 0 && (!priceInput.value || priceInput.value == 0)) {
            priceInput.value = price;
        }
    }
</script>
@endpush

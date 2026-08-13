@extends('layouts.app')

@section('title', 'Tambah Mobil Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1 page-header-title">Tambah Mobil Baru</h3>
                <p class="text-muted small mb-0 page-header-subtitle">Isi formulir lengkap data kendaraan di bawah ini</p>
            </div>
            <a href="{{ route('cars.index') }}" class="btn btn-outline-gold w-100 w-sm-auto text-center">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3 mb-4">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Informasi Utama Kendaraan</h6>

                        <div class="col-md-6">
                            <label for="brand" class="form-label fw-semibold">Merek Mobil <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand') }}" placeholder="Contoh: Toyota, Honda, Mitsubishi" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="model_type" class="form-label fw-semibold">Tipe & Varian <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model_type') is-invalid @enderror" id="model_type" name="model_type" value="{{ old('model_type') }}" placeholder="Contoh: Avanza 1.5 G CVT" required>
                            @error('model_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="year" class="form-label fw-semibold">Tahun Produksi <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', date('Y')) }}" min="1990" max="{{ date('Y') + 1 }}" required>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="color" class="form-label fw-semibold">Warna Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color') }}" placeholder="Contoh: Hitam Metalik" required>
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="transmission" class="form-label fw-semibold">Jenis Transmisi <span class="text-danger">*</span></label>
                            <select class="form-select @error('transmission') is-invalid @enderror" id="transmission" name="transmission" required>
                                <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic (A/T)</option>
                                <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual (M/T)</option>
                            </select>
                            @error('transmission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h6 class="fw-bold text-dark border-bottom pb-2 my-4">Spesifikasi Legalitas & Harga</h6>

                        <div class="col-md-4">
                            <label for="plate_number" class="form-label fw-semibold">Nomor Polisi (Nopol) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase @error('plate_number') is-invalid @enderror" id="plate_number" name="plate_number" value="{{ old('plate_number') }}" placeholder="Contoh: D 1234 ABC" required>
                            @error('plate_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="price" class="form-label fw-semibold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" step="100000" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="Contoh: 250000000" required>
                            </div>
                            @error('price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label fw-semibold">Status Stok <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>TERSEDIA</option>
                                <option value="dipesan" {{ old('status') == 'dipesan' ? 'selected' : '' }}>DIPESAN</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>PENDING</option>
                                <option value="terjual" {{ old('status') == 'terjual' ? 'selected' : '' }}>TERJUAL</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-3">
                            <label for="image" class="form-label fw-semibold">Foto Mobil (Opsional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                            <small class="text-muted">Format: JPG, PNG, WEBP. Ukuran maksimal 2MB.</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary px-4 text-center">Batal</a>
                        <button type="submit" class="btn btn-gold px-4">
                            <i class="bi bi-save me-1"></i> Simpan Data Mobil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

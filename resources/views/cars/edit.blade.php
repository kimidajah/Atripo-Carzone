@extends('layouts.app')

@section('title', 'Edit Data Mobil')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold mb-1">Edit Data Mobil</h3>
                <p class="text-muted small mb-0">Perbarui informasi kendaraan {{ $car->brand }} {{ $car->model_type }}</p>
            </div>
            <a href="{{ route('cars.index') }}" class="btn btn-outline-gold">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3 mb-4">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Informasi Utama Kendaraan</h6>

                        <div class="col-md-6">
                            <label for="brand" class="form-label fw-semibold">Merek Mobil <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand', $car->brand) }}" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="model_type" class="form-label fw-semibold">Tipe & Varian <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model_type') is-invalid @enderror" id="model_type" name="model_type" value="{{ old('model_type', $car->model_type) }}" required>
                            @error('model_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="year" class="form-label fw-semibold">Tahun Produksi <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', $car->year) }}" required>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="color" class="form-label fw-semibold">Warna Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color', $car->color) }}" required>
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="transmission" class="form-label fw-semibold">Jenis Transmisi <span class="text-danger">*</span></label>
                            <select class="form-select @error('transmission') is-invalid @enderror" id="transmission" name="transmission" required>
                                <option value="Automatic" {{ old('transmission', $car->transmission) == 'Automatic' ? 'selected' : '' }}>Automatic (A/T)</option>
                                <option value="Manual" {{ old('transmission', $car->transmission) == 'Manual' ? 'selected' : '' }}>Manual (M/T)</option>
                            </select>
                            @error('transmission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h6 class="fw-bold text-dark border-bottom pb-2 my-4">Spesifikasi Legalitas & Harga</h6>

                        <div class="col-md-4">
                            <label for="plate_number" class="form-label fw-semibold">Nomor Polisi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase @error('plate_number') is-invalid @enderror" id="plate_number" name="plate_number" value="{{ old('plate_number', $car->plate_number) }}" required>
                            @error('plate_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="price" class="form-label fw-semibold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" step="100000" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', (int)$car->price) }}" required>
                            </div>
                            @error('price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label fw-semibold">Status Stok <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="tersedia" {{ old('status', $car->status) == 'tersedia' ? 'selected' : '' }}>TERSDIA</option>
                                <option value="dipesan" {{ old('status', $car->status) == 'dipesan' ? 'selected' : '' }}>DIPESAN</option>
                                <option value="terjual" {{ old('status', $car->status) == 'terjual' ? 'selected' : '' }}>TERJUAL</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-3">
                            <label for="image" class="form-label fw-semibold">Ganti Foto Mobil (Opsional)</label>
                            @if($car->image && Storage::disk('public')->exists($car->image))
                                <div class="mb-2">
                                    <img src="{{ asset('uploads/' . $car->image) }}" alt="Foto {{ $car->brand }}" class="rounded img-thumbnail" style="max-height: 120px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-gold px-4">
                            <i class="bi bi-save me-1"></i> Perbarui Data Mobil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

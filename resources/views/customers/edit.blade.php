@extends('layouts.app')

@section('title', 'Edit Data Pelanggan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold mb-1 page-header-title">Edit Data Pelanggan</h3>
                <p class="text-muted small mb-0 page-header-subtitle">Perbarui data kontak dan berkas dokumen {{ $customer->name }}</p>
            </div>
            <a href="{{ route('customers.index') }}" class="btn btn-outline-gold">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                        <i class="bi bi-person-badge-fill me-2 text-gold"></i>Informasi Kontak Utama
                    </h6>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Nomor Telepon / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Alamat Email (Opsional)</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $customer->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label fw-semibold">Alamat Lengkap Domisili <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2" required>{{ old('address', $customer->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 my-4">
                        <i class="bi bi-file-earmark-lock-fill me-2 text-info"></i>Data Diri & Berkas Syarat Kredit (KTP, KK, Slip Gaji, NPWP)
                    </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="nik" class="form-label fw-semibold">NIK (No. KTP)</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $customer->nik) }}" placeholder="16 digit NIK">
                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="kk_number" class="form-label fw-semibold">Nomor Kartu Keluarga (KK)</label>
                            <input type="text" class="form-control @error('kk_number') is-invalid @enderror" id="kk_number" name="kk_number" value="{{ old('kk_number', $customer->kk_number) }}" placeholder="16 digit No KK">
                            @error('kk_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="npwp_number" class="form-label fw-semibold">Nomor NPWP</label>
                            <input type="text" class="form-control @error('npwp_number') is-invalid @enderror" id="npwp_number" name="npwp_number" value="{{ old('npwp_number', $customer->npwp_number) }}" placeholder="Nomor Seri NPWP">
                            @error('npwp_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="ktp_file" class="form-label fw-semibold">Ganti / Upload File KTP</label>
                            <input type="file" class="form-control @error('ktp_file') is-invalid @enderror" id="ktp_file" name="ktp_file" accept=".jpg,.jpeg,.png,.pdf">
                            @if($customer->ktp_url)
                                <div class="mt-1 small text-success">
                                    <i class="bi bi-check-circle-fill"></i> Berkas KTP sudah diunggah. <a href="{{ $customer->ktp_url }}" target="_blank" class="fw-bold">Lihat File KTP</a>
                                </div>
                            @endif
                            @error('ktp_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="kk_file" class="form-label fw-semibold">Ganti / Upload File Kartu Keluarga (KK)</label>
                            <input type="file" class="form-control @error('kk_file') is-invalid @enderror" id="kk_file" name="kk_file" accept=".jpg,.jpeg,.png,.pdf">
                            @if($customer->kk_url)
                                <div class="mt-1 small text-success">
                                    <i class="bi bi-check-circle-fill"></i> Berkas KK sudah diunggah. <a href="{{ $customer->kk_url }}" target="_blank" class="fw-bold">Lihat File KK</a>
                                </div>
                            @endif
                            @error('kk_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="salary_slip_file" class="form-label fw-semibold">Ganti / Upload Slip Gaji</label>
                            <input type="file" class="form-control @error('salary_slip_file') is-invalid @enderror" id="salary_slip_file" name="salary_slip_file" accept=".jpg,.jpeg,.png,.pdf">
                            @if($customer->salary_slip_url)
                                <div class="mt-1 small text-success">
                                    <i class="bi bi-check-circle-fill"></i> Slip Gaji sudah diunggah. <a href="{{ $customer->salary_slip_url }}" target="_blank" class="fw-bold">Lihat Slip Gaji</a>
                                </div>
                            @endif
                            @error('salary_slip_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="npwp_file" class="form-label fw-semibold">Ganti / Upload File NPWP</label>
                            <input type="file" class="form-control @error('npwp_file') is-invalid @enderror" id="npwp_file" name="npwp_file" accept=".jpg,.jpeg,.png,.pdf">
                            @if($customer->npwp_url)
                                <div class="mt-1 small text-success">
                                    <i class="bi bi-check-circle-fill"></i> File NPWP sudah diunggah. <a href="{{ $customer->npwp_url }}" target="_blank" class="fw-bold">Lihat File NPWP</a>
                                </div>
                            @endif
                            @error('npwp_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-gold px-4">
                            <i class="bi bi-save me-1"></i> Perbarui Pelanggan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

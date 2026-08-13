@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4">
            <div>
                <h3 class="fw-bold mb-1 page-header-title">Profil Pengguna</h3>
                <p class="text-muted small mb-0 page-header-subtitle">Kelola data profil dan keamanan kata sandi akun Anda</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-column flex-sm-row align-items-center gap-3 mb-4 pb-3 border-bottom text-center text-sm-start">
                    <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 70px; height: 70px; font-size: 1.8rem; border: 3px solid #FAA87D;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">{{ $user->name }}</h4>
                        <div class="d-flex flex-wrap justify-content-center justify-content-sm-start align-items-center gap-2">
                            <span class="badge {{ $user->isAdmin() ? 'badge-role-admin' : 'badge-role-owner' }} px-3 py-1">
                                {{ strtoupper($user->role) }}
                            </span>
                            <span class="text-muted small">Username: <strong>{{ $user->username }}</strong></span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Informasi Akun</h6>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Nomor Telepon / WA</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 my-4">Ubah Kata Sandi (Opsional)</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="current_password" class="form-label fw-semibold">Password Lama</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Password lama">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="new_password" class="form-label fw-semibold">Password Baru</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" placeholder="Password baru">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="new_password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end pt-3 border-top">
                        <button type="submit" class="btn btn-gold px-4 w-100 w-sm-auto">
                            <i class="bi bi-save me-1"></i> Perbarui Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

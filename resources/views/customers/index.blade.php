@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 page-header-title">Data Pelanggan</h3>
        <p class="text-muted small mb-0 page-header-subtitle">Kelola data pembeli dan berkas persyaratan kredit Showroom MobilQ</p>
    </div>
    @if(Auth::user()->canManageCustomers())
        <a href="{{ route('customers.create') }}" class="btn btn-gold px-3 w-100 w-sm-auto text-center">
            <i class="bi bi-person-plus me-1"></i> Tambah Pelanggan
        </a>
    @endif
</div>

<!-- Search Bar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('customers.index') }}" method="GET" class="row g-2">
            <div class="col-12 col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari nama, NIK KTP, KK, NPWP, atau nomor telepon pelanggan..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-gold w-100"><i class="bi bi-search me-1"></i> Cari</button>
            </div>
        </form>
    </div>
</div>

<!-- Table Listing -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Pelanggan</th>
                        <th>NIK KTP / Kontak</th>
                        <th>Alamat</th>
                        <th>Status Berkas Kredit</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $index => $customer)
                        <tr>
                            <td>{{ $customers->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $customer->name }}</div>
                                @if($customer->email)
                                    <small class="text-muted">{{ $customer->email }}</small>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <span class="badge bg-light text-dark border font-monospace"><i class="bi bi-telephone text-warning me-1"></i>{{ $customer->phone }}</span>
                                @if($customer->nik)
                                    <div class="small text-muted font-monospace mt-1" style="font-size: 0.75rem;">NIK: {{ $customer->nik }}</div>
                                @endif
                            </td>
                            <td><span class="text-muted small">{{ Str::limit($customer->address, 45) }}</span></td>
                            <td class="text-nowrap">
                                @if($customer->has_credit_documents)
                                    <span class="badge bg-success"><i class="bi bi-folder-check me-1"></i>Berkas Ada</span>
                                @else
                                    <span class="badge bg-light text-muted border">Belum Lengkap</span>
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-outline-gold" title="Detail Pelanggan & Berkas">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(Auth::user()->canManageCustomers())
                                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-outline-primary" title="Edit Data & Berkas">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCustModal{{ $customer->id }}" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>

                                @if(Auth::user()->canManageCustomers())
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteCustModal{{ $customer->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title fs-6 fw-bold">Konfirmasi Hapus Pelanggan</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start py-3">
                                                    Apakah Anda yakin ingin menghapus data pelanggan <strong>{{ $customer->name }}</strong>?
                                                    <p class="text-danger small mt-2 mb-0"><i class="bi bi-exclamation-triangle-fill me-1"></i> Tindakan ini tidak dapat dibatalkan.</p>
                                                </div>
                                                <div class="modal-footer bg-light border-0">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Ya, Hapus Data</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x display-6 d-block mb-2 text-secondary"></i>
                                Belum ada data pelanggan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($customers->hasPages())
        <div class="card-footer bg-white py-3 border-0 d-flex justify-content-end">
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection

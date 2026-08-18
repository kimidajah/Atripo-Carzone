@extends('layouts.app')

@section('title', 'Data Mobil')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 page-header-title">Data Mobil</h3>
        <p class="text-muted small mb-0 page-header-subtitle">Kelola armada kendaraan yang tersedia di MobilQ Cileunyi</p>
    </div>
    <div class="d-flex flex-wrap gap-2 w-100 w-sm-auto">
        <!-- View Switcher Buttons -->
        <div class="btn-group flex-grow-1 flex-sm-grow-0" role="group" aria-label="Modus Tampilan">
            <a href="{{ request()->fullUrlWithQuery(['view' => 'table']) }}" class="btn btn-sm {{ request('view', 'table') == 'table' ? 'btn-gold' : 'btn-outline-gold' }}" title="Tampilan Tabel">
                <i class="bi bi-table me-1"></i> Tabel
            </a>
            <a href="{{ request()->fullUrlWithQuery(['view' => 'card']) }}" class="btn btn-sm {{ request('view') == 'card' ? 'btn-gold' : 'btn-outline-gold' }}" title="Tampilan Card (Gambar Besar)">
                <i class="bi bi-grid-fill me-1"></i> Card
            </a>
        </div>

        @if(Auth::user()->canManageCars())
            <a href="{{ route('cars.create') }}" class="btn btn-gold btn-sm px-3 d-flex align-items-center justify-content-center flex-grow-1 flex-sm-grow-0">
                <i class="bi bi-plus-circle me-1"></i> Tambah Mobil Baru
            </a>
        @endif
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('cars.index') }}" method="GET" class="row g-2 align-items-center">
            <input type="hidden" name="view" value="{{ request('view', 'table') }}">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari berdasarkan merek, tipe, atau no nopol..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select bg-light" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipesan" {{ request('status') == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="terjual" {{ request('status') == 'terjual' ? 'selected' : '' }}>Terjual</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="brand" class="form-select bg-light" onchange="this.form.submit()">
                    <option value="all" {{ request('brand') == 'all' ? 'selected' : '' }}>Semua Merek</option>
                    @foreach($brands as $b)
                        <option value="{{ $b }}" {{ request('brand') == $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-1">
                <button type="submit" class="btn btn-gold w-100"><i class="bi bi-filter me-1"></i> <span class="d-md-none">Filter</span></button>
            </div>
        </form>
    </div>
</div>

@if(request('view') == 'card')
    <!-- ==================== TAMPILAN CARD GRID (GAMBAR BESAR) ==================== -->
    <div class="row g-3 g-md-4 mb-4">
        @forelse($cars as $car)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm h-100 overflow-hidden card-stat">
                    <!-- Image Box with Badge -->
                    <div class="position-relative bg-dark" style="height: 200px; overflow: hidden;">
                        @if($car->image && Storage::disk('public')->exists($car->image))
                            <img src="{{ asset('uploads/' . $car->image) }}" alt="{{ $car->brand }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted">
                                <i class="bi bi-car-front text-warning display-4"></i>
                                <span class="small text-white-50 mt-1">MOBILQ</span>
                            </div>
                        @endif
                        
                        <!-- Status Badge Overlay -->
                        <div class="position-absolute top-0 end-0 m-2">
                            @if($car->status === 'tersedia')
                                <span class="badge badge-available shadow-sm px-2.5 py-1.5">TERSEDIA</span>
                            @elseif($car->status === 'dipesan')
                                <span class="badge badge-reserved shadow-sm px-2.5 py-1.5">DIPESAN</span>
                            @elseif($car->status === 'pending')
                                <span class="badge bg-secondary shadow-sm px-2.5 py-1.5">PENDING</span>
                            @else
                                <span class="badge badge-sold shadow-sm px-2.5 py-1.5">TERJUAL</span>
                            @endif
                        </div>

                        <!-- Year Badge Overlay -->
                        <div class="position-absolute bottom-0 start-0 m-2">
                            <span class="badge bg-dark bg-opacity-75 text-white font-monospace border border-secondary">{{ $car->year }}</span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="small text-muted text-uppercase fw-bold">{{ $car->brand }}</div>
                            <h5 class="fw-bold text-dark mb-1 text-truncate" title="{{ $car->model_type }}">{{ $car->model_type }}</h5>
                            <div class="fw-extrabold text-warning fs-5 mb-3">{{ $car->formatted_price }}</div>

                            <!-- Specs List -->
                            <div class="row g-2 text-muted small border-top pt-2 mb-3">
                                <div class="col-6">
                                    <i class="bi bi-gear-fill me-1 text-warning"></i> {{ $car->transmission }}
                                </div>
                                <div class="col-6">
                                    <i class="bi bi-palette-fill me-1 text-warning"></i> {{ $car->color }}
                                </div>
                                <div class="col-12 mt-1">
                                    <i class="bi bi-credit-card-2-front-fill me-1 text-warning"></i> Nopol: <span class="font-monospace fw-bold text-dark">{{ $car->plate_number }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-1 border-top pt-2">
                            <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-outline-dark flex-grow-1" title="Detail">
                                <i class="bi bi-eye me-1"></i> Detail
                            </a>
                            @if(Auth::user()->canManageCars())
                                <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModalGrid{{ $car->id }}" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                @if(Auth::user()->canManageCars())
                    <!-- Delete Modal Grid -->
                    <div class="modal fade" id="deleteModalGrid{{ $car->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title fs-6 fw-bold">Konfirmasi Hapus Mobil</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start py-3">
                                    Apakah Anda yakin ingin menghapus data mobil <strong>{{ $car->brand }} {{ $car->model_type }} ({{ $car->plate_number }})</strong>?
                                    <p class="text-danger small mt-2 mb-0"><i class="bi bi-exclamation-triangle-fill me-1"></i> Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                                <div class="modal-footer bg-light border-0">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('cars.destroy', $car) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Ya, Hapus Data</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted bg-white rounded shadow-sm">
                <i class="bi bi-inbox display-6 d-block mb-2 text-secondary"></i>
                Belum ada data mobil yang sesuai dengan pencarian/filter.
            </div>
        @endforelse
    </div>
@else
    <!-- ==================== TAMPILAN TABEL ==================== -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Foto</th>
                            <th>Merek & Tipe</th>
                            <th>Tahun</th>
                            <th>Transmisi</th>
                            <th>No. Polisi</th>
                            <th>Harga Jual</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cars as $car)
                            <tr>
                                <td>
                                    @if($car->image && Storage::disk('public')->exists($car->image))
                                        <img src="{{ asset('uploads/' . $car->image) }}" alt="{{ $car->brand }}" class="rounded img-thumbnail" style="width: 65px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center text-muted" style="width: 65px; height: 48px;">
                                            <i class="bi bi-car-front fs-4"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $car->brand }} {{ $car->model_type }}</div>
                                    <small class="text-muted">Warna: {{ $car->color }}</small>
                                </td>
                                <td class="text-nowrap"><span class="badge bg-light text-dark border">{{ $car->year }}</span></td>
                                <td class="text-nowrap">{{ $car->transmission }}</td>
                                <td class="text-nowrap"><span class="font-monospace fw-semibold">{{ $car->plate_number }}</span></td>
                                <td class="fw-bold text-warning text-nowrap">{{ $car->formatted_price }}</td>
                                <td class="text-nowrap">
                                    @if($car->status === 'tersedia')
                                        <span class="badge badge-available">TERSEDIA</span>
                                    @elseif($car->status === 'dipesan')
                                        <span class="badge badge-reserved">DIPESAN</span>
                                    @elseif($car->status === 'pending')
                                        <span class="badge bg-secondary">PENDING</span>
                                    @else
                                        <span class="badge badge-sold">TERJUAL</span>
                                    @endif
                                </td>
                                <td class="text-center text-nowrap">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('cars.show', $car) }}" class="btn btn-outline-dark" title="Detail Mobil">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(Auth::user()->canManageCars())
                                            <a href="{{ route('cars.edit', $car) }}" class="btn btn-outline-primary" title="Edit Data">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $car->id }}" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </div>

                                    @if(Auth::user()->canManageCars())
                                        <!-- Delete Modal -->
                                        <div class="modal fade text-start" id="deleteModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title fs-6 fw-bold">Konfirmasi Hapus Mobil</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body py-3">
                                                        Apakah Anda yakin ingin menghapus data mobil <strong>{{ $car->brand }} {{ $car->model_type }} ({{ $car->plate_number }})</strong>?
                                                        <p class="text-danger small mt-2 mb-0"><i class="bi bi-exclamation-triangle-fill me-1"></i> Tindakan ini tidak dapat dibatalkan.</p>
                                                    </div>
                                                    <div class="modal-footer bg-light border-0">
                                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('cars.destroy', $car) }}" method="POST">
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
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox display-6 d-block mb-2 text-secondary"></i>
                                    Belum ada data mobil yang sesuai dengan pencarian/filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@if($cars->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $cars->links() }}
    </div>
@endif
@endsection

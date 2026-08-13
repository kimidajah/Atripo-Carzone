@extends('layouts.app')

@section('title', 'Transaksi Penjualan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1 page-header-title">Transaksi Penjualan Baru</h3>
                <p class="text-muted small mb-0 page-header-subtitle">Catat transaksi penjualan kendaraan tunai (cash) maupun kredit resmi Showroom Atripo Carzone</p>
            </div>
            <a href="{{ route('sales.index') }}" class="btn btn-outline-gold w-100 w-sm-auto text-center">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">
                @if($availableCars->isEmpty())
                    <div class="alert alert-warning border-0 p-4 text-center">
                        <i class="bi bi-exclamation-triangle-fill display-5 d-block mb-2 text-warning"></i>
                        <h5 class="fw-bold">Tidak Ada Mobil Tersedia</h5>
                        <p class="mb-3">Saat ini tidak ada unit mobil dengan status TERSEDIA atau DIPESAN yang dapat dijual.</p>
                        <a href="{{ route('cars.create') }}" class="btn btn-gold btn-sm px-3">+ Tambah Mobil Baru</a>
                    </div>
                @else
                    <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data" id="saleForm">
                        @csrf
                        
                        <div class="row g-3 mb-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="bi bi-car-front me-2 text-gold"></i>Pilih Unit Kendaraan & Pelanggan
                            </h6>

                            <div class="col-md-12">
                                <label for="car_id" class="form-label fw-semibold">Mobil Yang Dijual <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg @error('car_id') is-invalid @enderror" id="car_id" name="car_id" required onchange="updateCarPrice(this)">
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
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="customer_id" class="form-label fw-semibold mb-0">Pelanggan Pembeli <span class="text-danger">*</span></label>
                                    <a href="{{ route('customers.create') }}" class="small text-warning fw-bold text-decoration-none" target="_blank">+ Pelanggan Baru</a>
                                </div>
                                <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required onchange="onCustomerChange(this)">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" 
                                                data-nik="{{ $customer->nik }}"
                                                data-kk="{{ $customer->kk_number }}"
                                                data-npwp="{{ $customer->npwp_number }}"
                                                data-has-ktp="{{ $customer->ktp_file ? '1' : '0' }}"
                                                data-has-kk-file="{{ $customer->kk_file ? '1' : '0' }}"
                                                data-has-slip="{{ $customer->salary_slip_file ? '1' : '0' }}"
                                                data-has-npwp-file="{{ $customer->npwp_file ? '1' : '0' }}"
                                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} - {{ $customer->phone }} {{ $customer->nik ? '(NIK: ' . $customer->nik . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <h6 class="fw-bold text-dark border-bottom pb-2 my-4">
                                <i class="bi bi-wallet2 me-2 text-gold"></i>Skema Transaksi & Pembayaran
                            </h6>

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
                                    <input type="number" step="100000" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" placeholder="Contoh: 100000000" required oninput="calculateCredit()">
                                </div>
                                @error('sale_price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="payment_type" class="form-label fw-semibold">Tipe Pembelian <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_type') is-invalid @enderror" id="payment_type" name="payment_type" required onchange="togglePaymentType(this.value)">
                                    <option value="cash" {{ old('payment_type', 'cash') == 'cash' ? 'selected' : '' }}>Cash / Tunai Lunas</option>
                                    <option value="credit" {{ old('payment_type') == 'credit' ? 'selected' : '' }}>Kredit Mobil (Cicilan)</option>
                                </select>
                                @error('payment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="payment_method" class="form-label fw-semibold">Metode Pembayaran DP / Pelunasan <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai / Cash Desk</option>
                                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- SKEMA KREDIT SECTION -->
                            <div id="credit_schema_section" class="col-12 mt-4" style="display: {{ old('payment_type') == 'credit' ? 'block' : 'none' }};">
                                <div class="card border-warning border-opacity-50 bg-light-warning">
                                    <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                                        <h6 class="fw-bold mb-0 text-dark">
                                            <i class="bi bi-calculator-fill me-2 text-warning"></i>Input Skema Kredit & Perhitungan Simulasi (Input Admin)
                                        </h6>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="dp_amount" class="form-label fw-semibold">Nominal Uang Muka / DP (Rp) <span class="text-danger credit-asterisk">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" step="100000" class="form-control @error('dp_amount') is-invalid @enderror" id="dp_amount" name="dp_amount" value="{{ old('dp_amount') }}" placeholder="Contoh: 20000000" oninput="calculateCredit()">
                                                </div>
                                                <small class="text-muted">Nominal DP murni yang dibayar pembeli.</small>
                                                @error('dp_amount')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="tenor_months" class="form-label fw-semibold">Tenor Cicilan (Bulan) <span class="text-danger credit-asterisk">*</span></label>
                                                <select class="form-select @error('tenor_months') is-invalid @enderror" id="tenor_months" name="tenor_months" onchange="calculateCredit()">
                                                    <option value="12" {{ old('tenor_months') == 12 ? 'selected' : '' }}>12 Bulan (1 Tahun)</option>
                                                    <option value="24" {{ old('tenor_months') == 24 ? 'selected' : '' }}>24 Bulan (2 Tahun)</option>
                                                    <option value="36" {{ old('tenor_months', 36) == 36 ? 'selected' : '' }}>36 Bulan (3 Tahun)</option>
                                                    <option value="48" {{ old('tenor_months') == 48 ? 'selected' : '' }}>48 Bulan (4 Tahun)</option>
                                                    <option value="60" {{ old('tenor_months') == 60 ? 'selected' : '' }}>60 Bulan (5 Tahun)</option>
                                                </select>
                                                @error('tenor_months')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="interest_rate_per_year" class="form-label fw-semibold">Suku Bunga Flat (% / Tahun) <span class="text-danger credit-asterisk">*</span></label>
                                                <div class="input-group">
                                                    <input type="number" step="0.1" class="form-control @error('interest_rate_per_year') is-invalid @enderror" id="interest_rate_per_year" name="interest_rate_per_year" value="{{ old('interest_rate_per_year', '6.0') }}" placeholder="Contoh: 6.0" oninput="calculateCredit()">
                                                    <span class="input-group-text">% p.a.</span>
                                                </div>
                                                <small class="text-muted">Semakin lama tenor, suku bunga dapat disesuaikan admin.</small>
                                                @error('interest_rate_per_year')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- LIVE SIMULATION DISPLAY CARD -->
                                            <div class="col-12 mt-3">
                                                <div class="p-3 bg-dark text-white rounded shadow-sm">
                                                    <div class="row text-center g-2">
                                                        <div class="col-md-4 border-end border-secondary">
                                                            <div class="text-white-50 small">Pokok Utang (Harga - DP)</div>
                                                            <div class="fs-5 fw-bold text-warning" id="sim_principal">Rp 0</div>
                                                        </div>
                                                        <div class="col-md-4 border-end border-secondary">
                                                            <div class="text-white-50 small">Total Nominal Bunga</div>
                                                            <div class="fs-5 fw-bold text-warning" id="sim_total_interest">Rp 0</div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="text-white-50 small">Estimasi Cicilan per Bulan</div>
                                                            <div class="fs-4 fw-bold text-gold" id="sim_monthly">Rp 0 / bln</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DOKUMEN PELANGGAN CREDIT SECTION -->
                            <div id="credit_document_section" class="col-12 mt-4" style="display: {{ old('payment_type') == 'credit' ? 'block' : 'none' }};">
                                <div class="card border-info border-opacity-50">
                                    <div class="card-header bg-info bg-opacity-10 border-0 py-3 d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold mb-0 text-dark">
                                            <i class="bi bi-file-earmark-person-fill me-2 text-info"></i>Kelengkapan Data Diri & Berkas Pelanggan Kredit
                                        </h6>
                                        <span class="badge bg-danger text-white fw-bold">Semua data & dokumen WAJIB diisi</span>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="nik" class="form-label fw-semibold">NIK KTP Pelanggan <span class="text-danger credit-asterisk">*</span></label>
                                                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK di KTP">
                                                @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="kk_number" class="form-label fw-semibold">Nomor Kartu Keluarga (KK) <span class="text-danger credit-asterisk">*</span></label>
                                                <input type="text" class="form-control @error('kk_number') is-invalid @enderror" id="kk_number" name="kk_number" value="{{ old('kk_number') }}" placeholder="16 digit No KK">
                                                @error('kk_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="npwp_number" class="form-label fw-semibold">Nomor NPWP <span class="text-danger credit-asterisk">*</span></label>
                                                <input type="text" class="form-control @error('npwp_number') is-invalid @enderror" id="npwp_number" name="npwp_number" value="{{ old('npwp_number') }}" placeholder="Nomor Seri NPWP">
                                                @error('npwp_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="ktp_file" class="form-label fw-semibold">File / Foto Scan KTP <span class="text-danger credit-asterisk">*</span></label>
                                                <input type="file" class="form-control @error('ktp_file') is-invalid @enderror" id="ktp_file" name="ktp_file" accept=".jpg,.jpeg,.png,.pdf">
                                                <small class="text-muted">Format: JPG, PNG, PDF (Maks 2MB). <span id="ktp_file_status" class="text-success fw-bold"></span></small>
                                                @error('ktp_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="kk_file" class="form-label fw-semibold">File / Foto Scan Kartu Keluarga (KK) <span class="text-danger credit-asterisk">*</span></label>
                                                <input type="file" class="form-control @error('kk_file') is-invalid @enderror" id="kk_file" name="kk_file" accept=".jpg,.jpeg,.png,.pdf">
                                                <small class="text-muted">Format: JPG, PNG, PDF (Maks 2MB). <span id="kk_file_status" class="text-success fw-bold"></span></small>
                                                @error('kk_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="salary_slip_file" class="form-label fw-semibold">File / Scan Slip Gaji / Catatan Penghasilan <span class="text-danger credit-asterisk">*</span></label>
                                                <input type="file" class="form-control @error('salary_slip_file') is-invalid @enderror" id="salary_slip_file" name="salary_slip_file" accept=".jpg,.jpeg,.png,.pdf">
                                                <small class="text-muted">Bukti penghasilan / Slip Gaji 3 bulan terakhir. <span id="salary_slip_file_status" class="text-success fw-bold"></span></small>
                                                @error('salary_slip_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6 mt-3">
                                                <label for="npwp_file" class="form-label fw-semibold">File / Scan Kartu NPWP <span class="text-danger credit-asterisk">*</span></label>
                                                <input type="file" class="form-control @error('npwp_file') is-invalid @enderror" id="npwp_file" name="npwp_file" accept=".jpg,.jpeg,.png,.pdf">
                                                <small class="text-muted">Format: JPG, PNG, PDF (Maks 2MB). <span id="npwp_file_status" class="text-success fw-bold"></span></small>
                                                @error('npwp_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <label for="notes" class="form-label fw-semibold">Catatan Transaksi (Opsional)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Contoh: Pembayaran DP via Transfer BCA, berkas kredit lengkap disetujui leasing.">{{ old('notes') }}</textarea>
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

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary px-4 text-center">Batal</a>
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
    function updateCarPrice(select) {
        const selectedOption = select.options[select.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        const priceInput = document.getElementById('sale_price');
        if (price && price > 0 && (!priceInput.value || priceInput.value == 0)) {
            priceInput.value = price;
        }
        calculateCredit();
    }

    function togglePaymentType(type) {
        const schemaSec = document.getElementById('credit_schema_section');
        const docSec = document.getElementById('credit_document_section');

        if (type === 'credit') {
            schemaSec.style.display = 'block';
            docSec.style.display = 'block';
            updateCreditRequirements(true);
            calculateCredit();
        } else {
            schemaSec.style.display = 'none';
            docSec.style.display = 'none';
            updateCreditRequirements(false);
        }
    }

    function updateCreditRequirements(isCredit) {
        const dpInput = document.getElementById('dp_amount');
        const tenorInput = document.getElementById('tenor_months');
        const rateInput = document.getElementById('interest_rate_per_year');

        const nikInput = document.getElementById('nik');
        const kkInput = document.getElementById('kk_number');
        const npwpInput = document.getElementById('npwp_number');

        const ktpFileInput = document.getElementById('ktp_file');
        const kkFileInput = document.getElementById('kk_file');
        const slipFileInput = document.getElementById('salary_slip_file');
        const npwpFileInput = document.getElementById('npwp_file');

        if (isCredit) {
            if (dpInput) dpInput.setAttribute('required', 'required');
            if (tenorInput) tenorInput.setAttribute('required', 'required');
            if (rateInput) rateInput.setAttribute('required', 'required');

            // Apply requirement based on selected customer state
            const custSelect = document.getElementById('customer_id');
            const selected = custSelect ? custSelect.options[custSelect.selectedIndex] : null;

            const hasNik = selected && selected.getAttribute('data-nik');
            const hasKk = selected && selected.getAttribute('data-kk');
            const hasNpwp = selected && selected.getAttribute('data-npwp');
            const hasKtpFile = selected && selected.getAttribute('data-has-ktp') === '1';
            const hasKkFile = selected && selected.getAttribute('data-has-kk-file') === '1';
            const hasSlipFile = selected && selected.getAttribute('data-has-slip') === '1';
            const hasNpwpFile = selected && selected.getAttribute('data-has-npwp-file') === '1';

            if (nikInput) {
                if (!hasNik && !nikInput.value) nikInput.setAttribute('required', 'required');
                else nikInput.removeAttribute('required');
            }
            if (kkInput) {
                if (!hasKk && !kkInput.value) kkInput.setAttribute('required', 'required');
                else kkInput.removeAttribute('required');
            }
            if (npwpInput) {
                if (!hasNpwp && !npwpInput.value) npwpInput.setAttribute('required', 'required');
                else npwpInput.removeAttribute('required');
            }

            if (ktpFileInput) {
                if (!hasKtpFile && !ktpFileInput.value) ktpFileInput.setAttribute('required', 'required');
                else ktpFileInput.removeAttribute('required');
            }
            if (kkFileInput) {
                if (!hasKkFile && !kkFileInput.value) kkFileInput.setAttribute('required', 'required');
                else kkFileInput.removeAttribute('required');
            }
            if (slipFileInput) {
                if (!hasSlipFile && !slipFileInput.value) slipFileInput.setAttribute('required', 'required');
                else slipFileInput.removeAttribute('required');
            }
            if (npwpFileInput) {
                if (!hasNpwpFile && !npwpFileInput.value) npwpFileInput.setAttribute('required', 'required');
                else npwpFileInput.removeAttribute('required');
            }

        } else {
            const inputs = [dpInput, tenorInput, rateInput, nikInput, kkInput, npwpInput, ktpFileInput, kkFileInput, slipFileInput, npwpFileInput];
            inputs.forEach(el => {
                if (el) el.removeAttribute('required');
            });
        }
    }

    function onCustomerChange(select) {
        const selected = select.options[select.selectedIndex];
        if (!selected || !selected.value) return;

        const nik = selected.getAttribute('data-nik');
        const kk = selected.getAttribute('data-kk');
        const npwp = selected.getAttribute('data-npwp');
        
        const hasKtp = selected.getAttribute('data-has-ktp') === '1';
        const hasKkFile = selected.getAttribute('data-has-kk-file') === '1';
        const hasSlip = selected.getAttribute('data-has-slip') === '1';
        const hasNpwpFile = selected.getAttribute('data-has-npwp-file') === '1';

        if (nik && !document.getElementById('nik').value) document.getElementById('nik').value = nik;
        if (kk && !document.getElementById('kk_number').value) document.getElementById('kk_number').value = kk;
        if (npwp && !document.getElementById('npwp_number').value) document.getElementById('npwp_number').value = npwp;

        document.getElementById('ktp_file_status').innerText = hasKtp ? '(Sudah ada file KTP)' : '';
        document.getElementById('kk_file_status').innerText = hasKkFile ? '(Sudah ada file KK)' : '';
        document.getElementById('salary_slip_file_status').innerText = hasSlip ? '(Sudah ada file Slip Gaji)' : '';
        document.getElementById('npwp_file_status').innerText = hasNpwpFile ? '(Sudah ada file NPWP)' : '';

        const type = document.getElementById('payment_type').value;
        updateCreditRequirements(type === 'credit');
    }

    function formatRupiah(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(number));
    }

    function calculateCredit() {
        const type = document.getElementById('payment_type').value;
        if (type !== 'credit') return;

        const salePrice = parseFloat(document.getElementById('sale_price').value) || 0;
        const dpAmount = parseFloat(document.getElementById('dp_amount').value) || 0;
        const tenorMonths = parseInt(document.getElementById('tenor_months').value) || 36;
        const interestRate = parseFloat(document.getElementById('interest_rate_per_year').value) || 0;

        const principal = Math.max(0, salePrice - dpAmount);
        const totalInterest = principal * (interestRate / 100) * (tenorMonths / 12);
        const monthlyInstallment = tenorMonths > 0 ? (principal + totalInterest) / tenorMonths : 0;

        document.getElementById('sim_principal').innerText = formatRupiah(principal);
        document.getElementById('sim_total_interest').innerText = formatRupiah(totalInterest);
        document.getElementById('sim_monthly').innerText = formatRupiah(monthlyInstallment) + ' / bln';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const type = document.getElementById('payment_type').value;
        togglePaymentType(type);

        const custSelect = document.getElementById('customer_id');
        if (custSelect && custSelect.value) {
            onCustomerChange(custSelect);
        }
    });
</script>
@endpush

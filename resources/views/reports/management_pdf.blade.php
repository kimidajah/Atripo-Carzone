<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengelolaan Armada - ATRIPO CARZONE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #000;
            margin: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .header h3 {
            margin: 5px 0 0 0;
            font-size: 11pt;
            font-weight: normal;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 9pt;
            color: #444;
        }
        .report-title {
            text-align: center;
            margin-bottom: 15px;
        }
        .report-title h4 {
            margin: 0;
            text-transform: uppercase;
            font-size: 13pt;
            text-decoration: underline;
        }
        .report-title p {
            margin: 5px 0 0 0;
            font-size: 9.5pt;
        }
        .summary-box {
            border: 1px solid #000;
            padding: 8px 12px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        .section-title {
            font-weight: bold;
            font-size: 11pt;
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #333;
            padding-bottom: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th {
            background-color: #f2f2f2;
            padding: 6px 8px;
            font-size: 9pt;
            text-transform: uppercase;
        }
        td {
            padding: 5px 8px;
            font-size: 9pt;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .signature-box {
            width: 250px;
            text-align: center;
            margin-top: 30px;
            float: right;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #F4B400; font-weight: bold; border: none; cursor: pointer;">Cetak Sekarang</button>
    </div>

    <!-- Kop Surat -->
    <div class="header">
        <h2>ATRIPO CARZONE</h2>
        <h3>Sistem Informasi Penjualan dan Persediaan Mobil Bekas</h3>
        <p>Jl. Raya Cileunyi, Kabupaten Bandung, Jawa Barat | Telp: 0812-3456-7890</p>
    </div>

    <!-- Judul Laporan -->
    <div class="report-title">
        <h4>LAPORAN PENGELOLAAN ARMADA (MOBIL MASUK & KELUAR)</h4>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    <!-- Ringkasan Unit -->
    <div class="summary-box">
        <strong>Ringkasan Pengelolaan Periode Ini:</strong><br>
        • Total Unit Mobil Masuk (Di-input): <strong>{{ $totalIncoming }} Unit</strong><br>
        • Total Unit Mobil Keluar (Terjual): <strong>{{ $totalOutgoing }} Unit</strong><br>
        • Stok Mobil Tersedia (Ready) Saat Ini: <strong>{{ $currentAvailable }} Unit</strong>
    </div>

    <!-- Section 1: Mobil Masuk -->
    <div class="section-title">1. DAFTAR MOBIL MASUK (UNIT DI-INPUT BARU)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Tgl Masuk</th>
                <th>Merek & Tipe</th>
                <th>Tahun</th>
                <th>Transmisi</th>
                <th>No. Polisi</th>
                <th class="text-end">Harga Stok (Rp)</th>
                <th>Status Saat Ini</th>
            </tr>
        </thead>
        <tbody>
            @forelse($carsIncoming as $index => $car)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $car->created_at->format('d/m/Y') }}</td>
                    <td>{{ $car->brand }} {{ $car->model_type }}</td>
                    <td class="text-center">{{ $car->year }}</td>
                    <td class="text-center">{{ $car->transmission }}</td>
                    <td class="text-center fw-bold">{{ $car->plate_number }}</td>
                    <td class="text-end fw-bold">{{ number_format($car->price, 0, ',', '.') }}</td>
                    <td class="text-center fw-bold">{{ strtoupper($car->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada unit mobil masuk (di-input) pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Section 2: Mobil Keluar -->
    <div class="section-title">2. DAFTAR MOBIL KELUAR (UNIT TERJUAL / TRANSAKSI)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Tgl Keluar</th>
                <th>No Invoice</th>
                <th>Mobil Terjual</th>
                <th>Pelanggan Pembeli</th>
                <th>Skema Bayar</th>
                <th class="text-end">Harga Penjualan Deal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salesOutgoing as $index => $sale)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $sale->sale_date->format('d/m/Y') }}</td>
                    <td class="text-center fw-bold">{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }} ({{ $sale->car->plate_number ?? '' }})</td>
                    <td>{{ $sale->customer->name ?? '-' }}</td>
                    <td class="text-center">{{ strtoupper($sale->payment_type) }}</td>
                    <td class="text-end fw-bold">{{ number_format($sale->sale_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada unit mobil keluar (terjual) pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div style="width: 100%; overflow: hidden; margin-top: 30px;">
        <div class="signature-box">
            <p>Cileunyi, Bandung, {{ now()->format('d F Y') }}</p>
            <p style="margin-bottom: 60px;">Pengelola Armada / Admin,</p>
            <p class="fw-bold">( Atripo Carzone )</p>
        </div>
    </div>
</body>
</html>

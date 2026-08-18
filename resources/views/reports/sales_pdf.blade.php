<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - MOBILQ</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
            padding: 6px 8px;
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

    <!-- Kop Surat / Header -->
    <div class="header">
        <h2>MOBILQ</h2>
        <h3>Sistem Informasi Penjualan dan Persediaan Mobil Bekas</h3>
        <p>Jl. Raya Cileunyi, Kabupaten Bandung, Jawa Barat | Telp: 0812-3456-7890</p>
    </div>

    <!-- Judul Laporan -->
    <div class="report-title">
        <h4>LAPORAN PENJUALAN KENDARAAN (CASH & KREDIT)</h4>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    <!-- Tabel Laporan -->
    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Tanggal</th>
                <th>No Invoice</th>
                <th>Mobil Terjual</th>
                <th>Nama Pelanggan / NIK</th>
                <th>Skema Bayar</th>
                <th class="text-end">Harga Jual (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $index => $sale)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $sale->sale_date->format('d/m/Y') }}</td>
                    <td class="text-center fw-bold">{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->car->brand ?? '-' }} {{ $sale->car->model_type ?? '' }} ({{ $sale->car->plate_number ?? '' }})</td>
                    <td>
                        {{ $sale->customer->name ?? '-' }}
                        @if($sale->customer && $sale->customer->nik)
                            <br><small style="font-size: 8pt; color: #555;">NIK: {{ $sale->customer->nik }}</small>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($sale->payment_type === 'credit')
                            <strong>KREDIT ({{ $sale->tenor_months }} Bln)</strong><br>
                            <small style="font-size: 8pt;">DP: {{ $sale->formatted_dp_amount }}</small>
                        @else
                            CASH / LUNAS
                        @endif
                    </td>
                    <td class="text-end fw-bold">{{ number_format($sale->sale_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada transaksi penjualan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        @if($sales->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="6" class="text-end fw-bold">TOTAL TRANSAKSI ({{ $totalTransactions }} Unit):</td>
                    <td class="text-end fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Tanda Tangan -->
    <div style="width: 100%; overflow: hidden; margin-top: 30px;">
        <div class="signature-box">
            <p>Cileunyi, Bandung, {{ now()->format('d F Y') }}</p>
            <p style="margin-bottom: 60px;">Pemilik Showroom / Admin,</p>
            <p class="fw-bold">( MobilQ )</p>
        </div>
    </div>
</body>
</html>

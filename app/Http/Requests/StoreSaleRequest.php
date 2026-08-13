<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->canManageSales();
    }

    public function rules(): array
    {
        return [
            'car_id' => ['required', 'exists:cars,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'sale_date' => ['required', 'date'],
            'sale_price' => ['required', 'numeric', 'min:0'],
            'payment_type' => ['required', 'in:cash,credit'],
            'payment_method' => ['required', 'in:cash,transfer'],
            'notes' => ['nullable', 'string'],

            // Validation fields for credit
            'dp_amount' => ['required_if:payment_type,credit', 'nullable', 'numeric', 'min:0', 'lt:sale_price'],
            'tenor_months' => ['required_if:payment_type,credit', 'nullable', 'integer', 'min:1', 'max:120'],
            'interest_rate_per_year' => ['required_if:payment_type,credit', 'nullable', 'numeric', 'min:0', 'max:100'],

            // Customer Document fields
            'nik' => ['nullable', 'string', 'max:20'],
            'kk_number' => ['nullable', 'string', 'max:20'],
            'npwp_number' => ['nullable', 'string', 'max:30'],
            'ktp_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'kk_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'salary_slip_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'npwp_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->payment_type === 'credit') {
                $customer = Customer::find($this->customer_id);

                // NIK KTP
                if (empty($this->nik) && (!$customer || empty($customer->nik))) {
                    $validator->errors()->add('nik', 'NIK KTP pelanggan wajib diisi untuk transaksi kredit.');
                }

                // No KK
                if (empty($this->kk_number) && (!$customer || empty($customer->kk_number))) {
                    $validator->errors()->add('kk_number', 'Nomor Kartu Keluarga (KK) wajib diisi untuk transaksi kredit.');
                }

                // No NPWP
                if (empty($this->npwp_number) && (!$customer || empty($customer->npwp_number))) {
                    $validator->errors()->add('npwp_number', 'Nomor NPWP wajib diisi untuk transaksi kredit.');
                }

                // File KTP
                if (!$this->hasFile('ktp_file') && (!$customer || empty($customer->ktp_file))) {
                    $validator->errors()->add('ktp_file', 'File scan/foto KTP wajib diunggah untuk transaksi kredit.');
                }

                // File KK
                if (!$this->hasFile('kk_file') && (!$customer || empty($customer->kk_file))) {
                    $validator->errors()->add('kk_file', 'File scan/foto KK wajib diunggah untuk transaksi kredit.');
                }

                // File Slip Gaji
                if (!$this->hasFile('salary_slip_file') && (!$customer || empty($customer->salary_slip_file))) {
                    $validator->errors()->add('salary_slip_file', 'File scan/foto Slip Gaji wajib diunggah untuk transaksi kredit.');
                }

                // File NPWP
                if (!$this->hasFile('npwp_file') && (!$customer || empty($customer->npwp_file))) {
                    $validator->errors()->add('npwp_file', 'File scan/foto NPWP wajib diunggah untuk transaksi kredit.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'car_id.required' => 'Mobil wajib dipilih.',
            'car_id.exists' => 'Mobil yang dipilih tidak valid.',
            'customer_id.required' => 'Pelanggan wajib dipilih.',
            'customer_id.exists' => 'Pelanggan yang dipilih tidak valid.',
            'sale_date.required' => 'Tanggal transaksi wajib diisi.',
            'sale_price.required' => 'Harga penjualan wajib diisi.',
            'sale_price.numeric' => 'Harga penjualan harus berupa angka.',
            'payment_type.required' => 'Tipe transaksi (Cash/Kredit) wajib dipilih.',
            'payment_type.in' => 'Tipe transaksi harus Cash atau Kredit.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'dp_amount.required_if' => 'Nominal DP wajib diisi untuk transaksi kredit.',
            'dp_amount.lt' => 'Nominal DP harus lebih kecil dari harga penjualan deal.',
            'tenor_months.required_if' => 'Tenor cicilan (bulan) wajib diisi untuk transaksi kredit.',
            'interest_rate_per_year.required_if' => 'Persentase bunga per tahun wajib diisi untuk transaksi kredit.',
            'ktp_file.mimes' => 'File KTP harus format JPG, PNG, atau PDF.',
            'kk_file.mimes' => 'File KK harus format JPG, PNG, atau PDF.',
            'salary_slip_file.mimes' => 'File Slip Gaji harus format JPG, PNG, atau PDF.',
            'npwp_file.mimes' => 'File NPWP harus format JPG, PNG, atau PDF.',
        ];
    }
}

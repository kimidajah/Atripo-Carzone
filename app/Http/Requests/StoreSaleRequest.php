<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'car_id' => ['required', 'exists:cars,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'sale_date' => ['required', 'date'],
            'sale_price' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,transfer'],
            'notes' => ['nullable', 'string'],
        ];
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
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->canManageCars();
    }

    public function rules(): array
    {
        return [
            'brand' => ['required', 'string', 'max:100'],
            'model_type' => ['required', 'string', 'max:100'],
            'year' => ['required', 'integer', 'min:1990', 'max:' . (date('Y') + 1)],
            'color' => ['required', 'string', 'max:50'],
            'transmission' => ['required', 'in:Manual,Automatic'],
            'plate_number' => ['required', 'string', 'max:20', 'unique:cars,plate_number'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'status' => ['required', 'in:tersedia,dipesan,pending,terjual'],
        ];
    }

    public function messages(): array
    {
        return [
            'brand.required' => 'Merek mobil wajib diisi.',
            'model_type.required' => 'Tipe mobil wajib diisi.',
            'year.required' => 'Tahun produksi wajib diisi.',
            'year.integer' => 'Tahun produksi harus berupa angka.',
            'color.required' => 'Warna mobil wajib diisi.',
            'transmission.required' => 'Jenis transmisi wajib dipilih.',
            'plate_number.required' => 'Nomor polisi wajib diisi.',
            'plate_number.unique' => 'Nomor polisi tersebut sudah terdaftar.',
            'price.required' => 'Harga mobil wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'image.image' => 'File foto harus berupa gambar (jpeg, png, jpg, webp).',
            'image.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->canManageCustomers();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'nik' => ['nullable', 'string', 'max:20'],
            'kk_number' => ['nullable', 'string', 'max:20'],
            'npwp_number' => ['nullable', 'string', 'max:30'],
            'ktp_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'kk_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'salary_slip_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'npwp_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'address.required' => 'Alamat pelanggan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'ktp_file.mimes' => 'File KTP harus format JPG, PNG, atau PDF.',
            'ktp_file.max' => 'File KTP maksimal berukuran 2MB.',
            'kk_file.mimes' => 'File KK harus format JPG, PNG, atau PDF.',
            'kk_file.max' => 'File KK maksimal berukuran 2MB.',
            'salary_slip_file.mimes' => 'File Slip Gaji harus format JPG, PNG, atau PDF.',
            'salary_slip_file.max' => 'File Slip Gaji maksimal berukuran 2MB.',
            'npwp_file.mimes' => 'File NPWP harus format JPG, PNG, atau PDF.',
            'npwp_file.max' => 'File NPWP maksimal berukuran 2MB.',
        ];
    }
}

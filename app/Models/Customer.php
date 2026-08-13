<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'nik',
        'kk_number',
        'npwp_number',
        'ktp_file',
        'kk_file',
        'salary_slip_file',
        'npwp_file',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function getKtpUrlAttribute(): ?string
    {
        if (!$this->ktp_file) return null;
        return Storage::disk('public')->exists($this->ktp_file) ? asset('uploads/' . $this->ktp_file) : null;
    }

    public function getKkUrlAttribute(): ?string
    {
        if (!$this->kk_file) return null;
        return Storage::disk('public')->exists($this->kk_file) ? asset('uploads/' . $this->kk_file) : null;
    }

    public function getSalarySlipUrlAttribute(): ?string
    {
        if (!$this->salary_slip_file) return null;
        return Storage::disk('public')->exists($this->salary_slip_file) ? asset('uploads/' . $this->salary_slip_file) : null;
    }

    public function getNpwpUrlAttribute(): ?string
    {
        if (!$this->npwp_file) return null;
        return Storage::disk('public')->exists($this->npwp_file) ? asset('uploads/' . $this->npwp_file) : null;
    }

    public function getHasCreditDocumentsAttribute(): bool
    {
        return !empty($this->nik) || !empty($this->ktp_file) || !empty($this->kk_file) || !empty($this->salary_slip_file);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'car_id',
        'customer_id',
        'user_id',
        'sale_date',
        'sale_price',
        'payment_method',
        'notes',
        'payment_type',
        'dp_amount',
        'tenor_months',
        'interest_rate_per_year',
        'total_interest',
        'monthly_installment',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'sale_price' => 'decimal:2',
        'dp_amount' => 'decimal:2',
        'interest_rate_per_year' => 'decimal:2',
        'total_interest' => 'decimal:2',
        'monthly_installment' => 'decimal:2',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->sale_price, 0, ',', '.');
    }

    public function getFormattedDpAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->dp_amount ?? 0, 0, ',', '.');
    }

    public function getPrincipalAmountAttribute(): float
    {
        return max(0, (float)$this->sale_price - (float)($this->dp_amount ?? 0));
    }

    public function getFormattedPrincipalAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->principal_amount, 0, ',', '.');
    }

    public function getFormattedTotalInterestAttribute(): string
    {
        return 'Rp ' . number_format($this->total_interest ?? 0, 0, ',', '.');
    }

    public function getFormattedMonthlyInstallmentAttribute(): string
    {
        return 'Rp ' . number_format($this->monthly_installment ?? 0, 0, ',', '.');
    }

    public function getIsCreditAttribute(): bool
    {
        return $this->payment_type === 'credit';
    }

    public static function generateInvoiceNumber(): string
    {
        $today = now()->format('Ymd');
        $lastSale = self::whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastSale ? ((int) substr($lastSale->invoice_number, -3)) + 1 : 1;
        
        return 'INV-' . $today . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }
}

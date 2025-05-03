<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'promo_code',
        'type',
        'discount_type',
        'discount_amount',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Tambahkan method untuk generate promo code di model
    public function generatePromoCode()
    {
        // Ambil nama, ubah ke uppercase dan buang spasi
        $baseCode = strtoupper(str_replace(' ', '', $this->name));

        // Tambahkan 4 digit random supaya lebih unik
        $randomSuffix = rand(1000, 9999);

        $promoCode = $baseCode . $randomSuffix;

        // Pastikan benar-benar unik di database
        while (self::where('promo_code', $promoCode)->exists()) {
            $randomSuffix = rand(1000, 9999);
            $promoCode = $baseCode . $randomSuffix;
        }

        return $promoCode;
    }
}

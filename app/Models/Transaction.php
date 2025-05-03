<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = ['user_id', 'total_harga', 'discount_id', 'status', 'final_amount', 'payment_method_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    protected function casts(): array
    {
        return [
            'status' => TransactionStatus::class,
        ];
    }
}

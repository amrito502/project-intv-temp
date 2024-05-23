<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashPayment extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function RequisitionTotalPaymentAmount()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->paymentAmount;
        }

        return $total;
    }


    public function items(): HasMany
    {
        return $this->hasMany(CashPaymentItem::class, 'cash_payment_id', 'id');
    }
}

<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DealerPurchaseReturn extends Model
{
    use HasFactory;

    protected $table = 'dealer_purchase_returns';
    protected $guarded = [];


    public function dealer(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'dealer_id');
    }

    public function items()
    {
        return $this->hasMany(DealerPurchaseReturnItem::class, 'dealer_purchase_return_id', 'id');
    }

    public function totalQuantity()
    {
        // get sum of item
        $total = $this->items->sum('qty');

        return $total;
    }

}

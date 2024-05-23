<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashSale extends Model
{
    protected $table = 'cash_sales';

    protected $guarded = [];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * Get all of the comments for the CashSale
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(CashSaleItem::class, 'cash_sale_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }


    public function dealer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }

    public function invoiceTotalPP()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->item_quantity * $item->pp;
        }

        return $total;
    }

    public function totalPrice()
    {
        $totalPrice = $this->items->sum('item_price');

        return $totalPrice;
    }

    public function totalDealerPrice()
    {
        $totalPrice = $this->items->sum('item_dealer_price');

        return $totalPrice;
    }

    public function invoiceTotalPriceDiff()
    {
        $totalPriceDiff = $this->totalPrice() - $this->totalDealerPrice();
        return $totalPriceDiff;
    }


    public function totalQuantity()
    {

        // get sum of item price
        $totalPrice = $this->items->sum('item_quantity');

        return $totalPrice;
    }
}

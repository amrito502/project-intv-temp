<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CashSaleItem extends Model
{
    protected $table = 'cash_sale_items';

    protected $fillable = [
    	'cash_sale_id','invoice_no','item_id','item_quantity','item_price', 'pp'
    ];

    protected $hidden = [
    	'created_at','updated_at'
    ];


    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'item_id');
    }

}

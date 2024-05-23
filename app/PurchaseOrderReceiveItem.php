<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderReceiveItem extends Model
{
    protected $table = 'purchase_order_receive_items';
    protected $fillable = [
       'purchase_order_receive_id','product_id','product_name', 'qty', 'rate','amount',
    ];
 
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';
    protected $fillable = [
       'supplier_id','order_no','delivery_date', 'order_date', 'total_qty','total_amount','voucher_date',
    ];
 
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id', 'id');
    }


    public function poRecieve()
    {
        return $this->hasMany(PurchaseOrderReceive::class, 'purchaseOrderNo', 'id');
    }

  
    public function supplier()
    {
        return $this->hasOne(Vendors::class, 'id', 'supplier_id');
    }
}
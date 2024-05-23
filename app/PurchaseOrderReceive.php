<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurchaseOrderReceive extends Model
{
    protected $table = 'purchase_order_receives';
    protected $fillable = [
       'purchaseOrderNo','receive_date', 'total_qty','total_amount',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function purchaseOrder(): HasOne
    {
        return $this->hasOne(PurchaseOrder::class, 'id', 'purchaseOrderNo');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderReceiveItem::class, 'purchase_order_receive_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashPurchaseItem extends Model
{   protected $table = 'cash_purchase_item';
    protected $fillable = [
        'cash_puchase_id','product_id','qty','rate','amount'
    ];
 
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * Get the user associated with the CashPurchaseItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}


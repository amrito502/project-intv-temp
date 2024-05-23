<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditPurchaseItem extends Model
{
    protected $table = 'credit_purchase_items';
    protected $fillable = [
        'credit_puchase_id','product_id','qty','rate','amount'
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
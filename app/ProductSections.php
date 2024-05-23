<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSections extends Model
{
    protected $fillable = [
        'productId', 'hotDiscount', 'hotDate', 'specialDiscount', 'specialDate', 'free_shipping', 'vat_amount', 'pre_order', 'pre_orderDuration', 'multiImage', 'related_product', 'upsell_product'
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
        return $this->belongsTo('App\Product', 'productId', 'id');
    }
}

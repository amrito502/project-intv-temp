<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCharges extends Model
{
    protected $fillable = [
        'shippingAmount','shippingCharge', 'shippingLocation','metaTitle','metaKeyword','metaDescription','orderBy','shippingStatus',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    
}
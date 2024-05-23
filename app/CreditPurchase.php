<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditPurchase extends Model
{
    protected $table = 'credit_purchases';
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];


    public function supplier()
    {
        return $this->hasOne('App\Vendors', 'id', 'supplier_id');
    }

    public function items()
    {
        return $this->hasMany(CreditPurchaseItem::class, 'credit_puchase_id', 'id');
    }
}

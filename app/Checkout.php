<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Checkout extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shipping_id', 'customer_id', 'discount', 'status', 'paid', 'courier_id', 'shipping_charge', 'pp'
    ];

    // protected $hidden = [
    //     'created_at', 'updated_at',
    // ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'checkout_id', 'id');
    }

    public function courier()
    {
        return $this->hasOne('App\Courier', 'id', 'courier_id');
    }
}

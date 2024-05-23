<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineCollection extends Model
{
    protected $table = "online_collection";
    protected $guarded = [];

    public function checkOut()
    {
        return $this->hasOne('App\Checkout', 'id', 'checkout_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerRequestItemList extends Model
{
    protected $table = 'customer_request_item_list';
    protected $fillable = [
        'name', 'email', 'mobile','address','itemList'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
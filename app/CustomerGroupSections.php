<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGroupSections extends Model
{
    protected $fillable = [
        'productId','customerGroupId','customerGroupPrice'
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'name','email', 'mobile', 'address', 'status', 'comment'
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
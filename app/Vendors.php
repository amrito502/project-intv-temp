<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    protected $fillable = [
        'vendor_serial','vendorName','contactPerson','vendorAddress', 'vendorPhone', 'vendorEmail','accountCode','orderBy','vendorStatus',
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


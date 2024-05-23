<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyCustomer extends Model
{
    protected $fillable = [
        'reference_by', 'name','email','mobile','address','gender','password','confirmPassword','verifyCode'
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

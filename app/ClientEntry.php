<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientEntry extends Model
{
    protected $table = 'customers';

    protected $fillable = [
    	'name','dob','gender','mobile','email','password'
    ];

    protected $hidden = [
    	'created_at','updated_at'
    ];
}

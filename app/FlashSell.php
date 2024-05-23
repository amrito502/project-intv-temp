<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlashSell extends Model
{   protected $table = 'flash_sell';
    protected $fillable = [
        'flashPrice','flashDate', 'flashProduct',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

}
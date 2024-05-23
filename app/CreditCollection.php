<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditCollection extends Model
{
    protected $table = 'credit_collections';

    protected $fillable = [
    	'client_id','payment_no','payment_date','money_receipt_no','money_receipt_type','payment_amount','remarks'
    ];

    protected $hidden = [
    	'created_at','updated_at'
    ];


    public function dealer()
    {
        return $this->hasOne(User::class, 'id', 'client_id');
    }

}

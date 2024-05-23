<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditSale extends Model
{
    protected $table = 'credit_sales';

    protected $fillable = [
    	'customer_id','invoice_no','invoice_date','invoice_amount','discount_as','discount_amount','vat_amount','net_amount','payment_type'
    ];

    protected $hidden = [
    	'created_at','updated_at'
    ];

    public function items()
    {
        return $this->hasMany(CreditSaleItem::class, 'credit_sale_id', 'id');
    }
}

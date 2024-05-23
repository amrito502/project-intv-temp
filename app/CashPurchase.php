<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashPurchase extends Model
{
    protected $table = 'cash_purchase';
    protected $fillable = [
        'cash_serial','voucher_no','supplier_id','voucher_date','total_qty','total_amount', 'orderBy', 'voucherStatus',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    // hasone supplier
    public function supplier()
    {
        return $this->hasOne('App\Vendors', 'id', 'supplier_id');
    }

    public function items()
    {
        return $this->hasMany(CashPurchaseItem::class, 'cash_puchase_id', 'id');
    }

    public function invoiceTotalCostAmount()
    {
        return $this->items->sum('amount_cash');
    }
}


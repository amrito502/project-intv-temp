<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashRequisitionItem extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function cash_requisition(): HasOne
    {
        return $this->hasOne(CashRequisition::class, 'id', 'cash_requisition_id');
    }

    public function budgethead(): HasOne
    {
        return $this->hasOne(BudgetHead::class, 'id', 'budget_head_id');
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function totalPaid()
    {
        return CashVendorPayment::where('requisition_item_id', $this->id)->sum('amount');
    }

}

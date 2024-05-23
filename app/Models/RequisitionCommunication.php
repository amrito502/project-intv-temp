<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequisitionCommunication extends Model
{
    use HasFactory;
    protected $table = 'cash_requisition_communications';
    protected $guarded = [];


    public function CashRequisition(): HasOne
    {
        return $this->hasOne(CashRequisition::class, 'id', 'cash_requisition_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}

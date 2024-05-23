<?php

namespace App\Models;

use App\Models\User;
use App\Models\MaterialRequisition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialRequisitionCommunication extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function CashRequisition(): HasOne
    {
        return $this->hasOne(MaterialRequisition::class, 'id', 'cash_requisition_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

}

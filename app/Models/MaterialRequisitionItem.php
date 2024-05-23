<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialRequisitionItem extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function budgethead(): HasOne
    {
        return $this->hasOne(BudgetHead::class, 'id', 'budget_head_id');
    }

}

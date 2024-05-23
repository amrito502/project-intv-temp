<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectWiseBudgetItems extends Model
{
    use HasFactory;

    public function budgetHead(): HasOne
    {
        return $this->hasOne(BudgetHead::class, 'id', 'budget_head');
    }


    public function unit_of_measurement(): HasOne
    {
        return $this->hasOne(MaterialUnit::class, 'id', 'uom');
    }


}

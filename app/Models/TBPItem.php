<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TBPItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function charge()
    {
        return $this->material_qty * $this->material_rate;
    }

    public function material(): HasOne
    {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }


    public function consumptionItem(): HasOne
    {
        return $this->hasOne(DailyConsumptionItem::class, 'id', 'consumption_item_id');
    }

}

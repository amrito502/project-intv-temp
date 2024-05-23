<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialLiftingMaterial extends Model
{
    use HasFactory;


    public function material(): HasOne
    {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }
}

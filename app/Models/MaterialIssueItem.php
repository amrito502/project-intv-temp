<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialIssueItem extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function material(): HasOne
    {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }
}

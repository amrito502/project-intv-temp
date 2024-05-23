<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function setRouteKeyName()
    {
        return 'categoryName';
    }

    public function ScopeEnabled()
    {
        return $this->where('categoryStatus', 1);
    }
}

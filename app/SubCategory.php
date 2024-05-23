<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'category_id', 'subcategoryName', 'subcategoryStatus','metaTitle','metaKeyword','metaDescription','orderBy'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function products()
    {
    	return $this->hasMany(Product::class);
    }

    public function setRouteKeyName(){
        return 'name';
    }
}

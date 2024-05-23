<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title','blogImage', 'description', 'status','metaTitle','metaKeyword','metaDescription','orderBy'
    ];

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

    public function setRouteKeyName(){
        return 'categoryName';
    }
}
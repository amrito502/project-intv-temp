<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
	protected $fillable = [
        'title','source','section','productId','status','metaTitle','metaKeyword','metaDescription','orderBy', 'category_id'
    ];
}

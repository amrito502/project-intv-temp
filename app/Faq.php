<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{	protected $fillable = [
    	'title', 'description','metaTitle','metaKeyword','metaDescription','orderBy','status'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];
}

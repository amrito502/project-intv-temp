<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $fillable = [
        'facebook','twitter', 'google', 'linkdin','youtube','status','metaTitle','metaKeyword','metaDescription','orderBy'
    ];
}

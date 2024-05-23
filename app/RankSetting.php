<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RankSetting extends Model
{
    protected $table = 'rank_settings';
    protected $guarded = [];


    public function achivement(): HasMany
    {
        return $this->hasMany(RankAchivement::class, 'rank_sequence_id', 'sequence_no');
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class, 'rank', 'id');
    }
}

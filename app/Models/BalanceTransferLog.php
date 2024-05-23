<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransferLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function from()
    {
        return $this->hasOne(User::class, 'id', 'from_id');
    }

    public function to()
    {
        return $this->hasOne(User::class, 'id', 'to_id');
    }

}

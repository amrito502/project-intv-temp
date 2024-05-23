<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'customers';


    public function UserAccount(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function checkouts()
    {
        return $this->haMany(Checkout::class);
    }


    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id', 'id');
    }


}

<?php

namespace App\Models;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberSaleItem extends Model
{

    use HasFactory;

    protected $table = 'member_sale_items';
    protected $guarded = [];


    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'item_id');
    }

}

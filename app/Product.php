<?php

namespace App;

use App\Review;
use App\Helper\StockStatus;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'brand_id', 'root_category', 'name','slug', 'product_details', 'description1', 'description2', 'deal_code', 'pp', 'phone_no', 'image', 'image2', 'qty', 'stockUnit', 'price', 'weight', 'discount', 'discount_percent', 'status', 'youtubeLink', 'productSection', 'tag', 'metaTitle', 'metaKeyword', 'metaDescription', 'orderBy'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];


    public function setRouteKeyName()
    {
        return 'name';
    }

    public function ScopeEnabled()
    {
        return $this->where('status', 1);
    }

    public function ScopeAvgRating()
    {
        $rateAvg = Review::where('productId', $this->id)->avg('star');

        return $rateAvg;
    }


    public function images()
    {
        return $this->hasMany('App\ProductImage', 'productId', 'id');
    }

    public function image()
    {
        return $this->hasOne('App\ProductImage', 'productId', 'id');
    }


    public function advance_info()
    {
        return $this->hasOne('App\ProductSections', 'productId', 'id');
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'root_category');
    }

    public function ScopeonStock()
    {
        $stock_status = new StockStatus($this->id);
        // dd($stock_status);
        return $stock_status->stock() > 0 ? true : false;
    }
}

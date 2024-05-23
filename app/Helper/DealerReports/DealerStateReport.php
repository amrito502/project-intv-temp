<?php
namespace App\Helper\DealerReports;

use App\User;
use App\Product;
use App\Category;

class DealerStateReport{

    protected $data;
    protected $dealers;

    public function __construct($data)
    {
        $this->data = $data;

        if(!$this->data['categories']){
            $this->data['categories'] = Category::pluck('id')->toArray();
        }

        if(!$this->data['products']){
            $this->data['products'] = Product::pluck('id')->toArray();
        }

        if($this->data['dealer_id']){
            $this->dealers = [User::find($this->data['dealer_id'])];
        }else{
            $this->dealers = User::where('role_id', 3)->get();
        }

    }


    public function getReport()
    {

    }

}

<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Customer;
use App\Models\MemberSale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PDF;

class DealerMemberSaleController extends Controller
{
    public function index()
    {

        $title = $this->title;

        $memberSales = MemberSale::with(['customer', 'dealer', 'items', 'items.product']);

        if(!in_array(auth()->user()->role, [1, 2, 6, 7])){

            $memberSales = $memberSales->where('store_id', auth()->user()->id)
            ->orWhere('created_by', auth()->user()->id);

        }

            $memberSales = $memberSales->orderBy('id', 'DESC')
            ->where('status', 1)
            ->get();

        return view('admin.memberSale.DealerMemberindex')->with(compact('title', 'memberSales'));
    }

    public function add()
    {
        if (auth()->user()->role == 3) {
            $title = "My Requisition";
        } else {
            $title = "Member Sale";
        }

        $products = Product::where('status', 1)->get();
        $customers = Customer::get();
        $stores = User::where('is_founder', 1)->orWhere('is_agent', 1)->get();

        $member_sale_id = MemberSale::count();

        if (!$member_sale_id) {
            $random_no = 1;
        } else {
            $random_no = $member_sale_id + 1;
        }

        $invoice_no = "CASH-" . date('yd', strtotime("now")) . "-" . $random_no;

        return view('admin.memberSale.DealerMemberAdd')->with(compact('title', 'products', 'invoice_no', 'customers', 'stores'));
    }

}

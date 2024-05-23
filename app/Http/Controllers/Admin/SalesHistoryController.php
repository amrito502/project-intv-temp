<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;

use MPDF;
use App\User;
use App\Order;
use App\Product;
use App\Vendors;
use App\CashSale;
use App\CashSaleItem;
use App\Category;
use App\Checkout;
use App\CreditSale;
use App\ClientEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MemberSale;
use App\Models\MemberSaleItem;

class SalesHistoryController extends Controller
{
	public function index(Request $request)
	{
		$title = $this->title;

        $reports = [];

        $dateRangeUi = (object)[
            'start_date' => $request->from_date ? $request->from_date : date('01-m-Y'),
            'end_date' => $request->to_date ? $request->to_date : date('t-m-Y'),
        ];

		$categories = Category::orderBy('categoryName', 'ASC')->get();
		$products = Product::orderBy('name', 'ASC')->where('status', 1)->get();
		$dealers = User::whereIn('role', [4, 6])->get();

        if($request->searched == "details"){

            $startDate = date('Y-m-d', strtotime($request->from_date));
            $endDate = date('Y-m-d', strtotime($request->to_date));

            $reports = CashSale::with(['dealer', 'items', 'items.product']);

            // daterange
            $reports = $reports->whereBetween('invoice_date', [$startDate, $endDate]);

            // dealer id
            if($request->dealer){
                $reports = $reports->whereIn('customer_id', $request->dealer);
            }

            // product id
            if($request->product){
                $reports = $reports->whereHas('items', function($query) use ($request){
                    $query->whereIn('item_id', $request->product);
                });
            }

            // category id
            if($request->category){
                $reports = $reports->whereHas('items', function($query) use ($request){
                    $query->whereHas('product', function($query) use ($request){
                        $query->whereIn('category_id', $request->category);
                    });
                });
            }

            $reports = $reports->get();

        }

        if($request->searched == "summary"){

            $startDate = date('Y-m-d', strtotime($request->from_date));
            $endDate = date('Y-m-d', strtotime($request->to_date));

            $memberSaleIds = CashSale::query();

            // daterange
            $memberSaleIds = $memberSaleIds->whereBetween('invoice_date', [$startDate, $endDate]);

            // dealer id
            if($request->dealer){
                $memberSaleIds = $memberSaleIds->whereIn('customer_id', $request->dealer);
            }

            // product id
            if($request->product){
                $memberSaleIds = $memberSaleIds->whereHas('items', function($query) use ($request){
                    $query->whereIn('item_id', $request->product);
                });
            }

            // category id
            if($request->category){
                $memberSaleIds = $memberSaleIds->whereHas('items', function($query) use ($request){
                    $query->whereHas('product', function($query) use ($request){
                        $query->whereIn('category_id', $request->category);
                    });
                });
            }

            $memberSaleIds = $memberSaleIds->select('id')->get()->pluck('id')->toArray();


            $memberSaleItems = CashSaleItem::with(['product', 'product.category'])->whereIn('cash_sale_id', $memberSaleIds);

            if($request->product){
                $memberSaleItems = $memberSaleItems->whereIn('item_id', $request->product);
            }

            $memberSaleItems = $memberSaleItems->get();

            $memberSaleItemsGroupByItems = $memberSaleItems->groupBy('item_id');

            $reports = $memberSaleItemsGroupByItems;

        }

		$data = (object)[
            'dateRangeUi' => $dateRangeUi,
            'categories' => $categories,
            'products' => $products,
            'dealers' => $dealers,
            'reports' => $reports,
        ];


		return view('admin.salesHistory.index')->with(compact('title', 'data'));

	}

	public function print(Request $request)
	{
		$title = "Print Sales History";

        $fromDateUI = $request->from_date;
        $toDateUI = $request->to_date;

		$fromDate = Date('Y-m-d', strtotime($request->from_date));
		$toDate = Date('Y-m-d', strtotime($request->to_date));
        $searched = $request->searched;

		$dealer = json_decode($request->dealer);
		$category = json_decode($request->category);
		$product = json_decode($request->product);


        if($request->searched == "details"){

            $startDate = date('Y-m-d', strtotime($request->from_date));
            $endDate = date('Y-m-d', strtotime($request->to_date));

            $reports = CashSale::with(['dealer', 'items', 'items.product']);

            // daterange
            $reports = $reports->whereBetween('invoice_date', [$startDate, $endDate]);

            // dealer id
            if($dealer){
                $reports = $reports->whereIn('customer_id', $dealer);
            }

            // product id
            if($product){
                $reports = $reports->whereHas('items', function($query) use ($product){
                    $query->whereIn('item_id', $product);
                });
            }

            // category id
            if($category){
                $reports = $reports->whereHas('items', function($query) use ($category){
                    $query->whereHas('product', function($query) use ($category){
                        $query->whereIn('category_id', $category);
                    });
                });
            }

            $reports = $reports->get();

        }

        if($request->searched == "summary"){

            $startDate = date('Y-m-d', strtotime($request->from_date));
            $endDate = date('Y-m-d', strtotime($request->to_date));

            $memberSaleIds = CashSale::query();

            // daterange
            $memberSaleIds = $memberSaleIds->whereBetween('invoice_date', [$startDate, $endDate]);

            // dealer id
            if($dealer){
                $memberSaleIds = $memberSaleIds->whereIn('customer_id', $dealer);
            }

            // product id
            if($product){
                $memberSaleIds = $memberSaleIds->whereHas('items', function($query) use ($product){
                    $query->whereIn('item_id', $product);
                });
            }

            // category id
            if($category){
                $memberSaleIds = $memberSaleIds->whereHas('items', function($query) use ($category){
                    $query->whereHas('product', function($query) use ($category){
                        $query->whereIn('category_id', $category);
                    });
                });
            }

            $memberSaleIds = $memberSaleIds->select('id')->get()->pluck('id')->toArray();


            $memberSaleItems = CashSaleItem::with(['product', 'product.category'])->whereIn('cash_sale_id', $memberSaleIds);

            if($product){
                $memberSaleItems = $memberSaleItems->whereIn('item_id', $product);
            }

            $memberSaleItems = $memberSaleItems->get();

            $memberSaleItemsGroupByItems = $memberSaleItems->groupBy('item_id');

            $reports = $memberSaleItemsGroupByItems;

        }

		$data = (object)[
            'fromDateUI' => $fromDateUI,
            'toDateUI' => $toDateUI,
            'reports' => $reports,
            'searched' => $searched,
        ];


		$pdf = PDF::loadView('admin.salesHistory.print', compact('title', 'data'))->setPaper('a4', 'landscape');

        return $pdf->stream('sales-history.pdf');

		return $pdf->stream('cash_sales_history_' . $fromDate . '_to_' . $toDate . '.pdf');
	}
}

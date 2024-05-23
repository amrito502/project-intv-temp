<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use Illuminate\Http\Request;
use App\Helper\DealerInventory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Helper\Ui\FlashMessageGenerator;

class ApiController extends Controller
{

    public function removeColumnData(Request $request)
    {

        DB::table($request->tableName)
              ->where('id', $request->index)
              ->update([$request->columnName => '']);

        return $request->all();

    }


    public function userWallet($id)
    {
        $user = User::findOrFail($id);
        return $user->CashWallet();
    }


    public function getUserWalletInfo(Request $request)
    {

        $user = User::findOrFail($request->userId);

        return [
            'cashWalletAmount' => $user->CashWallet(),
            'walletInfo' => [
                'bkash' => $user->bKash_no,
                'nagad' => $user->nagad_no,
                'rocket' => $user->rocket_no,
                'bank' => $user->bank_info,
            ],
        ];

    }



    public function DealerStockValidation(Request $request)
    {
        $dealer = User::findOrFail($request->params['dealer_id']);

        $items = $request->params['items'];

        $stock = new DealerInventory($dealer);

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);

            $stockQty = $stock->getDealerStockQty($product);

            if($stockQty < $item['qty']){

                return [
                    'status' => false,
                    'message' => 'Stock is not enough for product ' . $product->name,
                ];

            }
        }

        return [
            'status' => true,
        ];
    }

}

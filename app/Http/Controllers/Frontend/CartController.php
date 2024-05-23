<?php
namespace App\Http\Controllers\Frontend;


use Cart;
use App\Product;
use App\Customer;
use App\ProductImage;

use App\ShippingCharges;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $customer = [];

        if (Auth::guard('customer')->check()) {
            $id = Auth::guard('customer')->user()->id;
            $customer = Customer::where('id', $id)->with('addresses')->first();
        }

        $bodyID = 'cart addresses';
        $bodyClass = 'page-cart subpage lang-en country-us currency-usd layout-full-width page-addresses tax-display-disabled';

        return view('frontend.pages.cart', compact('bodyID', 'bodyClass', 'customer'));
    }

    public function addCart(Request $request)
    {
        $image = ProductImage::where('productId', @$request->productId)->first();
        $products = Product::where('id', @$request->productId)->first();

        if ($products->discount && $products->discount > 0) {
            $price = $products->discount;
        } else {
            $price = $request->productPrice;
        }

        Cart::add([
            'id' => $request->productId,
            'name' => $request->productName,
            'quantity' => $request->productQuantity,
            'price' => $price,
            'originalPrice' => $products->price,
            'options' => ['image' => $image->images],
        ]);

        return redirect(route('cart.index'));
    }

    public function remove($rowId, Request $request)
    {
        if ($request->ajax()) {
            Cart::remove($rowId);
            print_r(1);
            return;
        }
    }

    public function update(Request $request)
    {
        // return $request;
        if ($request->ajax()) {

            $products = Product::where('id', $request->rowId)->first(); // get prodcut by id
            $image = ProductImage::where('productId', @$request->rowId)->first();
            if ($products->discount && $products->discount > 0) {
                $price = $products->discount;
                $vat = $products->discount * 0.05;
            } else {
                $price = $products->price;
                $vat = $products->price * 0.05;
            }

            if ($request->qty <= 0) {
                Cart::remove($products->id);
            } else {
                if ($image) {
                    if (file_exists(@$image->images)) {

                        $img = asset('/' . @$image->images);
                    } else {

                        $img = asset('frontend/no-image-icon.png');
                    }
                } else {

                    $img = asset('frontend/no-image-icon.png');
                }
                Cart::remove($products->id);

                Cart::add([
                    'id' => $products->id,
                    'name' => $products->name,
                    'quantity' => $request->qty,
                    'price' => $price,
                    'attributes' => [
                        'image' => $img,
                        'originalPrice' => $products->price,
                        'pp' => $products->pp,
                        'subtotal' => $request->qty * $price,
                        'vat' => $vat,
                    ]
                ]);
            }
            print_r(1);
            return;
        }
    }

    public function singleProduct(Request $request)
    {
        $cart = Cart::get($request->rowId);
        $subtotal = $cart->getPriceSum();
        $total = str_replace(',', '', $subtotal);
        $rowId = "UpdateShoppingCart('" . $cart->id . "')";
        $rowId = str_replace(' ', '', $rowId);


        $product = "";
        $product .= '<div class="row">';
        $product .= '<div class="col-md-6">';
        $product .= '<img class="product-image" src="' . $cart->attributes->image . '" alt="" title="" itemprop="image" style="height: 181px;width: 181px;display: block;margin-left: auto;margin-right: auto;margin-top: 19%;">';
        $product .= '</div>';
        $product .= '<div class="col-md-6">';
        $product .= '<h6 class="h6 product-name">' . $cart->name . '</h6>';
        // $product .= '<p>Quantity:&nbsp;<strong>' . $cart->qty . '</strong></p>';
        $product .= '<p>Quantity&nbsp;<input type="number" class="form-control" style="width:90%;" id="inputQty_' . $cart->id . '" min="1" oninput="' . $rowId . '" value="' . $cart->quantity . '"></p>';
        $product .= '<p>Rate <input type="text" class="form-control" style="width:90%;" value="BDT ' . number_format($cart->price, 2, '.', '') . '" readonly></p>';
        $product .= '<p>Total Price <input type="text" class="form-control" style="width:90%;" value=" BDT ' . number_format($total, 2, '.', '') . '" readonly></p>';
        $product .= '</div>';
        $product .= '</div>';

        return $product;
    }

    public function viewCart(Product $product_id, Request $request)
    {
        if ($request->ajax()) {
            $viewproduct = Product::where('id', $product_id)->first();
            print_r(1);
            return;
        }

        return view('frontend.include.footer-bottom')->with(compact('viewproduct'));
    }

    public function addItem($id)
    {

        $products = Product::where('id', $id)->first(); // get prodcut by id
        $image = ProductImage::where('productId', @$id)->first();


        if ($products->discount && $products->discount > 0) {
            $price = $products->discount;
            $vat = $products->discount * 0.05;
        } else {
            $price = $products->price;
            $vat = $products->price * 0.05;
        }

        if ($image) {
            if (file_exists(@$image->images)) {

                $img = asset('/' . @$image->images);
            } else {

                $img = asset('frontend/no-image-icon.png');
            }
        } else {

            $img = asset('frontend/no-image-icon.png');
        }
        $eCart = Cart::get($products->id);
        if ($eCart) {
            $sbtl = ($eCart->quantity + 1) * $price;
        } else {
            $sbtl = $price;
        }

        $cart =  Cart::add([
            'id' => $products->id,
            'name' => $products->name,
            'quantity' => 1,
            'price' => $price,
            'attributes' => [
                'image' => $img,
                'originalPrice' => $products->price,
                'pp' => $products->pp,
                'subtotal' => $sbtl,
                'vat' => $vat,
            ]
        ]);


        $cart = $cart->get($products->id);

        $subtotal = $cart->getPriceSum();
        $total = str_replace(',', '', $subtotal);
        $rowId = "UpdateShoppingCart('" . $cart->id . "')";
        $rowId = str_replace(' ', '', $rowId);


        $product = "";
        $product .= '<div class="row">';
        $product .= '<div class="col-md-6">';
        $product .= '<img class="product-image" src="' . @$img . '" alt="" title="" itemprop="image" style="height: 181px;width: 181px;display: block;margin-left: auto;margin-right: auto;margin-top: 19%;">';
        $product .= '</div>';
        $product .= '<div class="col-md-6">';
        $product .= '<h6 class="h6 product-name">' . $products->name . '</h6>';
        // $product .= '<p>Quantity:&nbsp;<strong>' . $cart->qty . '</strong></p>';
        $product .= '<p>Quantity&nbsp;<input type="number" class="form-control" style="width:90%;" id="inputQty_' . $cart->id . '" min="1" oninput="' . $rowId . '" value="' . $cart->quantity . '"></p>';
        $product .= '<p>Rate <input type="text" class="form-control" style="width:90%;" value="BDT ' . number_format($cart->price, 2, '.', '') . '" readonly></p>';
        $product .= '<p>Total Price <input type="text" class="form-control" style="width:90%;" value=" BDT ' . number_format($total, 2, '.', '') . '" readonly></p>';
        $product .= '</div>';
        $product .= '</div>';

        return response()->json([
            'product' => $product,
            'total' => $total,
            'cartCount' => Cart::getContent()->count(),
        ]);
    }

    public function cartData()
    {
        return Cart::getContent();
    }

    public function addItemFromSingleProduct($id, $quantity)
    {
        $products = Product::where('id', $id)->first(); // get prodcut by id
        $image = ProductImage::where('productId', @$id)->first();

        if ($products->discount && $products->discount > 0) {
            $price = $products->discount;
            $vat = $products->discount * 0.05;
        } else {
            $price = $products->price;
            $vat = $products->discount * 0.05;
        }

        if ($image) {
            $img = asset('/' . @$image->images);
        } else {
            $img = asset('frontend/no-image-icon.png');
        }

        $eCart = Cart::get($products->id);
        if ($eCart) {
            $sbtl = ($eCart->quantity + $quantity) * $price;
        } else {
            $sbtl = $price;
        }

        $cart =  Cart::add([
            'id' => $products->id,
            'name' => $products->name,
            'quantity' => $quantity,
            'price' => $price,
            'attributes' => [
                'image' => $img,
                'originalPrice' => $products->price,
                'pp' => $products->pp,
                'subtotal' => $sbtl,
                'vat' => $vat,
            ]
        ]);

        $cart = $cart->get($products->id);

        $subtotal = $cart->getPriceSum();
        $total = str_replace(',', '', $subtotal);

        if (file_exists(@$image->images)) {
            $image = asset('/' . @$image->images);
        } else {
            $image = asset('frontend/no-image-icon.png');
        }
        $rowId = "UpdateShoppingCart('" . $cart->id . "')";
        $rowId = str_replace(' ', '', $rowId);

        $product = "";
        $product .= '<div class="row">';
        $product .= '<div class="col-md-6">';
        $product .= '<img class="product-image" src="' . @$image . '" alt="" title="" itemprop="image" style="height: 181px;width: 181px;display: block;margin-left: auto;margin-right: auto;margin-top: 19%;">';
        $product .= '</div>';
        $product .= '<div class="col-md-6">';
        $product .= '<h6 class="h6 product-name">' . $products->name . '</h6>';
        // $product .= '<p>Quantity:&nbsp;<strong>' . $cart->qty . '</strong></p>';
        $product .= '<p>Quantity&nbsp;<input type="number" class="form-control" style="width:90%;" id="inputQty_' . $cart->id . '" min="1" oninput="' . $rowId . '" value="' . $cart->quantity . '"></p>';
        $product .= '<p>Rate <input type="text" class="form-control" style="width:90%;" value="BDT ' . number_format($cart->price, 2, '.', '') . '" readonly></p>';
        $product .= '<p>Total Price <input type="text" class="form-control" style="width:90%;" value=" BDT ' . number_format($total, 2, '.', '') . '" readonly></p>';
        $product .= '</div>';
        $product .= '</div>';

        return response()->json([
            'product' => $product,
            'total' => $total,
            'cartCount' => Cart::getContent()->count(),
        ]);
    }

    //Show Product number in cart
    public function cartItem(Request $request)
    {
        $carts =  Cart::getContent()->count();
        $cartSubtotal =  Cart::getSubTotal();
        if ($request->ajax()) {
            return response()->json([
                'carts' => $carts,
                'cart_amount' => $cartSubtotal,
            ]);
        }
    }

    //Show Product total cost in cart
    public function minicartSubtotal(Request $request)
    {
        $carts =  Cart::getSubTotal();
        if ($request->ajax()) {
            return response()->json([
                'carts' => $carts
            ]);
        }
    }

    //Show each product in mini cart
    public function minicartProduct(Request $request)
    {
        $data = "";
        $total = 0;
        if (Cart::getContent()->count() > 0) {
            $data .= '<ul class="minicartProduct">';
            foreach (Cart::getContent() as $carts) {

                // dd($carts);
                $name = str_replace(' ', '-', $carts->name);

                if ($carts->attributes->image != '') {
                    $image = @$carts->attributes->image;
                } else {
                    $image = asset('frontend/no-image-icon.png');
                }

                // dd($image);

                $data .= '<li class="parentRow_' . $carts->id . '">';
                $data .= '<input type="hidden" name="rowId" class="rowId_' . $carts->id . '" value="' . $carts->id . '">';
                $data .= '<div class="minicart-left">';
                $data .= '<a href="' . url('product/' . @$carts->id . '/' . @$name) . '"><img class="product-iamge image-fluid" src="' . $image . '" ></a>';
                $data .= '</div>';
                $data .= '<div class="minicart-right">';
                $data .= '<p class="product-title">';
                $data .= '<a href="' . url('product/' . @$carts->id . '/' . @$name) . '">' . $carts->name . '</a>';
                $data .= '</p>';
                $data .= '<p class="product-price ">৳ ';
                $data .= '<span class="miniSubTotalPrice miniCartSubtotal_' . $carts->id . '">' . $carts->getPriceSum() . '</span>';
                $data .= '</p>';
                $data .= '<p>Quantity: ';
                $data .= '<span class="miniCartQty_' . $carts->id . '">' . $carts->quantity . '</span> ';
                $data .= '<a href="javascript:void(0)" class="remove-from-cart" style="float:right;cursor: pointer;" rel="nofollow" onclick="removeCartRow(' . "'" . $carts->id . "'" . ')" title="remove from cart">';
                $data .= '<i class="fa fa-trash-o" aria-hidden="true"></i>';
                $data .= '</a>';
                $data .= '</p>';
                $data .= '</div>';
                $data .= '</li>';

                $total += $carts->getPriceSum();
            }

            $total = str_replace(',', '', $total);
            $shipping_charges = ShippingCharges::where('shippingStatus', 1)->get();
            foreach ($shipping_charges as $k) {
                $diff[abs($k->shippingAmount - $total)] = $k;
            }

            if (@$k && $total) {
                ksort($diff, SORT_NUMERIC);
                $charge = current($diff);
                if (@$free_shipping) {

                    $shippingCharge = 0;
                } else {
                    $shippingCharge = $charge->shippingCharge;
                }
            } else {
                $shippingCharge = 0;
            }

            $grandTotal = $total + $shippingCharge;

            $data .= '</ul>';
            $data .= '<div class="cart-totals table table-bordered">';

            $data .= '<div class="products">';
            $data .= '<span class="label text-left">SubTotal</span>';
            $data .= '<span class="value items_carts total-value miniTotal">৳ ' . @$total . '</span>';
            $data .= '</div>';

            $data .= '<div class="products">';
            $data .= '<span class="label text-left">Shipping Charge</span>';
            $data .= '<span class="value items_carts total-value miniTotal">৳ ' . @$shippingCharge . '</span>';
            $data .= '</div>';

            $data .= '<div class="total totalTop">';
            $data .= '</div>';
            $data .= '<div class="products">';
            $data .= '<span class="label text-left">Total</span>';
            $data .= '<span class="value items_carts total-value miniTotal">৳ ' . @$grandTotal . '</span>';
            $data .= '</div>';
            $data .= '</div>';
            $data .= '<div class="cart-action">';
            $data .= '<a href="' . route('cart.index') . '" class="btn btn-primary">Shopping Cart</a>';
            $data .= '</div>';
        } else {
            $data .= '<span class="no-items">There are no more items in your cart</span>';
        }

        echo $data;
    }

    //Show each product in main cart page
    public function MainCartProduct(Request $request)
    {
        $data = "";
        $totalSummary = "";
        $total = 0;
        if (Cart::getContent()->count() < 1) {
            $disabled = "disabled";
        } else {
            $disabled = "";
        }
        if (Cart::getContent()->count() > 0) {
            $data .= '<ul class="cart-items">';
            foreach (Cart::getContent() as $cart) {
                $name = str_replace(' ', '-', $cart->name);
                $products = Product::where('id', $cart->id)->first();
                if ($cart->attributes->image != '') {
                    $image = asset(@$cart->attributes->image);
                } else {
                    $image = asset('/public/frontend/no-image-icon.png');
                }

                $data .= '<li class="cart-item parentRow_' . $cart->id . '">';
                $data .= '<div class="product-line-grid">';
                $data .= '<input type="hidden" name="rowId" class="rowId_' . $cart->id . '" value="' . $cart->id . '">';
                $data .= '<div class="product-line-grid-left col-md-2 col-xs-4">';
                $data .= '<span class="product-image media-middle">';
                $data .= '<img src="' . $image . '" style="height:100px;width:100px;">';
                $data .= '</span>';
                $data .= '</div>';
                $data .= '<div class="product-line-grid-body col-md-5 col-xs-8">';
                $data .= '<div class="product-line-info product-title">';
                $data .= '<a class="label text-left" href="' . url('product/' . @$cart->id . '/' . @$name) . '" data-id_customization="0">' . $cart->name . '</a>';
                $data .= '</div>';
                $data .= '<div class="product-line-info product-attributes">';
                $data .= '<span class="label">Code:</span>';
                $data .= '<span class="value">' . $products->deal_code . '</span>';
                $data .= '</div>';
                $data .= '<div class="product-line-info product-attributes">';
                $data .= '<span class="label">Quantity:</span>';
                $data .= '<span class="value">' . $cart->qty . '</span>';
                $data .= '</div>';
                $data .= '<div class="product-line-info product-price has-discount">';
                $data .= '<div class="current-price">';
                $data .= '<span class="product-price">৳ ' . $cart->price . '</span>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '<div class="product-line-grid-right product-line-actions col-md-5 col-xs-12">';
                $data .= '<div class="row">';
                $data .= '<div class="col-xs-4 hidden-md-up"></div>';
                $data .= '<div class="col-md-10 col-xs-6">';
                $data .= '<div class="row">';
                $data .= '<div class="col-md-6 col-xs-6 qty">';
                $data .= '<div class="input-group bootstrap-touchspin">';
                $data .= '<input id="inputQty_' . $cart->id . '" type="number" min="1" name="quantity" value="' . $cart->quantity . '" oninput="UpdateShoppingCart(' . "'" . $cart->id . "'" . ')" style="width: 80px;" />';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '<div class="col-md-6 col-xs-2 price">';
                $data .= '<span class="product-price">';
                $data .= '<strong>৳ ' . $cart->getPriceSum() . '</strong>';
                $data .= '</span>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '<div class="col-md-2 col-xs-2 text-xs-right">';
                $data .= '<div class="cart-line-product-actions">';
                $data .= '<a href="javascript:void(0)" class="remove-from-cart" rel="nofollow" href="" onclick="removeCartRow(' . "'" . $cart->id . "'" . ')">';
                $data .= '<i class="fa fa-trash" aria-hidden="true"></i>';
                $data .= '</a>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '<div class="clearfix"></div>';
                $data .= '</div>';
                $data .= '</li>';

                $total += $cart->getPriceSum();
            }
            $data .= '</ul>';

            $total = str_replace(',', '', $total);
            $shipping_charges = ShippingCharges::where('shippingStatus', 1)->get();
            foreach ($shipping_charges as $k) {
                $diff[abs($k->shippingAmount - $total)] = $k;
            }

            if (@$k && $total) {
                ksort($diff, SORT_NUMERIC);
                $charge = current($diff);
                if (@$free_shipping) {

                    $shippingCharge = 0;
                } else {
                    $shippingCharge = $charge->shippingCharge;
                }
            } else {
                $shippingCharge = 0;
            }

            $grandTotal = $total + $shippingCharge;
        } else {
            $data .= '<span class="no-items">There are no more items in your cart</span>';
        }

        $totalSummary .= '<div class="cart-detailed-totals">';
        $totalSummary .= '<div class="card-block">';
        $totalSummary .= '<div class="cart-summary-line" id="cart-subtotal-products">';
        $totalSummary .= '<span class="label js-subtotal">';
        $totalSummary .= Cart::getContent()->count() . ' items';
        $totalSummary .= '</span>';
        $totalSummary .= '<span class="value">';
        $totalSummary .= '৳ ' . Cart::getSubTotal();
        $totalSummary .= '</span>';
        $totalSummary .= '</div>';
        $totalSummary .= '</div>';
        $totalSummary .= '<div class="card-block cart-summary-totals">';

        $totalSummary .= '<div class="cart-summary-line">';
        $totalSummary .= '<span class="label">Sub Total&nbsp;</span>';
        $totalSummary .= '<span class="value"> ৳ ' . $total . '</span>';
        $totalSummary .= '</div>';

        $totalSummary .= '<div class="cart-summary-line">';
        $totalSummary .= '<span class="label">Shipping Charge&nbsp;</span>';
        $totalSummary .= '<span class="value"> ৳ ' . @$shippingCharge . '</span>';
        $totalSummary .= '</div>';

        $totalSummary .= '<div class="totalTop"></div>';

        $totalSummary .= '<div class="cart-summary-line">';
        $totalSummary .= '<span class="label">Total&nbsp;</span>';
        $totalSummary .= '<span class="value"> ৳ ' . @$grandTotal . '</span>';
        $totalSummary .= '</div>';

        $totalSummary .= '</div>';
        $totalSummary .= '</div>';
        $totalSummary .= '<div class="checkout cart-detailed-actions card-block">';
        $totalSummary .= '<div class="text-sm-center">';
        $totalSummary .= '<a style="margin: 0 auto;" href="' . route('cart.checkout') . '" class="btn btn-primary' . $disabled . '">Proceed to checkout</a>';
        $totalSummary .= '</div>';
        $totalSummary .= '</div>';

        return response()->json([
            'cartProduct' => $data,
            'cartSummary' => $totalSummary
        ]);
    }
}

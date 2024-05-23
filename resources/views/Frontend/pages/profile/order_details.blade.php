@extends('frontend.master')
<?php
use App\CustomerGroupSections;
?>
@section('mainContent')

    <div class="container">
        <div class="row">

            <nav data-depth="3" class="breadcrumb hidden-sm-down">
                <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="{{ route('home.index') }}">
                            <span itemprop="name">Home</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </li>


                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="{{ route('customer.profile.home') }}">
                            <span itemprop="name">Your account</span>
                        </a>
                        <meta itemprop="position" content="2">
                    </li>


                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="{{ route('customer.order') }}">
                            <span itemprop="name">Order history</span>
                        </a>
                        <meta itemprop="position" content="3">
                    </li>
                </ol>
            </nav>


            <div id="content-wrapper">
                <section id="main">
                    <header class="page-header">
                        <h1>
                            Order details
                        </h1>
                    </header>

                    <section id="content" class="page-content">
                        <aside id="notifications">
                            <div class="container">

                            </div>
                        </aside>


                        <div id="order-infos">
                            <div class="box">
                                <div class="row">
                                    <div class="col-xs-9">
                                        <strong>
                                            {{-- Order Reference KAFZLKKED - placed --}}
                                            {{-- Order on {{ $checkout->created_at->format('d-m-Y') }} --}}
                                        </strong>
                                    </div>
                                    <div class="col-xs-3 text-xs-right">
                                        {{-- <a href="#" class="button-primary">Reorder</a> --}}
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="box">
                                <ul>
                                    {{-- <li><strong>Carrier</strong> My carrier</li> --}}
                                    {{-- <li><strong>Payment method</strong> Bank transfer</li> --}}
                                </ul>
                            </div>
                        </div>


                        <section id="order-history" class="box">
                            <h3>Follow your order's status step-by-step</h3>
                            <table class="table table-striped table-bordered table-labeled hidden-xs-down">
                                <thead class="thead-default">
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $checkout->created_at->format('d/m/Y') }}</td>
                                    <td>
                                                    <span class="label label-pill bright"
                                                          style="background-color:#4169E1">
                                                          {{$checkout->status}}
                                                    </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="hidden-sm-up history-lines">
                                <div class="history-line">
                                    <div class="date">{{ $checkout->created_at->format('d/m/Y') }}</div>
                                    <div class="state">
                                                <span class="label label-pill bright" style="background-color:#4169E1">
                                                    {{$checkout->status}}
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </section>


                        <div class="addresses">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <article id="delivery-address" class="box">
                                    <h4>Delivery address My Address</h4>
                                    <address>
                                        {{ $shipping->address }}
                                    </address>
                                </article>
                            </div>

                            {{-- <div class="col-lg-6 col-md-6 col-sm-6">
                                <article id="invoice-address" class="box">
                                    <h4>Invoice address My Address</h4>
                                    <address> {{ $shipping->address }} </address>
                                </article>
                            </div> --}}
                            <div class="clearfix"></div>
                        </div>


                        <div class="box">
                            <table id="order-products" class="table table-bordered">
                                <thead class="thead-default">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit price</th>
                                    <th>Total price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $totalSubTotal = 0;
                                    $totalVat = 0;
                                @endphp
                                @foreach($orderlist as $order)
                                    <?php
                                    // dd($order);
                                    $customerId = Session::get('customerId');
                                    $customers = DB::table('customers')->where(['id' => $customerId])->first();
                                    $productImage = DB::table('product_images')->where(['productId' => $order->product_id])->first();
                                    // $name = str_slug($order->name, '-');
                                    $customer_group = DB::table('customer_group_sections')->where(['customerGroupId' => @$customers->clientGroup])
                                        ->where(['productId' => $order->product_id])
                                        ->first();
                                    if (@$customer_group->customerGroupId) {
                                        $subtotal = $customer_group->customerGroupPrice * $order->qty;
                                    } else {
                                        $subtotal = $order->price * $order->qty;
                                    }
                                    $vat = $order->vat * $order->qty;

                                    $totalSubTotal += $subtotal + $vat;
                                    $totalVat += $vat;

                                    ?>
                                    <tr>
                                        <td>
                                            <strong>
                                                <a href="{{ route('product.singles', [$order->slug]) }}">{{$order->name}}</a>
                                            </strong><br> Reference: {{$order->deal_code}}<br>
                                        </td>
                                        <td>{{$order->qty}}</td>
                                        <td class="text-xs-right">
                                            BDT <?php
                                            if(@$customer_group->customerGroupId){
                                            ?>
                                            {{$customer_group->customerGroupPrice}}
                                            <?php }else{ ?>
                                            {{number_format($order->price, 2, '.', '')}}
                                            <?php } ?>
                                        </td>
                                        <td class="text-xs-right">BDT {{number_format($subtotal, 2, '.', '')}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr class="text-xs-right line-products">
                                    <td colspan="3">Subtotal</td>
                                    <td>BDT {{ number_format($totalSubTotal, 2, '.', '') }}</td>
                                </tr>
                                <tr class="text-xs-right line-products">
                                    <td colspan="3">Vat (5%)</td>
                                    <td>BDT {{ number_format($totalVat, 2, '.', '') }}</td>
                                </tr>
                                <tr class="text-xs-right line-products">
                                    <td colspan="3">Delivery Charge</td>
                                    <td>BDT {{number_format($checkout->shipping_charge, 2, '.', '')}}</td>
                                </tr>
                                <tr class="text-xs-right line-products">
                                    <td colspan="3">Grand Total</td>
                                    <td>BDT {{ number_format(($totalSubTotal+$checkout->shipping_charge), 2, '.', '') }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>


                    </section>


                   @include('frontend.partial.customer_profile.footer_nav')

                </section>
            </div>
        </div>
    </div>

@endsection

@section('custom-css')

    <style>
        .lab-menu-vertical .menu-vertical,
        .laberMenu-top .menu-vertical {
            display: none !important;
        }

        .lab-menu-vertical .menu-vertical.lab-active,
        .laberMenu-top .menu-vertical.lab-active {
            display: block !important;
        }
    </style>

@endsection

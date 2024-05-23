@extends('frontend.master')

@section('mainContent')
    <div class="container">
        <div class="row">
            <nav data-depth="2" class="breadcrumb hidden-sm-down">
                <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">


                    <li itemprop="itemListElement">
                        <a itemprop="item" href="{{ route('home.index') }}">
                            <span itemprop="name">Home</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </li>


                    <li itemprop="itemListElement">
                        <a itemprop="item" href="{{ route('customer.order') }}">
                            <span itemprop="name">Order History</span>
                        </a>
                        <meta itemprop="position" content="2">
                    </li>
                </ol>
            </nav>


            <div id="content-wrapper">
                <section id="main">
                    <header class="page-header">
                        <h1>
                            Order history
                        </h1>
                    </header>

                    <section id="content" class="page-content">
                        <aside id="notifications">
                            <div class="container">
                            </div>
                        </aside>


                        <h6>Here are the orders you've placed since your account was created.</h6>

                        <table class="table table-striped table-bordered table-labeled">
                            <thead class="thead-default">
                            <tr>
                                <th>SL#</th>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th class="hidden-md-down">Order Value</th>
                                <th class="hidden-md-down">Order Status</th>
                                <th>Order Details</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp

                            @foreach($orderlist as $list)
                                @php
                                    $customerId = Session::get('customerId');
                                    $checkouts =  DB::table('checkouts')->where(['id'=>$list->checkout_id])->first();
                                    $orderlist =  DB::table('orders')->where(['checkout_id'=>$list->checkout_id])->get();
                                    $customers =  DB::table('customers')->where(['id'=>$customerId])->first();
                                    $total = 0;
                                    $subtotal1 = 0;
                                    foreach ($orderlist as $order) {
                                        $customer_group =  DB::table('customer_group_sections')->where(['customerGroupId'=>@$customers->clientGroup])
                                        ->where(['productId'=>$order->product_id])
                                        ->first();

                                        if(@$customer_group->customerGroupPrice){
                                            $price = $customer_group->customerGroupPrice;
                                        }else{
                                            $price = $order->price;
                                        }
                                        $vat = $order->vat * $order->qty;

                                        $subtotal = $price*$order->qty;
                                        $total +=$subtotal + $vat;
                                    }
                                    $total = $total;

                                        $inv_date = date('yd', strtotime($checkouts->created_at));
                                        $invoice_no = "MAK-" . $inv_date ."-". $checkouts->id;
                                @endphp
                                <tr>
                                    <th scope="row">{{ $i++ }}</th>
                                    <td>{{$invoice_no}}</td>
                                    <td class="text-xs-right">{{ date('d-m-Y', strtotime($checkouts->created_at)) }}</td>
                                    <td class="hidden-md-down">৳ {{$total+$checkouts->shipping_charge}}</td>
                                    <td>
                                        <span class="label label-pill bright" style="background-color:#4169E1">
                                            {{$checkouts->status}}
                                        </span>
                                    </td>
                                    <td class="text-sm-center hidden-md-down">
                                        -
                                    </td>
                                    <td class="text-sm-center order-actions">
                                        <a href="{{route('order.details',$list->checkout_id)}}">
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

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

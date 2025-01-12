@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<!--body wrapper start-->
<?php
     use App\ShippingCharges;
        $invoice_date = $checkouts->created_at->format('d-m-Y');
        $inv_date = $checkouts->created_at->format('yd');

        $invoice_no = "RUON-" . $inv_date ."-". $checkouts->id;
     ?>

<style type="text/css">
    .inv-col,
    .inv-col span {
        color: #333;
        font-size: 16px;
    }

    .card {
        font-family: sans-serif;
    }

    .price,
    .subtotal,
    .shipping-charge {
        color: #333;
    }

</style>

<div class="card">
    <div class="card-body">
        <div class="panel">
            <div class="panel-body invoice">
                <div class="row">
                    <div class="col-md-8 col-sm-4">
                        <h1 class="invoice-title">invoice</h1>
                    </div>
                    <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
                        <h3 class="inv-to"> <img style="margin-left: -30px;" src="{{ asset('/').@$company->adminLogo }}" class="light-logo large-logo" alt="large" style="width: 60px !important; height: 60px !important;" /></h3>
                        <p class="cust_info"><?php echo @$company->siteAddress1;  ?> <br>
                            <?php echo @$company->mobile2;  ?>, <?php echo @$company->mobile1;  ?>

                        </p>
                    </div>
                </div>
                <div class="invoice-address">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <h4 class="inv-to">Invoice To</h4>
                            <h2 class="corporate-id"><?php echo $shippings->name; ?></h2>
                            <p class="cust_info">
                                <?php echo $shippings->address; ?><br>
                                <?php echo $shippings->email; ?>
                                <br>
                                <?php echo $shippings->mobile;?><br>
                            </p>

                        </div>
                        <div class="col-md-4 col-sm-4">

                            <h4 class="inv-to">Shipment To</h4>
                            <h2 class="corporate-id"><?php echo $shippings->name; ?></h2>
                            <p class="cust_info">
                                <?php echo $shippings->address; ?><br>
                                <?php echo $shippings->email; ?>
                                <br>
                                <?php echo $shippings->mobile;?><br>
                            </p>


                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="inv-col"><span>Invoice#</span> {{$invoice_no}}</div>
                            <div class="inv-col"><span>Invoice Date :</span> {{$invoice_date}}</div>
                            <div class="inv-col"><span>Payment Method:
                                    @if(!empty($transactions->method))
                                    <?php if ($transactions->method == "cod") {
                                        echo "Cash On Delivery";
                                    }if ($transactions->method == "bkash") {
                                       echo "Bkash";
                                    }

                                ?>
                                    @endif
                                </span>
                                </h2>

                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-invoice">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Total Price</th>
                        </tr>
                    </thead>
                    <tbody> <?php $subtotal = 0;
                                $i = 0;
                                $totalVat = 0;
                     ?>
                        <?php foreach($orders as $orderdetails){ $i++; ?>

                        <tr>
                            <td><strong><?php echo $i; ?></strong></td>
                            <td><strong><?php echo $orderdetails->deal_code; ?></strong></td>
                            <td>
                                <p class="price"><?php echo $orderdetails->name; ?></p>

                            </td>
                            <td class="text-center"><strong>BDT <?php echo number_format($orderdetails->price, 2, '.', ''); ?></strong></td>
                            <td class="text-center"><strong><?php echo $orderdetails->qty; ?></strong></td>
                            <td class="text-right"><strong>BDT <?php echo number_format(($orderdetails->price * $orderdetails->qty), 2, '.', ''); ?></strong></td>
                        </tr>

                        <?php
                        $subtotal += $orderdetails->price * $orderdetails->qty;

                        $vat = $orderdetails->vat * $orderdetails->qty;

                        $totalVat += $vat;
                         }
                         ?>

                        <tr>
                            <td colspan="2" class="payment-method">

                            </td>
                            <td class="text-right" colspan="3">
                                <p class="subtotal">Sub Total</p>
                                <p class="shipping-charge">Vat (5%)</p>
                                <p class="shipping-charge">Shipping Charge (+)</p>
                                <p><strong>GRAND TOTAL</strong></p>
                            </td>

                            <td class="text-right">
                                <p class="subtotal">BDT {{ number_format($subtotal, 2, '.', '') }}</p>
                                <p class="shipping-charge">BDT {{ number_format($totalVat, 2, '.', '') }}</p>
                                <p class="shipping-charge">BDT <?php echo $checkouts->shipping_charge; ?></p>
                                <p><strong>BDT {{ number_format(($subtotal + $totalVat + $checkouts->shipping_charge), 2, '.', '') }}</strong></p>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="text-center ">
                <a class="btn btn-info" href="{{ url()->previous() }}" style="padding: 10px;"><i class="fa fa-arrow-left"></i> Go Back</a>
                <a href="{{ route('view.pdf',$checkouts->id) }}" target="_blank" class="btn btn-primary btn-lg"><i class="fa fa-print"></i> View Pdf </a>
            </div>

        </div>
    </div>
</div>


<!--body wrapper end-->

@endsection

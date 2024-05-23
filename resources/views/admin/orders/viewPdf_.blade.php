<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="{{ asset('admin-elite/dist/css/prints.css') }}" rel="stylesheet">
</head>
<body>
<?php
    use App\ShippingCharges;
    $invoice_date = $checkouts->created_at->format('d-m-Y');
     $invoice_no = 10000000 + $checkouts->id;
?>

    <style type="text/css">
        .inv-col, .inv-col span{
            color: #333;
            font-size: 16px;
        }

        .price, .subtotal, .shipping-charge{
            color: #333;
        }

    </style>
        <table width="100%" style="margin-top: -40px;border-bottom: 2px solid #333;padding-bottom: -10px;">
            <tr>
                <td>
                   <h1 class="invoice-title" style="margin-top: 20px;">INVOICE</h1>
                   <div class="col-md-4 col-sm-4">
                    <div class="inv-col"><span>#</span> {{$invoice_no}}</div>
                    <div class="inv-col"><span>Date :</span> {{$invoice_date}}</div>
                    <div class="inv-col"><span>Mode:
                        <?php if ($transactions->method == "cod") {
                            echo "Cash On Delivery";
                        }if ($transactions->method == "bkash") {
                           echo "Bkash";
                        }

                    ?>

                    </span>
                    </div>
                </div>

                </td>
                 <td>
                    <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4" style="width: 100%">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td align="right"><img src="{{ asset('/').@$company->adminLogo }}" style="width:60px; height: 60px" alt="large" /></td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <?php echo @$company->siteAddress1;  ?><br>
                                        <?php echo @$company->mobile2;  ?>, <?php echo @$company->mobile1;  ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

    <table style="margin-top: 0px;border-bottom: 2px solid #333;" width="100%">
        <tr>
            <td>
                <div class="col-md-4 col-sm-4">
                    <h4 class="inv-to">TO</h4>
                    <h4 class="corporate-id" style="margin-top: -10px;"><?php echo $shippings->name; ?></h4>
                    <p class="cust_info" style="margin-top: -15px;">
                    <?php echo $shippings->address; ?>
                    <br>
                    Contact No: <?php echo $shippings->mobile;?><br>
                    </p>

                </div>
            </td>
             <td width="10%">


            </td>

            <td>
                <div class="col-md-4 col-sm-4">

                    <h4 class="inv-to">SHIPPING TO</h4>
                    <h4 class="corporate-id" style="margin-top: -10px;"><?php echo $shippings->name; ?></h4>
                    <p class="cust_info" style="margin-top: -15px;">
                    <?php echo $shippings->address; ?>
                    <br>
                    Contact No: <?php echo $shippings->mobile;?><br>
                    </p>

                </div>
            </td>

        </tr>
    </table>

    <table class="orderList" width="100%" style="margin-top: 20px;">
        <thead >
        <tr style="text-align: center;background-color: #aeb1b7;line-height: 30px;">
            <th>SL</th>
            <th>Product Name</th>
            <th>Product Code</th>
            <th class="text-center">Unit Price</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Total Price</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $subtotal = 0;
        $i = 0;
        $totalVat = 0;
        ?>
        <?php foreach($orders as $orderdetails){ $i++; ?>
        <tr style="text-align: center;line-height: 12px;">
             <td><?php echo $i; ?></td>
            <td>
                <p class="price"><?php echo $orderdetails->name; ?></p>
            </td>
             <td>
                <p class="price"><?php echo $orderdetails->deal_code; ?></p>
            </td>
            <td align="right">BDT <?php echo $orderdetails->price; ?></td>
            <td align="center"><?php echo $orderdetails->qty; ?></td>
            <td align="right">BDT <?php echo number_format(($orderdetails->price * $orderdetails->qty), 2, '.', ''); ?></td>
        </tr>

            <?php $subtotal += $orderdetails->price * $orderdetails->qty ;
            ?>
        <?php } ?>

        <?php

            $shipping_charges = ShippingCharges::where('shippingStatus',1)->get();

            foreach($shipping_charges as $k ){
                $diff[abs($k->shippingAmount - $subtotal)] = $k;
            }
                if (@$k) {
                    ksort($diff, SORT_NUMERIC);
                    $charge = current($diff);

                    if ($orderdetails->free_shipping == 'free') {
                        $shippingCharge = 0;
                    }else{
                        $shippingCharge = $charge->shippingCharge;
                    }

                    $grand_total = $shippingCharge+$subtotal;
                }else{
                    $shippingCharge = 0;
                    $grand_total = $shippingCharge+$subtotal;
                }

            $vat = $orderdetails->vat * $orderdetails->qty;
            $grand_total += $vat;

            $totalVat += $vat;
        ?>

        </tbody>
    </table>

    <footer>

    <span class="totalTable">

        <table width="100%">
            <tr>
                <td width="70%" align="right"><strong>Sub Total:</strong></td>
                <td align="right" width="30%"> BDT {{ number_format($subtotal, 2, '.', '') }}</td>
            </tr>
            <tr>
                <td width="70%" align="right"><strong>Vat (5%):</strong></td>
                <td align="right" width="30%">BDT <?php echo number_format($totalVat, 2, '.', ''); ?></td>
            </tr>
            <tr>
                <td width="70%" align="right"><strong>Shipping Charge (+):</strong></td>
                <td align="right" width="30%">BDT <?php echo $checkouts->shipping_charge; ?></td>
            </tr>
            <tr>
                <td width="70%" align="right"><strong>Total:</strong></td>
                <td align="right" width="30%">BDT {{ number_format(($grand_total + $checkouts->shipping_charge), 2, '.', '') }}</td>
            </tr>
        </table>

    </span>
</footer>
</body>
</html>


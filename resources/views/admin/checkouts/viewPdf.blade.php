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
                    <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
                    <h3 style="text-align: right;" class="inv-to"> <img src="{{ asset('/').@$company->adminLogo }}" class="light-logo large-logo" alt="large" /></h3>
                    <p style="text-align: right;margin-top: -15px;" class="cust_info"><?php echo @$company->siteAddress1;  ?><br/> <?php echo @$company->siteAddress2;  ?><br>
                        <?php echo @$company->mobile2;  ?>, <?php echo @$company->mobile1;  ?>

                    </p>
                </div>
                </td>
            </tr>
        </table>

    <table style="margin-top: 0px;border-bottom: 2px solid #333;" width="100%">
        <tr>
            <td>
                <div class="col-md-4 col-sm-4">
                    <h4 class="inv-to">INVOICE TO</h4>
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
        <tbody> <?php $subtotal = 0;  $i = 0 ?>
        <?php foreach($orders as $orderdetails){ $i++; ?>
        <tr style="text-align: center;line-height: 12px;">
             <td><?php echo $i; ?></td>
            <td>
                <p class="price"><?php echo $orderdetails->name; ?></p>
            </td>
             <td>
                <p class="price"><?php echo $orderdetails->deal_code; ?></p>

            </td>
            <td class="text-center"><?php echo $orderdetails->price; ?></td>
            <td class="text-center"><?php echo $orderdetails->qty; ?>
            </td>
            <td class="text-center"> <?php echo $orderdetails->price * $orderdetails->qty; ?></td>
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


        ?>

        </tbody>
    </table>

    <footer>

    <span class="totalTable">

        <table width="100%">
            <tr>
                <td width="30%"></td>
                <td width="30%"></td>
                <td>
                    <p class="subtotal" align="right">Sub Total <br> Shipping Charge (+)</p>
                    <p align="right"><strong>GRAND TOTAL</strong></p>
                </td>
                <td>
                    <p class="subtotal" align="right"> <?php echo $subtotal; ?> Tk<br><?php echo $shippingCharge; ?> Tk</p>
                    <p align="right"><strong><?php echo $grand_total; ?> Tk</strong></p>
                </td>
            </tr>
        </table>

    </span>
</footer>
</body>
</html>




     <!--body wrapper start-->
     <?php
        $invoice_date = $checkouts->created_at->format('d-m-Y');
     ?>
    
    <style type="text/css">
        .inv-col, .inv-col span{
            color: #333;
            font-size: 16px;
        }
        .card{
            font-family: sans-serif;
        }
        .price, .subtotal, .shipping-charge{
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
                            <h1 class="inv-to"><b>Naksighar</b></h1>
                            <p class="cust_info"><?php echo @$company->siteAddress1;  ?> <br/> <?php echo @$company->siteAddress2;  ?> <br>
                                <?php echo @$company->mobile1;  ?><br>
                                <?php echo @$company->mobile2;  ?>
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
                                <div class="inv-col"><span>Invoice#</span> {{$checkouts->id}}</div>
                                <div class="inv-col"><span>Invoice Date :</span> {{$invoice_date}}</div>
                                <div class="inv-col"><span>Payment Method: 
                                    <?php if ($transactions->method == "cod") {
                                        echo "Cash On Delivery";
                                    }if ($transactions->method == "bkash") {
                                       echo "Bkash";
                                    }
                                   
                                ?>
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
                        <th>Product Name</th>
                        <th class="text-center">Unit Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Total Price</th>
                    </tr>
                    </thead>
                    <tbody> <?php $subtotal = 0; ?> 
                    <?php foreach($orders as $orderdetails){ ?>
                    <tr>
                        <td>1</td>
                        <td>
                            <p class="price"><?php echo $orderdetails->name; ?></p>
                            
                        </td>
                        <td class="text-center"><strong><?php echo $orderdetails->price; ?></strong></td>
                        <td class="text-center"><strong><?php echo $orderdetails->qty; ?></strong></td>
                        <td class="text-center"><strong>৳ <?php echo $orderdetails->price * $orderdetails->qty; ?></strong></td>
                    </tr>

                        <?php $subtotal += $orderdetails->price * $orderdetails->qty ?>
                    <?php } ?>
                    
                    
                    <tr>
                        <td colspan="2" class="payment-method">
                            
                        </td>
                        <td class="text-right" colspan="2">
                            <p class="subtotal">Sub Total</p>
                            <p class="shipping-charge">Shipping Charge (+)</p>
                            <p><strong>GRAND TOTAL</strong></p>
                        </td>
                        <td class="text-center">
                            <p class="subtotal">৳ <?php echo $subtotal; ?></p>
                            <p class="shipping-charge">0.00</p>
                            <p><strong>৳ <?php echo $subtotal; ?></strong></p>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            

        </div>
    </div>
</div>


        <!--body wrapper end-->


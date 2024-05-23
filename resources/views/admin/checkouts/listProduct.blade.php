@extends('admin.layouts.master')

@section('title')
Admin
@endsection

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page-name')
order
@endsection

@section('content')
<?php
    use App\Product;
    use App\Invoice;
?>

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')
                  
                ?>
                <h4 class="card-title" style="float: left;">Order List</h4>
                <a href="{{url('/admin/view-invoice/'.$invoiceId)}}" class="btn btn-info" style="float: right;">VIEW INVOICE</a>
                <br>
                <br>
                <div class="table-responsive">
                    <table id="ordersTable" class="table table-bordered table-striped"  name="ordersTable">
                        <thead>
                            <tr>
                                <th>S/L</th>
                                <th>Product Code</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php $i = 1; ?>
                            @foreach($orders as $order)
                            <?php
                               $products = product::where('id',$order->product_id)->first();
                               $amount = $order->qty*$order->price;

                               $invoices  = Invoice::where('orderId',$order->id)->first();

                                $i++;
                               /* if ($order->status == "Waiting") {*/
                            ?>
                              
                            <tr>
                                <input type="hidden" name="rowId" value="{{ $order->id }}">
                                <td>{{$i}}</td>
                                
                                <td width="13%">{{ @$products->deal_code }}</td>
                                <td>{{ @$products->name }}</td>
                                <td class="quant-input" width="35%">
                                  <input type="number" value ="{{ @$order->qty }}" name="" style="width: 40%">
                                  
                                <?php
                                  if (!$invoices) {
                                    
                                ?>
                                  <a class="btn btn-success" href="{{url('/admin/add-to-invoice/'.$order->id)}}" style="float: right;">ADD TO INVOICE</a> 
                                <?php }else{ ?>
                                  <a class="btn btn-success" href="{{url('/admin/remove-from-invoice/'.$order->id)}}" style="float: right;">Remove from Invoice</a> 
                                <?php } ?>
                                </td>
                                <td width="15%" class="price-column"><input type="number" value ="{{ @$order->price }}" name="" style="width: 100%"></td>
                                <td class="amount-column">
                                  <span class="amount">{{ @$amount }}</span>
                                </td>
                               
                                <td class="text-nowrap">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Order status" data-id="{{ $order->id }}"> <i class="fa fa-shopping-bag text-danger m-r-10"></i> 
                                    </a>

                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="{{$order->id}}"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
                                </td>
                            </tr>
                        <?php //} ?>
                      
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
$(document).ready(function(){
  var fadeTime = 0;

//Update order quantity of product
  $('.quant-input input').change( function() {
    
  var productRow = $(this).parent().parent();
 
  var quantity = $(this).val();
  var rowId = productRow.find('input[name=rowId]').val();
  var price = productRow.children('.price-column').children('input').val();
  var amount = quantity * price;
  
  $.ajax({
      url: "{!! url('/admin/ordersQuantity') !!}" + "/" + rowId+"/update/"+quantity,
      data: {
          rowId:rowId,
          qty:quantity,
      },
      cache:false,
      contentType: false,
      processData: false,
      success: function() {
         productRow.children('.amount-column').children('.amount').each(function () {
          $(this).fadeOut(fadeTime, function() {
            $(this).text(amount);
            $(this).fadeIn(fadeTime);
           
          });
        });
      },

      error: function() {
         swal({
            title: "<small class='text-danger'>error!</small>", 
            type: "success",
            text: "",
            timer: 1000,
            html: true,
        });
      }
  });   
});

// Update Order price of product
  $('.price-column input').change( function() {
    
  var productRow = $(this).parent().parent();
 
  var price = $(this).val();
  var rowId = productRow.find('input[name=rowId]').val();
  var quantity = productRow.children('.quant-input').children('input').val();
  var amount = quantity * price;
  
  $.ajax({
      url: "{!! url('/admin/ordersPrice') !!}" + "/" + rowId+"/update/"+price,
      data: {
          rowId:rowId,
          price:price,
      },
      cache:false,
      contentType: false,
      processData: false,
      success: function() {
         productRow.children('.amount-column').children('.amount').each(function () {
          $(this).fadeOut(fadeTime, function() {
            $(this).text(amount);
            $(this).fadeIn(fadeTime);
           
          });
        });
      },

      error: function() {
         swal({
            title: "<small class='text-danger'>error!</small>", 
            type: "success",
            text: "",
            timer: 1000,
            html: true,
        });
      }
  });   
});
 
 
});
</script>

@endsection


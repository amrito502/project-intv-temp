@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h4 class="card-title">{{ $title }}</h4>
          </div>
          <div class="col-md-6" style="text-align: right">

            <a href="#" style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"
              onclick="window.history.go(-1); return false;">
              <i class="fa fa-arrow-circle-left"></i> Go Back
            </a>

            <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"
              href="{{ url('/admin/view-invoice/'.$invoiceId) }}">
              <i class="fa fa-arrow-circle-left"></i> View Invoice
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        @php
        $message = Session::get('msg');
        if (isset($message)) {
        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong>
        </div>";
        }

        Session::forget('msg')
        @endphp
        <?php
                  
                ?>
        <div class="table-responsive">
          <table id="ordersTable" class="table table-bordered table-striped" name="ordersTable">
            <thead>
              <tr>
                <th>S/L</th>
                <th>Product Code</th>
                <th>Name</th>
                <th>OLD Quantity</th>
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

                <td>{{ @$products->deal_code }}</td>
                <td>{{ @$products->name }}</td>
                <td class="old_qty">{{ @$order->old_qty }}</td>
                <td class="quant-input" width="30%">
                  <input type="number" value="{{ @$order->qty }}" name="" style="width: 40%">
                  &nbsp;&nbsp;&nbsp;
                  <?php
                                  if (!$invoices) {
                                    
                                ?>
                  <a class="btn btn-success" href="{{url('/admin/add-to-invoice/'.$order->id)}}"
                    style="float: right;">ADD TO INVOICE</a>
                  <?php }else{ ?>
                  <a class="btn btn-success" href="{{url('/admin/remove-from-invoice/'.$order->id)}}"
                    style="float: right;">Remove from Invoice</a>
                  <?php } ?>
                </td>
                <td class="price-column"><input type="number" value="{{ @$order->price }}" name="" style="width: 78%">
                </td>
                <td class="amount-column">
                  <span class="amount">{{ @$amount }}</span>
                </td>

                <td class="text-nowrap">
                  {{-- <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Order status"
                    data-id="{{ $order->id }}"> <i class="fa fa-shopping-bag text-danger m-r-10"></i>
                  </a> --}}

                  <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete"
                    data-id="{{$order->id}}" data-token="{{ csrf_token() }}"> <i
                      onclick="deleteItem(event ,'{{$order->id}}')" class="fa fa-trash text-danger"></i>
                  </a>
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
      success: function(old_qty) {
        // console.log(old_qty);

         productRow.children('.amount-column').children('.amount').each(function () {
          $(this).fadeOut(fadeTime, function() {
            $(this).text(amount);
            $(this).fadeIn(fadeTime);
           
          });
        });

        // console.log(productRow.children('.old_qty'));
        // productRow.children('.old_qty').text(old_qty);

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

function deleteItem(e, id) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  item_id = id;
  // var checkout = this;
  swal({
    title: "Are you sure?",
    text: "You will not be able to recover this imaginary file!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel plx!",
    closeOnConfirm: false,
    closeOnCancel: false
  }, function(isConfirm){
    if (isConfirm) {
    let targetTr = e.target.parentNode.parentNode.parentNode;
    $.ajax({
      type: "POST",
      url: "{{ route('order.item.delete') }}",

      data: {
        item_id:item_id
      },

      success: function(response) {
      swal({
        title: "<small class='text-success'>Success!</small>",
        type: "success",
        text: "Order information deleted successfully!",
        timer: 1000,
        html: true,
      });
      targetTr.remove();
      },
      error: function(response) {
        error = "Failed.";
        swal({
          title: "<small class='text-danger'>Error!</small>",
          type: "error",
          text: error,
          timer: 1000,
          html: true,
        });
      }
    });
    } else {
      swal({
        title: "Cancelled",
        type: "error",
        text: "Your order detail is safe :)",
        timer: 1000,
        html: true,
      });
    }
  });
}

</script>

@endsection
@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('custom_css')
<style type="text/css">
    .table td {
        height: 75px;
        /* line-height: 75px; */
    }
</style>
@endsection

@section('content')
@php
use App\ProductImage;
use App\Category;
@endphp

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a style=" font-size: 16px;" class="btn btn-outline-info btn-lg"
                                href="{{ route('productList.print.get')}}">
                                <i class="fa fa-print"></i> Print
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    @php
                    $message = Session::get('msg');
                    if (isset($message))
                    {
                    echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>"
                            .$message."</strong></div>";
                    }

                    Session::forget('msg');
                    $sl = 0;
                    @endphp

                    <table id="dataTable" class="table table-bordered table-striped" name="productTable">
                        <thead>
                            <tr>
                                <th width="20px">SL</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>MRP</th>
                                <th>DP</th>
                                <th>Point</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach($products as $product)
                            <tr>
                                @php
                                $sl++;
                                if($product->discount){
                                $discount = $product->discount;
                                }else{
                                $discount = '0.00';
                                }
                                @endphp
                                <td class="pt-4">{{ $sl }}</td>
                                <td class="pt-4">{{ @$product->deal_code }}</td>
                                <td class="pt-4">{{ @$product->name }}</td>
                                <td class="pt-4">{{ @$product->category->categoryName }}</td>
                                <td>
                                    @php
                                    if($product->images != ""){
                                    $image = asset('/').@$product->images;
                                    }else{
                                    $image = $noImage;
                                    }
                                    @endphp

                                    <img src="{{ @$image }}" style="width: 75px; height: 75px; margin: 0px;">
                                </td>
                                <td>{{ @$product->price }}</td>
                                <td>{{ @$discount}}</td>
                                <td>{{ $product->pp }}</td>
                            </tr>
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
@endsection

@section('custom-js')
<!-- This is data table -->
<script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
            var updateThis ;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            // var table = $('#productTable').DataTable( {
            //     "order": [[ 0, "asc" ]]
            // } );

            // table.on('order.dt search.dt', function () {
            //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            //         cell.innerHTML = i+1;
            //     } );
            // } ).draw();
            //ajax


            //ajax delete code
            $('#productTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                product_id = $(this).parent().data('id');
                var product = this;
                /*$.ajax({
                    type : 'POST',
                    url : "{{ route('single-product-destroy') }}",
                    data : {product_id:product_id},
                    success:function(res){
                        alert("success");
                    }
                }); */

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
                        $.ajax({
                            type: "POST",
                           url : "{{ route('single-product-destroy') }}",
                            data : {product_id:product_id},

                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Product deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(product).parents('tr'))
                                    .remove()
                                    .draw();
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
                            text: "Your product is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });

        //ajax status change code
        function statusChange(product_id) {
            $.ajax({
                    type: "GET",
                    url: "{{ route('products.changeStatus', 0) }}",
                    data: "product_id=" + product_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        swal({
                            title: "<small class='text-success'>Success!</small>",
                            type: "success",
                            text: "Status successfully updated!",
                            timer: 1000,
                            html: true,
                        });
                    },
                    error: function(response) {
                         swal({
                            title: "<small class='text-success'>Success!</small>",
                            type: "success",
                            text: "Status successfully updated!",
                            timer: 1000,
                            html: true,
                        });
                       /* error = "Failed.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>",
                            type: "error",
                            text: error,
                            timer: 2000,
                            html: true,
                        });*/
                    }
                });
            }
</script>
@endsection

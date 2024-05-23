@extends('admin.layouts.master')

@section('custom_css')
<style type="text/css">
    .table td {
        /*height: 30px;
            line-height:30px;*/
        vertical-align: middle !important;
    }

    /* .table select, .table input{
            height: 100%;
            width: 100%;
        } */
    .table textarea {
        height: 32px;
        vertical-align: middle;
        width: 100%;
    }

    .dataTables_length {
        float: left !important;
    }

    /* .dataTables_filter {
        float: left !important;
        margin-left: 30px !important;
    } */

    .chosen-single {
        width: 250px;
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
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive" style="overflow-x: hidden;display: contents;">
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
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Select Cetagory</label>
                            <select class="form-control chosen-select category">
                                <option value="">Select Category</option>
                                @php
                                foreach ($categoryList as $category) {
                                if($category->id == $categoryParam){
                                $selected = 'selected';
                                }else{
                                $selected = '';
                                }
                                @endphp
                                <option {{$selected}} value="{{$category->id}}">{{$category->categoryName}}</option>
                                @php } @endphp
                            </select>
                        </div>

                        <div class="col-md-3 offset-md-5">
                            <div class="form-group">
                                <label for="">Discount Offer (%)</label>
                                <input type="number" class="form-control" id="newDiscount" name="newDiscount">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-info" style="margin-top: 30px;"
                                onclick="AddDiscountMultiple()">update</button>
                        </div>

                    </div>
                    <table id="productTable" class="table table-bordered table-striped" name="productTable">
                        <thead>
                            <tr class="bg-success">
                                <th width="10px">
                                    <input type="checkbox" class="checkAll" id="checkAll">
                                </th>
                                <th width="200px">Product Name</th>
                                <th width="90px">Code</th>
                                <th width="105px">Price</th>
                                <th width="105px">Discount price</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @if(count(@$products) > 0)
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <input type="checkbox" class="productCheckBox" value="{{ $product->id }}">
                                </td>
                                <td>
                                    {{ @$product->name }}
                                </td>
                                <td>
                                    {{ @$product->deal_code }}
                                </td>
                                <td>
                                    {{ @$product->price }}
                                </td>
                                <td>
                                    {{ @$product->discount }}
                                </td>

                            </tr>
                            @endforeach
                            @endif
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    function AddDiscountMultiple(){

        const discountPercentage = +$('#newDiscount').val();
        

        $('.productCheckBox:checkbox:checked').each((i, el) => {
            const currentCheckBoxValue = $(el).val();
            AddDiscountSingle(discountPercentage, currentCheckBoxValue)
        });

        location.reload();

    }

    function AddDiscountSingle(discountPercentage, productId){

        axios.post('{{ route('product.quickUpdateDiscount') }}', {
            discountPercentage:discountPercentage,
            productId: productId,
        })
        .then(function (response) {

        })
        .catch(function (error) {
        })

    }

    $(function () {
        $("#checkAll").click(function(){
        $('.productCheckBox').prop('checked', this.checked);
    });
        
    });



</script>

<script type="text/javascript">
    // $(document).ready(function() {
    //         var updateThis ;

    //         var table = $('#productTable').DataTable( {
    //             "order": [[ 0, "asc" ]]
    //         } );

    //         table.on('order.dt search.dt', function () {
    //             table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
    //                 cell.innerHTML = i+1;
    //             } );
    //         } ).draw();

    //     });

        function UpdateProduct(productId) {
                var deal_code = $('.deal_code_'+productId).val();
                var name = $('.name_'+productId).val();
                var category_id = $(".category_id_"+productId+" option:selected").val();
                var price = $('.price_'+productId).val();
                var discount = $('.discount_'+productId).val();
                var orderBy = $('.orderBy_'+productId).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    url: "{{ route('product.quickUpdate') }}",
                    data: {
                        productId:productId,
                        deal_code:deal_code,
                        name:name,
                        category_id:category_id,
                        price:price,
                        discount:discount,
                        orderBy:orderBy,
                    },
                    success: function(response) {
                        swal({
                            title: "<small class='text-success'>Success!</small>", 
                            type: "success",
                            text: "Product Successfully Updated!",
                            timer: 1000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        errorMessage = Object.entries(response.responseJSON.errors);
                        error = "Failed.";
                        swal({
                            title: "<small class='text-danger'>Error! "+errorMessage[0][1]+"</small>", 
                            type: "error",
                            text: error,
                            timer: 2000,
                            html: true,
                        });
                    }
                });
            }
                
</script>

<script type="text/javascript">
    $('.category').on('change', function(){
          var category = $('.category').val();
          window.location.href = "{{route('product.quickUpdateDiscountList')}}"+"?category="+category;
        }); 
</script>

@endsection
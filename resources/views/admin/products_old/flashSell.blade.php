@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<style type="text/css">

 .uploadImage{
        color: red;
        margin-top: 5px;
    }

  .hotDeal input,.specialDeal input{
    padding: 7px;
  }
  .hotDeal{
    margin-left: 24px;
  }
  .modal-body{
  border: 2px solid #f3bfbf;
}
.allInfo{
    margin-bottom: 15px;
}

.gallery img{
    width: 168px;
    margin-left: 7px;
    margin-top: 7px;
    border: 3px solid #c7b8b8;
    border-radius: 4px;
    padding: 7px;
}
.chosen-container { width: 100% !important }
.search-choice{
    width: auto;
    display: inline-block;
}

.remove{
    margin-top: -125px;
    margin-left: -33px;
}

.bootstrap-tagsinput{
    width: 670px;
}


</style>




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

                <?php
                    $message = Session::get('error_msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-danger'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')
                ?>
                <h4 class="card-title">Flash Sell</h4>

                  <div id="addNewProduct" class="">
                    <div class="">
                        <div class="">
                            <form class="form-horizontal" action="{{ route('flashSell.update') }}" method="POST" enctype="multipart/form-data" name="advanceInfo">
                        {{ csrf_field() }}

                        <div class="modal-body">
                            <div class="col-md-10 m-b-20 text-right">
                                <button type="submit" class="btn btn-info waves-effect">Save</button>
                            </div>

                             <div class="form-group row {{ $errors->has('special') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-2 col-form-label">Flash Sell</label>
                                <div class="col-sm-7">
                                    {{--  <input type="text" placeholder="Price for for flash sell" name="flashPrice" value="{{  @$flashProducts->flashPrice }}"> --}}

                                     <input type="text" class="datepicker" placeholder="Date" name="flashDate" value="{{ @$flashProducts->flashDate }}">

                                </div>


                            </div>
                             <?php
                                 @$flashProduct = explode(',', $flashProducts->flashProduct);

                            ?>

                            <div class="form-group row">
                                <label for="inputHorizontalDnger" class="col-sm-2 col-form-label"> Add Product</label>
                                <div class="col-sm-7">
                                <select name="flashProduct[]" data-placeholder="Select Products" class="form-control chosen-select" multiple tabindex="4">

                                    @foreach($productsAll as $products)
                                            <option <?php if (in_array($products->id, $flashProduct)){echo "selected";} ?> value="{{ $products->id }}">{{ $products->name }}({{ $products->deal_code }})</option>
                                     @endforeach


                                </select>
                                    @if ($errors->has('related_product'))
                                    @foreach($errors->get('related_product') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            </div>
                        </form>

                    </div>
                    </div>
                    <!-- /.modal-dialog -->
                </div>

            </div>
        </div>
    </div>
</div>


@endsection

@section('custom-js')

<script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}">

</script>


<script type="text/javascript">
     $(document).ready(function() {

            var updateThis ;

        //ajax upload image
            $( "form[name='image-form']" ).on( "submit", function( event ) {
                $('.has-danger').removeClass('has-danger');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('image.upload') }}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var product = response.product;
                        var images = response.images;
                        swal({
                            title: "<small class='text-success'>Success!</small>",
                            type: "success",
                            text: "Image Successfully Uploded!",
                            timer: 2000,
                            html: true,
                        });
                        $('#images').html(images);
                        /*$("#div_image_reload").load(location.href + " #div_image_reload");*/
                    },
                    error: function(response) {

                    }
                });

                $("#image-form")[0].reset();
            });

            //ajax remove image
            $('.remove').on('click', function(e){
                e.preventDefault();
                let id = $(this).attr('data-id');

                var image_row = $(this).parent().children();
                var close_button = $(this).parent().children('.single-image');

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
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type : 'DELETE',
                             url: "{{ route('image.remove') }}",
                            data : {
                                id : id,
                            },
                            success : function(response){
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Image deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                if(response){
                                    image_row.remove();

                                }
                            }.bind(this)
                        })

             }else {
                        swal({
                            title: "Cancelled",
                            type: "error",
                            text: "Your Image is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
         });

            });

        });
</script>


 <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });

            var updateThis ;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#productsTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );



        });

            function summernote(){
                $('.summernote').summernote({
                    height: 200, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: false // set focus to editable area after initializing summernote
                });
            }
</script>

<script>


    function basic() {

        $(this).addClass('active');
        $('.advance').removeClass('active');
        $('.seo').removeClass('active');
        $('.others').removeClass('active');
        $('.basic').addClass('active');
        $('#basicInfo').show();
        $('#image-form').hide();
        $('#advanceInfo').hide();
        $('#seoInfo').hide();
        $('#othersInfo').hide();

    }

    function advance() {
        $(this).addClass('active');
        $('.basic').removeClass('active');
        $('.seo').removeClass('active');
        $('.others').removeClass('active');
        $('.advance').addClass('active');
        $('#image-form').show();
        $('#advanceInfo').show();
        $('#basicInfo').hide();
        $('#seoInfo').hide();
        $('#othersInfo').hide();


    }
    function seo() {

        $(this).addClass('active');
        $('.basic').removeClass('active');
        $('.advance').removeClass('active');
        $('.others').removeClass('active');
        $('.seo').addClass('active');
        $('#basicInfo').hide();
        $('#advanceInfo').hide();
        $('#image-form').hide();
        $('#seoInfo').show();
        $('#othersInfo').hide();


    }
    function others() {

        $(this).addClass('active');
        $('.basic').removeClass('active');
        $('.advance').removeClass('active');
        $('.seo').removeClass('active');
        $('.others').addClass('active');
        $('#basicInfo').hide();
        $('#advanceInfo').hide();
        $('#image-form').hide();
        $('#seoInfo').hide();
        $('#othersInfo').show();


    }



</script>

<script type="text/javascript">
    $(function () {
        $("#hotInput").click(function () {
            if ($(this).is(":checked")) {
                $("#hotDeal").show();
                $("#specialInput"). prop("checked", false);
                $("#specialDeal").hide();
            } else {
                $("#hotDeal").hide();
            }
        });
    });

    $(function () {
        $("#specialInput").click(function () {
            if ($(this).is(":checked")) {
                $("#specialDeal").show();
                $("#hotInput"). prop("checked", false);
                $("#hotDeal").hide();
            } else {
                $("#specialDeal").hide();
            }
        });
    });
</script>


<script type="text/javascript">
    var dateToday = new Date();
    $(function() {
        $( ".datepicker" ).datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            minDate: dateToday,
            dateFormat: 'dd MM yy'
        });
    });
</script>

@endsection



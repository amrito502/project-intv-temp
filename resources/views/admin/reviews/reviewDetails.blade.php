@extends('admin.layouts.master')

@section('title')
Admin
@endsection

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page-name')
View Customer Details
@endsection

@section('content')
@php
   use App\Product;
    $product = Product::where('id',$reviews->productId)->first();
@endphp
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <span class="shortlink">
                 <a class="btn btn-info" type="submit" href="{{ route('reviews.index') }}">Go Back</a>
            </span>
            <div class="card-body">
                <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')
                  
                ?>
                <h4 class="card-title">View Rebiew Details</h4>

                  <div id="addNewProduct" class="">
    <div class="">        
        <div class="">
            
            <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" id="editCustomer" name="editCustomer">
            {{ csrf_field() }}

            @if( count($errors) > 0 )
                
            <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>
            
        @endif
            <div class="modal-body">
                
               
                <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-danger"  name="name" value="{{ $reviews->name}}" readonly>
                        @if ($errors->has('name'))
                        @foreach($errors->get('name') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-danger"  name="name" value="{{ $product->name}}" readonly>
                        @if ($errors->has('name'))
                        @foreach($errors->get('name') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
             

                <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product Code</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-danger"  name="name" value="{{ $product->deal_code}}" readonly>
                        @if ($errors->has('name'))
                        @foreach($errors->get('name') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                 <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Review</label>
                    <div class="col-sm-7">
                        <textarea style="min-height: 200px;" class="form-control" readonly>{{ $reviews->review }}</textarea>
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Rating</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-danger"  name="name" value="{{ $reviews->star }}" readonly>
                        @if ($errors->has('name'))
                        @foreach($errors->get('name') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>


                <input type="hidden" name="CustomerId" value="{{$reviews->id}}">
            
               
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

     <script type="text/javascript">
        document.forms['editCustomer'].elements['reviewstatus'].value = "{{$reviews->reviewstatus}}";

        
    </script>

@endsection
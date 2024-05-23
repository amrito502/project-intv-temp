@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
                    <div class="col-md-6">  
                        <span class="shortlink">
                         <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"  href="{{ route($goBackLink) }}">
                            <i class="fa fa-arrow-circle-left"></i> Go Back
                         </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
               
                <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')
                  
                ?>

                  <div id="addNewProduct" class="">            
                    <form class="form-horizontal" action="{{ route('shippingCharge.update') }}" method="POST" enctype="multipart/form-data" id="editCategory" name="editCategory">
                        {{ csrf_field() }}

                        @if( count($errors) > 0 )

                        <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>

                        @endif
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect">Update</button>
                                </div>
                            </div>

                            <input type="hidden" name="chargeId" value="{{$shipping_charges->id}}">

                            <div class="form-group row {{ $errors->has('shippingAmount') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Shipping Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-danger" placeholder="Shipping amount" name="shippingAmount" value="{{ $shipping_charges->shippingAmount }}" required>
                                    @if ($errors->has('shippingAmount'))
                                    @foreach($errors->get('shippingAmount') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('shippingCharge') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Shipping Charge</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-danger" placeholder="Shipping charge" name="shippingCharge" value="{{ $shipping_charges->shippingCharge }}" required>
                                    @if ($errors->has('shippingCharge'))
                                    @foreach($errors->get('shippingCharge') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('shippingLocation') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Location</label>
                                <div class="col-sm-7">
                                    <input type="radio" class=" form-control-danger" name="shippingLocation" value="inside" <?php if(@$shipping_charges->shippingLocation == "inside"){echo "checked";} ?>  required> Inside Dhaka

                                    <input style="margin-left: 10px" type="radio" class=" form-control-danger" name="shippingLocation" value="outside" <?php if(@$shipping_charges->shippingLocation == "outside"){echo "checked";} ?> required> Outside Dhaka
                                    @if ($errors->has('shippingLocation'))
                                    @foreach($errors->get('shippingLocation') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta Title</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-danger" placeholder="Meta Title" name="metaTitle" value="{{ $shipping_charges->metaTitle }}">
                                    @if ($errors->has('metaTitle'))
                                    @foreach($errors->get('metaTitle') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('metaKeyword') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta keyword</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-danger" placeholder="Meta Keyword" name="metaKeyword" value="{{ $shipping_charges->metaKeyword }}">
                                    @if ($errors->has('metaKeyword'))
                                    @foreach($errors->get('metaKeyword') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta description</label>
                                <div class="col-sm-9">
                                    <textarea style="min-height: 100px;" class="form-control" name="metaDescription">{{ $shipping_charges->metaDescription }}</textarea>
                                    @if ($errors->has('metaDescription'))
                                    @foreach($errors->get('metaDescription') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('shippingStatus') ? ' has-danger' : '' }}">
                                <label class="col-sm-3 col-form-label">Publication status</label>
                                <div class="col-sm-9 row">
                                    <div class="form-control">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="published" name="shippingStatus" class="custom-control-input" value="1" required>
                                            <label class="custom-control-label" for="published">Published</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="unpublished" name="shippingStatus" class="custom-control-input" checked="" value="0">
                                            <label class="custom-control-label" for="unpublished">Unpublished</label>
                                        </div>
                                    </div>                            
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect">Update</button>
                                </div>
                            </div>
                        </div>                
                    </form>
    <!-- /.modal-dialog -->
</div>
                
            </div>
        </div>
    </div>
</div>

     <script type="text/javascript">
   
        document.forms['editCategory'].elements['shippingStatus'].value = "{{$shipping_charges->shippingStatus}}";

        
    </script>

@endsection
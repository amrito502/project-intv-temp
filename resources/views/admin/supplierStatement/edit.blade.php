@extends('admin.layouts.master')

@section('content')

<style type="text/css">
    .chosen-single{
        height: 33px !important;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
    <span class="shortlink">
        <a class="btn btn-info"  href="{{ route('vendor.add') }}">Add New</a>
        <a class="btn btn-info"  href="{{ route('vendor.index') }}">Go Back</a>
    </span>
            <div class="card-body">
                <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')
                  
                ?>
                <h4 class="card-title">Edit Vendor</h4>

                  <div id="addNewMenu" class="">
    <div class="">        
        <div class="">
           <form class="form-horizontal" action="{{ route('vendor.update') }}" method="POST" enctype="multipart/form-data" id="newMenu" name="newMenu">
            {{ csrf_field() }}
            
            @if( count($errors) > 0 )
                
            <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>
            
        @endif
            <div class="modal-body">
               
            <div class="col-md-9 m-b-20 text-right">    
                 <button type="submit" class="btn btn-info waves-effect">Update</button> 
            </div>
            <br>
            <input type="hidden" value="{{$vendors->id}}" name="vendorId">
            <div class="form-group row {{ $errors->has('vendor_serial') ? ' has-danger' : '' }}">
                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">SL No</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-danger" name="vendor_serial" value="{{ $vendors->vendor_serial }}">
                    @if ($errors->has('vendor_serial'))
                    @foreach($errors->get('vendor_serial') as $error)
                    <div class="form-control-feedback">{{ $error }}</div>
                    @endforeach
                    @endif
                </div>
            </div>
               

            <div class="form-group row {{ $errors->has('vendorName') ? ' has-danger' : '' }}">
                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Vendor Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-danger" placeholder="vendor name" name="vendorName" value="{{ $vendors->vendorName }}" required>
                    @if ($errors->has('vendorName'))
                    @foreach($errors->get('vendorName') as $error)
                    <div class="form-control-feedback">{{ $error }}</div>
                    @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group row {{ $errors->has('contactPerson') ? ' has-danger' : '' }}">
                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Contact Person</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-danger" placeholder="contact person" name="contactPerson" value="{{ $vendors->contactPerson }}">
                    @if ($errors->has('contactPerson'))
                    @foreach($errors->get('contactPerson') as $error)
                    <div class="form-control-feedback">{{ $error }}</div>
                    @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group row {{ $errors->has('vendorAddress') ? ' has-danger' : '' }}">
                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Address </label>
                <div class="col-sm-6">
                    <textarea class="form-control form-control-danger" name="vendorAddress" style="min-height: 100px;">{{ $vendors->vendorAddress }}</textarea>
                    @if ($errors->has('vendorAddress'))
                    @foreach($errors->get('vendorAddress') as $error)
                    <div class="form-control-feedback">{{ $error }}</div>
                    @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group row {{ $errors->has('vendorPhone') ? ' has-danger' : '' }}">
                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Phone No</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-danger" placeholder="phone no" name="vendorPhone" value="{{ $vendors->vendorPhone }}" required>
                    @if ($errors->has('vendorPhone'))
                    @foreach($errors->get('vendorPhone') as $error)
                    <div class="form-control-feedback">{{ $error }}</div>
                    @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group row {{ $errors->has('vendorEmail') ? ' has-danger' : '' }}">
                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Email Address</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control form-control-danger" placeholder="email address" name="vendorEmail" value="{{ $vendors->vendorEmail }}">
                    @if ($errors->has('vendorEmail'))
                    @foreach($errors->get('vendorEmail') as $error)
                    <div class="form-control-feedback">{{ $error }}</div>
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- <div class="form-group row {{ $errors->has('accountCode') ? ' has-danger' : '' }}">
                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Account Code</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-danger" placeholder="acount code no" name="accountCode" value="{{ $vendors->accountCode }}" required>
                    @if ($errors->has('accountCode'))
                    @foreach($errors->get('accountCode') as $error)
                    <div class="form-control-feedback">{{ $error }}</div>
                    @endforeach
                    @endif
                </div>
            </div> -->

            <div class="form-group row {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Order By</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control form-control-danger" placeholder="order by" name="orderBy" value= "{{ $vendors->orderBy }}" required>
                    @if ($errors->has('orderBy'))
                    @foreach($errors->get('orderBy') as $error)
                    <div class="form-control-feedback">{{ $error }}</div>
                    @endforeach
                    @endif
                </div>
            </div>
                
                <div class="form-group row {{ $errors->has('vendorStatus') ? ' has-danger' : '' }}">
                    <label class="col-sm-3 col-form-label">Publication status</label>
                    <div class="col-sm-3 row" style="margin-left: 2px;">
                        <div class="form-control">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="published" name="vendorStatus" class="custom-control-input" checked="" value="1" required>
                                <label class="custom-control-label" for="published">Published</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="unpublished" name="vendorStatus" class="custom-control-input" value="0">
                                <label class="custom-control-label" for="unpublished">Unpublished</label>
                            </div>
                        </div>                            
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

<script type="text/javascript">
    document.forms['newMenu'].elements['vendorStatus'].value = "{{$vendors->vendorStatus}}";
</script>

@endsection
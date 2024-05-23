@extends('admin.layouts.master')

@section('title')
    <title>Admin | {{ $title }}</title>
@endsection

@section('content')

<style type="text/css">
    .chosen-single{
        height: 33px !important;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{$title}}</h4> </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                           <a class="btn btn-outline-info"  href="{{ route('vendor.index') }}">Go Back</a>
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

                  <div id="addNewMenu" class="">
                     <form class="form-horizontal" action="{{ route('vendor.update') }}" method="POST" enctype="multipart/form-data" id="newMenu" name="newMenu">
                        {{ csrf_field() }}

                        @if( count($errors) > 0 )

                        <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>

                        @endif
                        <div class="modal-body">                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12 m-b-20 text-right">
                                        <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                            <span style="font-size: 16px;">
                                                <i class="fa fa-save"></i> Update Data
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" value="{{$vendors->id}}" name="vendorId">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="sl-no">Vendor Code</label>
                                    <div class="form-group {{ $errors->has('vendor_serial') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" name="vendor_serial" value="{{ $vendors->vendor_serial }}" readonly>
                                        @if ($errors->has('vendor_serial'))
                                            @foreach($errors->get('vendor_serial') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="vendor-name">Vendor Name</label>
                                    <div class="form-group {{ $errors->has('vendorName') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="vendor name" name="vendorName" value="{{ $vendors->vendorName }}" required>
                                        @if ($errors->has('vendorName'))
                                            @foreach($errors->get('vendorName') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="contact-person">Contact Person</label>
                                    <div class="form-group {{ $errors->has('contactPerson') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="contact person" name="contactPerson" value="{{ $vendors->contactPerson }}">
                                        @if ($errors->has('contactPerson'))
                                            @foreach($errors->get('contactPerson') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="phone-no">Phone No</label>
                                    <div class="form-group {{ $errors->has('vendorPhone') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="phone no" name="vendorPhone" value="{{ $vendors->vendorPhone }}" required>
                                        @if ($errors->has('vendorPhone'))
                                            @foreach($errors->get('vendorPhone') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email-address">Email Address</label>
                                    <div class="form-group {{ $errors->has('vendorEmail') ? ' has-danger' : '' }}">
                                        <input type="email" class="form-control form-control-danger" placeholder="email address" name="vendorEmail" value="{{ $vendors->vendorEmail }}">
                                        @if ($errors->has('vendorEmail'))
                                            @foreach($errors->get('vendorEmail') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                               <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="oreder-by">Order By</label>
                                            <div class="form-group {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                                                <input type="number" class="form-control form-control-danger" placeholder="order by" name="orderBy" value= "{{ $vendors->orderBy }}" required>
                                                @if ($errors->has('orderBy'))
                                                    @foreach($errors->get('orderBy') as $error)
                                                        <div class="form-control-feedback">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <label for="publication-status">Publication status</label>
                                            <div class="form-group {{ $errors->has('vendorStatus') ? ' has-danger' : '' }}" style="height: 40px; line-height: 40px;">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="published">
                                                        <input type="radio" id="published" name="vendorStatus" checked="" value="1" required> Published
                                                    </label>
                                                </div>

                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="unpublished">
                                                        <input type="radio" id="unpublished" name="vendorStatus" value="0"> Unpublished
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                           </div>

                           <div class="row">
                                <div class="col-md-12">
                                    <label for="address">Address </label>
                                    <div class="form-group {{ $errors->has('vendorAddress') ? ' has-danger' : '' }}">
                                        <textarea class="form-control form-control-danger" name="vendorAddress" rows="5">{{ $vendors->vendorAddress }}</textarea>
                                        @if ($errors->has('vendorAddress'))
                                            @foreach($errors->get('vendorAddress') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
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


        </div>                
    </form>
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
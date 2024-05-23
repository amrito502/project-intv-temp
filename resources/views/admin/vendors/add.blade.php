@extends('admin.layouts.master')

@section('title')
<title>Admin | {{ $title }}</title>
@endsection

@section('content')
<?php
    use App\Vendors;
    $vendors = Vendors::whereRaw('id = (select max(`id`) from vendors)')->first();
    /*echo $vendors;
    die();*/
    $prefix= "VC";
    $orderBy = @$vendors->orderBy+1;
    if(!$vendors){
        $vendorSerial = "1";
    }else{
        $vendorSerial = $vendors->vendor_serial;
        $vendorSerial = explode('VC', $vendorSerial)[1];
        $vendorSerial++;
    }
    $vCode = $prefix."00".$vendorSerial;
?>

<style type="text/css">
    .chosen-single {
        height: 33px !important;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{$title}}</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a class="btn btn-outline-info" href="{{ route('vendor.index') }}">Go Back</a>
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

                    <form class="form-horizontal" action="{{ route('vendor.save') }}" method="POST"
                        enctype="multipart/form-data" id="newMenu" name="newMenu">
                        {{ csrf_field() }}

                        @if( count($errors) > 0 )

                        <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}
                        </div>

                        @endif
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="sl-no">Vendor Code</label>
                                    <div class="form-group {{ $errors->has('vendor_serial') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" name="vendor_serial"
                                            value="{{ $vCode }}" readonly>
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
                                        <input type="text" class="form-control form-control-danger"
                                            placeholder="vendor name" name="vendorName" value="{{ old('vendorName') }}"
                                            required>
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
                                        <input type="text" class="form-control form-control-danger"
                                            placeholder="contact person" name="contactPerson"
                                            value="{{ old('contactPerson') }}">
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
                                        <input type="text" class="form-control form-control-danger"
                                            placeholder="phone no" name="vendorPhone" value="{{ old('vendorPhone') }}"
                                            required>
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
                                        <input type="email" class="form-control form-control-danger"
                                            placeholder="email address" name="vendorEmail"
                                            value="{{ old('vendorEmail') }}">
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
                                            <label for="order-by">Order By</label>
                                            <div class="form-group {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                                                <input type="number" class="form-control form-control-danger"
                                                    placeholder="order by" name="orderBy" value="{{ @$orderBy }}"
                                                    required>
                                                @if ($errors->has('orderBy'))
                                                @foreach($errors->get('orderBy') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <label for="publication-status">Publication status</label>
                                            <div class="form-group {{ $errors->has('vendorStatus') ? ' has-danger' : '' }}"
                                                style="height: 40px; line-height: 40px;">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="published">
                                                        <input type="radio" id="published" name="vendorStatus"
                                                            checked="" value="1" required> Published
                                                    </label>
                                                </div>

                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="unpublished">
                                                        <input type="radio" id="unpublished" name="vendorStatus"
                                                            value="0"> Unpublished
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="address">Address</label>
                                    <div class="form-group {{ $errors->has('vendorAddress') ? ' has-danger' : '' }}">
                                        <textarea class="form-control form-control-danger" name="vendorAddress"
                                            rows="5">{{ old('vendorAddress') }}</textarea>
                                        @if ($errors->has('vendorAddress'))
                                        @foreach($errors->get('vendorAddress') as $error)
                                        <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12 m-b-20 text-right">
                                        <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                            <span style="font-size: 16px;">
                                                <i class="fa fa-save"></i> Save Data
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>










                            <!-- <div class="form-group row {{ $errors->has('accountCode') ? ' has-danger' : '' }}">
                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Account Code</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-danger" placeholder="acount code no" name="accountCode" value="{{ old('accountCode') }}" required>
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

<script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>


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

            var table = $('#MenusTable').DataTable( {
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

@endsection

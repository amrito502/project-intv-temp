@extends('admin.layouts.master')

@section('content')
<?php
    use App\Vendors;
    $vendors = Vendors::whereRaw('id = (select max(`id`) from vendors)')->first();
    /*echo $vendors;
    die();*/
    $orderBy = @$vendors->orderBy+1;
    if(!$vendors){
        $vendorSerial = 1000000+1;
    }else{
        $vendorSerial = 1000000+$vendors->id+1;
    }
?>

<style type="text/css">
    .chosen-single{
        height: 33px !important;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
    <span class="shortlink">
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
                <h4 class="card-title">Add Vendor</h4>

                  <div id="addNewMenu" class="">
    <div class="">
        <div class="">

            <form class="form-horizontal" action="{{ route('vendor.save') }}" method="POST" enctype="multipart/form-data" id="newMenu" name="newMenu">
            {{ csrf_field() }}

            @if( count($errors) > 0 )

            <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>

        @endif
            <div class="modal-body">

            <div class="col-md-9 m-b-20 text-right">
                 <button type="submit" class="btn btn-info waves-effect">Save</button>
            </div>
            <br>

            <div class="form-group row {{ $errors->has('vendor_serial') ? ' has-danger' : '' }}">
                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">SL No</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-danger" name="vendor_serial" value="{{ old('vendor_serial') }}">
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
                    <input type="text" class="form-control form-control-danger" placeholder="vendor name" name="vendorName" value="{{ old('vendorName') }}" required>
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
                    <input type="text" class="form-control form-control-danger" placeholder="contact person" name="contactPerson" value="{{ old('contactPerson') }}">
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
                    <textarea class="form-control form-control-danger" name="vendorAddress" style="min-height: 100px;">{{ old('vendorAddress') }}</textarea>
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
                    <input type="text" class="form-control form-control-danger" placeholder="phone no" name="vendorPhone" value="{{ old('vendorPhone') }}" required>
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
                    <input type="email" class="form-control form-control-danger" placeholder="email address" name="vendorEmail" value="{{ old('vendorEmail') }}">
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
                    <input type="text" class="form-control form-control-danger" placeholder="acount code no" name="accountCode" value="{{ old('accountCode') }}" required>
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
                    <input type="number" class="form-control form-control-danger" placeholder="order by" name="orderBy" value="{{ @$orderBy }}" required>
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

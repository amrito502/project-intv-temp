@extends('admin.layouts.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<?php
    $payment_date = Date('d-m-Y',strtotime(@$supplierPayment->payment_date));
?>
<?php
    $paymentTypes = array('Cash' => 'Cash', 'Check' => 'Check', 'Others' => 'Others');
?>
<div class="row">
    <div class="col-md-12">
        <div class="card" style="margin-bottom: 200px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{$title}}</h4> </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                         <a style="font-size: 16px;" class="btn btn-outline-info btn-lg"  href="{{ route($goBackLink) }}">
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

                  <div id="addNewMenu" class="">
                    <div class="row">
                        <div class="col-md-12">

                            <form class="form-horizontal" action="{{ route('supplierPayment.update') }}" method="POST" enctype="multipart/form-data" id="newMenu" name="form">
                            {{ csrf_field() }}

                            @if( count($errors) > 0 )

                            <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>

                        @endif
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="supplierPaymentId" value="{{$supplierPayment->id}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="supplier">Supplier</label>
                                                        <div class="form-group {{ $errors->has('supplier_id') ? ' has-danger' : '' }}">
                                                            @foreach ($vendors as $vendor)
                                                                @if ($vendor->id == $supplierPayment->supplier_id)
                                                                    <input type="hidden" name="supplier_id" value="{{ $vendor->id }}">
                                                                    <input class="form-control form-control-danger supplier" type="text" name="suplier_name" value="{{ $vendor->vendorName }}" readonly required>
                                                                @endif
                                                            @endforeach

                                                            @if ($errors->has('supplier_id'))
                                                                @foreach($errors->get('supplier_id') as $error)
                                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="payment-no">Payment No</label>
                                                        <div class="form-group {{ $errors->has('payment_no') ? ' has-danger' : '' }}">
                                                            <input type="text" class="form-control form-control-danger" name="payment_no" value="{{$supplierPayment->payment_no}}" required readonly>
                                                            @if ($errors->has('payment_no'))
                                                                @foreach($errors->get('payment_no') as $error)
                                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="payment-date">Payment Date</label>
                                                        <div class="form-group {{ $errors->has('payment_date') ? ' has-danger' : '' }}">
                                                            <input type="text" class="form-control form-control-danger datepicker" name="payment_date" value="{{$payment_date}}" required readonly>
                                                            @if ($errors->has('payment_date'))
                                                                @foreach($errors->get('payment_date') as $error)
                                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="current-due">Current Due</label>
                                                        <div class="form-group {{ $errors->has('current_due') ? ' has-danger' : '' }}">
                                                            <input type="text" class="form-control form-control-danger current_due" name="current_due" value="{{$supplierPayment->current_due}}" required readonly>
                                                            @if ($errors->has('current_due'))
                                                                @foreach($errors->get('current_due') as $error)
                                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="money-receipt">Money Receipt</label>
                                                        <div class="form-group {{ $errors->has('money_receipt') ? ' has-danger' : '' }}">
                                                            <input type="number" class="form-control form-control-danger" name="money_receipt" value="{{$supplierPayment->money_receipt}}">
                                                            @if ($errors->has('money_receipt'))
                                                                @foreach($errors->get('money_receipt') as $error)
                                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="payment-method">Payment Method</label>
                                                        <div class="form-group {{ $errors->has('payment_type') ? ' has-danger' : '' }}">
                                                            <select class="form-control form-control-danger chosen-select payment_type" name="payment_type" required="">
                                                                <option value=" ">Select Payment Type</option>
                                                                 <?php
                                                                    foreach ($paymentTypes as $key=>$value) {
                                                                        if ($supplierPayment->payment_type == $key) {
                                                                            $selected = 'selected';
                                                                        }else{
                                                                            $selected = '';
                                                                        }
                                                                ?>
                                                                <option {{@$selected}} value="{{$key}}">{{$value}}</option>
                                                                <?php } ?>
                                                            </select>
                                                            @if ($errors->has('payment_type'))
                                                                @foreach($errors->get('payment_type') as $error)
                                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="payment-now">Payment Now</label>
                                                        <div class="form-group {{ $errors->has('payment_now') ? ' has-danger' : '' }}">
                                                            <input type="text" class="form-control form-control-danger payment_now" name="payment_now" value="{{$supplierPayment->payment_now}}" oninput="Balance()" required>
                                                            @if ($errors->has('payment_now'))
                                                                @foreach($errors->get('payment_now') as $error)
                                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="balance">Balance</label>
                                                        <div class="form-group {{ $errors->has('balance') ? ' has-danger' : '' }}">
                                                            <input type="text" class="form-control form-control-danger balance" name="balance" value="{{$supplierPayment->balance}}"required readonly>
                                                            @if ($errors->has('balance'))
                                                                @foreach($errors->get('balance') as $error)
                                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="">Rmarks</label>
                                                <div class="form-group {{ $errors->has('remarks') ? ' has-danger' : '' }}">
                                                    <textarea class="form-control" name="remarks" rows="4">{{$supplierPayment->remarks}}</textarea>
                                                    @if ($errors->has('remarks'))
                                                        @foreach($errors->get('remarks') as $error)
                                                            <div class="form-control-feedback">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 m-b-20 text-right">
                                                <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                                    <span style="font-size: 16px;">
                                                        <i class="fa fa-edit"></i> Update Data
                                                    </span>
                                                </button>
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



<script type="text/javascript">
    function Balance(){
        var current_due = $(".current_due").val();
        var payment_now;

        if ($(".payment_now").val() == "")
        {
            payment_now = 0;
        }
        else
        {
            payment_now = $('.payment_now').val();
        }

        var balance = parseFloat(current_due) - parseFloat(payment_now);
        if (balance == current_due)
        {
            $(".balance").val("0");
        }
        else
        {
            $(".balance").val(balance.toFixed(2));
        }
    }

     document.forms['form'].elements['payment_type'].value = "{{$supplierPayment->payment_type}}";
</script>

@endsection

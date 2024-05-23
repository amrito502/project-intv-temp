@extends('admin.layouts.master')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <span class="shortlink">
                 <a class="btn btn-info" type="submit" href="{{ route('customer.itemRequest') }}">Go Back</a>
            </span>
            <div class="card-body">
                <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')
                  
                ?>
                <h4 class="card-title">{{$title}}</h4>

                  <div id="addNewProduct" class="">
                    <div class="">        
                        <div class="">
                            
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="customerForm" name="customerForm">
                            {{ csrf_field() }}

                            <div class="modal-body">
                                <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Customer Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-danger"  name="name" value="{{ $customerItemRequest->name }}" readonly>
                                        @if ($errors->has('name'))
                                        @foreach($errors->get('name') as $error)
                                        <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                  <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Email Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-danger"  name="name" value="{{ $customerItemRequest->email }}" readonly>
                                        @if ($errors->has('name'))
                                        @foreach($errors->get('name') as $error)
                                        <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                  <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Phone No</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-danger"  name="name" value="{{ $customerItemRequest->mobile }}" readonly>
                                        @if ($errors->has('name'))
                                        @foreach($errors->get('name') as $error)
                                        <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                  <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-danger" name="name" value="{{ $customerItemRequest->address }}" readonly>
                                        @if ($errors->has('name'))
                                        @foreach($errors->get('name') as $error)
                                        <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Item Imge</label>
                                    <div class="col-sm-9">
                                        <a data-fancybox="gallery" href="{{ asset(@$customerItemRequest->itemList) }}">
                                            <img src="{{asset($customerItemRequest->itemList)}}" style="height: 50px">
                                        </a>
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

<style type="text/css">
    select{
        cursor: pointer;
    }
    
</style>

     <script type="text/javascript">
        document.forms['customerForm'].elements['clientGroup'].value = "{{$customerItemRequest->clientGroup}}";

        
    </script>

@endsection
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
            <div class="card-header row">
                <div class="col-md-6">
                    <h4 class="card-title">Add New Offer</h4>
                </div>
                 <div class="col-md-6 m-b-20 text-right">
                    <a class="btn btn-info"  href="{{ route('policies.index') }}">Go Back</a> 
                    <button type="submit" class="btn btn-info waves-effect">Save</button> 
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
                <form action="{{ route('offer.save') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
    
                    @if( count($errors) > 0 )
                        <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <label for="promo_code">Promo Code</label>
                                    <input type="text" class="form-control" placeholder="Promo Code" name="promo_code" value="{{ old('promo_code') }}" required>
                                    @if ($errors->has('promo_code'))
                                    @foreach($errors->get('promo_code') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('start') ? ' has-danger' : '' }}">
                                    <label for="start">Start Date</label>
                                    <input type="text" class="form-control datepicker" name="start" value="{{ date('d-m-Y') }}" required>
                                    @if ($errors->has('start'))
                                    @foreach($errors->get('start') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('expire') ? ' has-danger' : '' }}">
                                    <label for="expire">Expire Date</label>
                                    <input type="text" class="form-control datepicker" name="expire" value="{{ date('d-m-Y') }}" required>
                                    @if ($errors->has('expire'))
                                    @foreach($errors->get('expire') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('type') ? ' has-danger' : '' }}">
                                    <label for="type">Discount Type</label>
                                    <select class="form-control" name="type">
                                        <option value="fix">Fix</option>
                                        <option value="percent">Percent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('minimum_amount') ? ' has-danger' : '' }}">
                                    <label for="minimum_amount">Minimum Purchase</label>
                                    <input type="text" class="form-control" name="minimum_amount" value="0" required>
                                    @if ($errors->has('minimum_amount'))
                                    @foreach($errors->get('minimum_amount') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('discount') ? ' has-danger' : '' }}">
                                    <label for="minimum_amount">Discount Amount/Percent</label>
                                    <input type="text" class="form-control" name="discount" value="0" required>
                                    @if ($errors->has('discount'))
                                    @foreach($errors->get('discount') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-info">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection



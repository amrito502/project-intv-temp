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
                    <h4 class="card-title">Edit Offer</h4>
                </div>
                 <div class="col-md-6 m-b-20 text-right">
                    <a class="btn btn-info"  href="{{ route('policies.index') }}">Go Back</a> 
                    <button type="submit" class="btn btn-info waves-effect">Update</button> 
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
                <form action="{{ route('offer.update') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
    
                    @if( count($errors) > 0 )
                        <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    <div class="card-body">
                        <input type="hidden" name="id" value="{{$offer->id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <label for="promo_code">Promo Code</label>
                                    <input type="text" class="form-control" placeholder="Promo Code" name="promo_code" value="{{ $offer->promo_code }}" required>
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
                                    <input type="text" class="form-control datepicker" name="start" value="{{ date('d-m-Y', strtotime($offer->start)) }}" required>
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
                                    <input type="text" class="form-control datepicker" name="expire" value="{{ date('d-m-Y', strtotime($offer->expire)) }}" required>
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
                                        <option value="fix" @if($offer->type == 'fix') selected @endif</option>Fix</option>
                                        <option value="percent" @if($offer->type == 'percent') selected @endif>Percent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('minimum_amount') ? ' has-danger' : '' }}">
                                    <label for="minimum_amount">Minimum Purchase</label>
                                    <input type="text" class="form-control" name="minimum_amount" value="{{ $offer->minimum_amount }}" required>
                                    @if ($errors->has('minimum_amount'))
                                    @foreach($errors->get('minimum_amount') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('discount') ? ' has-danger' : '' }}">
                                    <label for="discount">Discount Amount/Percent</label>
                                    <input type="text" class="form-control" name="discount" value="{{ $offer->discount }}" required>
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
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection



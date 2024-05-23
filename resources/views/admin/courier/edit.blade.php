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
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"
                                href="{{ route($goBackLink) }}">
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
                    <form class="form-horizontal" action="{{ route('courier.update') }}" method="POST"
                        enctype="multipart/form-data" id="editCategory" name="editCategory">
                        {{ csrf_field() }}

                        @if( count($errors) > 0 )

                        <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}
                        </div>

                        @endif
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit"
                                        class="btn btn-outline-info btn-lg waves-effect">Update</button>
                                </div>
                            </div>

                            <input type="hidden" name="courier_id" value="{{$courier->id}}">

                            <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Courier
                                    Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-danger"
                                        placeholder="Courier Name" name="name" value="{{ $courier->name }}" required>
                                    @if ($errors->has('name'))
                                    @foreach($errors->get('name') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('contact_person') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Contact Person
                                    Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-danger"
                                        placeholder="Contact Person Name" name="contact_person"
                                        value="{{ $courier->contact_person }}" required>
                                    @if ($errors->has('contact_person'))
                                    @foreach($errors->get('contact_person') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('contact_number') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Contact Number</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-danger"
                                        placeholder="Contact Number" name="contact_number"
                                        value="{{ $courier->contact_number }}" required>
                                    @if ($errors->has('contact_number'))
                                    @foreach($errors->get('contact_number') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-danger" placeholder="Email"
                                        name="email" value="{{ $courier->email }}" required>
                                    @if ($errors->has('email'))
                                    @foreach($errors->get('email') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('address') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-danger" placeholder="Address"
                                        name="address" value="{{ $courier->address }}" required>
                                    @if ($errors->has('address'))
                                    @foreach($errors->get('address') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit"
                                        class="btn btn-outline-info btn-lg waves-effect">Update</button>
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

@endsection
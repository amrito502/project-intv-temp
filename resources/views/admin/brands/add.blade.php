@extends('admin.layouts.master')

@section('title')
    <title>Admin | {{ $title }}</title>
@endsection

@section('content')

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
                            <a class="btn btn-outline-info" href="{{ route('brand.index') }}">Go Back</a>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $message = Session::get('msg');
                    if (isset($message)) {
                        echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" . $message . "</strong></div>";
                    }

                    Session::forget('msg')
                    ?>

                    <div id="addNewMenu" class="">

                        <form class="form-horizontal" action="{{ route('brand.save') }}" method="POST"
                              enctype="multipart/form-data" id="newMenu" name="newMenu">
                            {{ csrf_field() }}

                            @if( count($errors) > 0 )

                                <div style="display:inline-block;width: auto;"
                                     class="alert alert-danger">{{ $errors->first() }}
                                </div>

                            @endif
                            <div class="modal-body">

                                <div class="row">

                                    <div class="col-md-6">
                                        <label for="brand_name">Brand Name</label>
                                        <div class="form-group {{ $errors->has('brand_name') ? ' has-danger' : '' }}">
                                            <input type="text" class="form-control form-control-danger"
                                                   placeholder="Brand name" name="brand_name"
                                                   value="{{ old('brand_name') }}"
                                                   required>
                                            @if ($errors->has('brand_name'))
                                                @foreach($errors->get('brand_name') as $error)
                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="brand_img">Brand Image</label>
                                        <div class="form-group {{ $errors->has('vendorName') ? ' has-danger' : '' }}">
                                            <input type="file" class="form-control form-control-danger"
                                                   placeholder="Brand Image" name="brand_img"
                                                   value="{{ old('brand_img') }}"
                                                   required>

                                                   <span class="text-danger">* Image Size 90X45px *</span>
                                            @if ($errors->has('brand_img'))
                                                @foreach($errors->get('brand_img') as $error)
                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="description">Description</label>
                                        <div class="form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <textarea class="form-control form-control-danger" name="description"
                                                  rows="5">{{ old('description') }}</textarea>
                                            @if ($errors->has('description'))
                                                @foreach($errors->get('description') as $error)
                                                    <div class="form-control-feedback">{{ $error }}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-5">
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
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 200, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });

            var updateThis;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#MenusTable').DataTable({
                "order": [[0, "asc"]]
            });


        });


        function summernote() {
            $('.summernote').summernote({
                height: 200, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });
        }
    </script>

@endsection

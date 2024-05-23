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
                    {{-- <div class="col-md-6">
                        <span class="shortlink">
                         <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"  href="{{ route($goBackLink) }}">
                    <i class="fa fa-arrow-circle-left"></i> Go Back
                    </a>
                    </span>
                </div> --}}
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
                <div class="">
                    <div class="">

                        <form class="form-horizontal" action="{{ route('courier.save') }}" method="POST"
                            enctype="multipart/form-data" id="newProduct" name="newProduct">
                            {{ csrf_field() }}

                            @if( count($errors) > 0 )

                            <div style="display:inline-block;width: auto;" class="alert alert-danger">
                                {{ $errors->first() }}</div>

                            @endif
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-12 m-b-20 text-right">
                                        <button type="submit" class="btn btn-outline-info btn-lg">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Courier
                                        Name</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-danger"
                                            placeholder="Courier Name" name="name" value="{{ old('name') }}" required>
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
                                            value="{{ old('contact_person') }}" required>
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
                                            value="{{ old('contact_number') }}" required>
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
                                        <input type="text" class="form-control form-control-danger"
                                            placeholder="Email" name="email"
                                            value="{{ old('email') }}" required>
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
                                        <input type="text" class="form-control form-control-danger"
                                            placeholder="Address" name="address"
                                            value="{{ old('address') }}" required>
                                        @if ($errors->has('address'))
                                        @foreach($errors->get('address') as $error)
                                        <div class="form-control-feedback">{{ $error }}</div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 m-b-20 text-right">
                                        <button type="submit" class="btn btn-outline-info btn-lg">
                                            <i class="fa fa-save"></i> Save
                                        </button>
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

            var table = $('#productsTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );

            //ajax
            //ajax category  wise subcategory
            $( "form[name='newProduct'] select[name='category_id']" ).on( "change", function( event ) {
            $( "form[name='newProduct'] select[name='sub_category_id']" ).html('');
            $( "form[name='newProduct'] select[name='sub_category_id']" ).append(new Option("--- Select Sub Category Name---", ""));
                category_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('categories.index') }}" + "/" + category_id + "/subCategories",
                    data: "category_id=" + category_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        subCategories = response.subCategories;
                        subCategories.forEach(function(element) {
                            $( "form[name='newProduct'] select[name='sub_category_id']" ).append(new Option(element.name, element.id));
                        });
                    },
                    error: function(response) {
                        error = "Select Category First.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>",
                            type: "error",
                            text: error,
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

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

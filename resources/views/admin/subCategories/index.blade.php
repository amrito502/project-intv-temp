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
            <div class="card-body">
                <h4 class="card-title">Manage sub categories</h4>
                <a href="{{ route('subcategoryadd.page') }}" type="submit" class="btn btn-info" style="float: right;">Add new</a>
                <div class="table-responsive" style="margin-top: 5rem;">
                    <table id="subCategoriesTable" class="table table-bordered table-striped"  name="subCategoriesTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Publication status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        	@foreach($subCategories as $subCategory)
                        	<tr>
                                <td>{{ $subCategory->subcategoryName }}</td>
                                <td>{{ $subCategory->category->categoryName }}</td>
                                <td>
                                    <span class="switchery-demo m-b-30" onclick="statusChange({{ $subCategory->id }})">
                                    <input type="checkbox" {{ $subCategory->subcategoryStatus ? 'checked':'' }} class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;" >
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Show" data-id="{{ $subCategory->id }}"> <i class="fa fa-eye text-success m-r-10"></i> </a>
                                    <a href="{{ route('subcategory.edit',$subCategory->id) }}" data-toggle="tooltip" data-original-title="Edit" data-id="{{ $subCategory->id }}"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="{{$subCategory->id}}"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
                                </td>
                            </tr>
                        	@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End PAge Content -->

<!-- sample modal content for show sub category-->
<div id="showSubCategory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show Sub Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container" id="showContent">
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



@endsection

@section('custom-js')

    <!-- This is data table -->
    <script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var updateThis ;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#subCategoriesTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );

            table.on('order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            //ajax


            //ajax show code
            $('#subCategoriesTable tbody').on( 'click', 'i.fa-eye', function () {
                updateThis = this;
                sub_category_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('subCategories.index') }}" + "/" + sub_category_id + "/edit",
                    data: "sub_category_id=" + sub_category_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        subCategory = response.subCategory;
                        category = response.category;
                        showFunction(subCategory, category);
                    },
                    error: function(response) {
                        error = "Something wrong.";
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

            //seperate the show function to understand
            function showFunction(subCategory, category){
                if(subCategory.subcategoryStatus == 1)
                    subcategoryStatus =    `<div class="form-group row">
                                    <span class="badge badge-pill badge-success">Active</span>
                                </div>`;
                else
                    subcategoryStatus =    `<div class="form-group row">
                                    <span class="badge badge-pill badge-danger">In-active</span>
                                </div>`
                var content =   `<div class="form-group row">
                                    <label class="col-sm-4 col-form-label form-control"><b>Sub category name</b></label>
                                    <div class="col-sm-8 form-control">`+subCategory.subcategoryName+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label form-control"><b>Category</b></label>
                                    <div class="col-sm-8 form-control">`+category.categoryName+`</div>
                                </div>`+subcategoryStatus;

                $('#showContent').html(content);
                $("#showSubCategory").modal();
            }


            //ajax delete code
            $('#subCategoriesTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                sub_category_id = $(this).parent().data('id');
                var subCategory = this;
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('subCategories.index') }}" + "/" + sub_category_id,
                            // data: "category_id=" + category_id,
                            dataType: "JSON",
                            data: {
                                id:sub_category_id
                            },
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Sub category deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(subCategory).parents('tr'))
                                    .remove()
                                    .draw();
                            },
                            error: function(response) {
                                error = "Failed.";
                                swal({
                                    title: "<small class='text-danger'>Error!</small>",
                                    type: "error",
                                    text: error,
                                    timer: 1000,
                                    html: true,
                                });
                            }
                        });
                    } else {
                        swal({
                            title: "Cancelled",
                            type: "error",
                            text: "Your sub category is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });

        //ajax status change code
        function statusChange(sub_category_id) {
            $.ajax({
                    type: "GET",
                    url: "{{ route('subCategories.changeStatus', 0) }}",
                    data: "sub_category_id=" + sub_category_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        swal({
                            title: "<small class='text-success'>Success!</small>",
                            type: "success",
                            text: "Status successfully updated!",
                            timer: 1000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        error = "Failed.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>",
                            type: "error",
                            text: error,
                            timer: 2000,
                            html: true,
                        });
                    }
                });
            }
    </script>
@endsection

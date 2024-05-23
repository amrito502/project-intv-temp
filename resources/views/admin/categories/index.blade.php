@extends('admin.layouts.master')

@section('content')

    @php
        use App\Category;
    @endphp


    <div class="row">
        <div class="col-md-12">
            <div class="card" style="margin-bottom: 200px;">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
                        <div class="col-md-6">
                            <span class="shortlink">
                                <a style="font-size: 16px;" class="btn btn-outline-info btn-lg" href="{{ route('categoryadd.page')}}">
                                    <i class="fa fa-plus-circle"></i> Add new
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        @php
                            $message = Session::get('msg');
                            if (isset($message))
                            {
                                echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                            }
                            Session::forget('msg');
                            $sl = 0;
                        @endphp

                        <table id="categoriesTable" class="table table-bordered table-striped"  name="categoriesTable">
                            <thead>
                                <tr>
                                    <th width="20px">SL</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Parent</th>
                                    <th width="20px">Status</th>
                                    <th width="20px">Action</th>
                                </tr>
                            </thead>
                            <tbody id="">
                            	@foreach($categories as $category)
                                    @php
                                        $sl++;
                                    @endphp
                                	<tr>
                                        <td>{{ $sl }}</td>
                                        <td>{{ $category->categoryName }}</td>
                                        <td>
                                            @if ($category->categoryImage == "")
                                                Image Not Found
                                            @else
                                                <img src="{{ asset('/').$category->categoryImage }}" style="height: 75px" alt="No Image">
                                            @endif
                                        </td>

                                        <td>
                                            @if (@$category->parentName == "")
                                                Root
                                            @else
                                                {{ @$category->parentName }}
                                            @endif
                                        </td>

                                        <td>
                                            <!-- <span class="switchery-demo m-b-30" onclick="statusChange({{ $category->id }})">
                                            <input type="checkbox" {{ $category->categoryStatus ? 'checked':'' }} class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;" >
                                            </span> -->

                                            <?php echo \App\Link::status($category->id,$category->categoryStatus)?>
                                        </td>
                                        <td class="text-nowrap">
                                        <?php echo \App\Link::action($category->id)?>
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


<!-- sample modal content for show category-->
<div id="showCategory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show Category</h4>
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

            var table = $('#categoriesTable').DataTable( {
                "order": [[ 2, "asc" ]]
            } );

            //ajax


            //ajax show code
            $('#categoriesTable tbody').on( 'click', 'i.fa-eye', function () {
                updateThis = this;
                category_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('categories.index') }}" + "/" + category_id + "/edit",
                    data: "category_id=" + category_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        category = response.category;
                        showFunction(category);
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
            function showFunction(category){
                if(category.categoryStatus == 1)
                    categoryStatus =    `<div class="form-group row">
                                    <span class="badge badge-pill badge-success">Active</span>
                                </div>`;
                else
                    categoryStatus =    `<div class="form-group row">
                                    <span class="badge badge-pill badge-danger">In-active</span>
                                </div>`
                var content =   `<div class="form-group row">
                                    <label class="col-sm-4 col-form-label form-control"><b>Category name</b></label>
                                    <div class="col-sm-8 form-control">`+category.categoryName+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label form-control"><b>Category position</b></label>
                                    <div class="col-sm-8 form-control">`+category.position+`</div>
                                </div>`+categoryStatus;

                $('#showContent').html(content);
                $("#showCategory").modal();
            }

            //ajax delete code
            $('#categoriesTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                category_id = $(this).parent().data('id');
                var category = this;
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
                            // url: "{!! url('categories' ) !!}" + "/" + category_id,
                            url: "{{ route('categories.index') }}" + "/" + category_id,
                            // data: "category_id=" + category_id,
                            dataType: "JSON",
                            data: {
                                id:category_id
                            },
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Category deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(category).parents('tr'))
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
                            text: "Your category is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });

        //ajax status change code
        function statusChange(category_id) {
            $.ajax({
                    type: "GET",
                    url: "{{ route('categories.changecategoryStatus', 0) }}",
                    data: "category_id=" + category_id,
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

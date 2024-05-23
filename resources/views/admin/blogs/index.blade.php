@extends('admin.layouts.master')

@section('custom-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <?php
    use App\blog;

    ?>

    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Blogs</h4>


                    <a href="{{ route('blogadd.page') }}" type="submit" class="btn btn-info" style="float: right;">Add
                        new</a>

                    <div class="table-responsive">
                        <?php
                        $message = Session::get('msg');
                        if (isset($message)) {
                            echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" . $message . "</strong></div>";
                        }

                        Session::forget('msg')

                        ?>
                        <table id="blogsTable" class="table table-bordered table-striped" name="blogsTable">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Publication status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            @foreach($blogs as $blog)
                                <tr>
                                    <td></td>
                                    <td>{{ Str::limit($blog->title, 30) }}</td>
                                    <td><img src="{{ asset('/').$blog->blogImage }}" style="height: 75px"
                                             alt="No Image"></td>
                                    <td>{{ Str::limit($blog->description, 30) }}</td>
                                    <td>
                                        <?php echo \App\Link::status($blog->id, $blog->status)?>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php echo \App\Link::action($blog->id)?>
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
    <!-- ============================================================== -->


    <!-- sample modal content for show blog-->
    <div id="showblog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
         style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Show blog</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
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
        $(document).ready(function () {
            var updateThis;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function () {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#blogsTable').DataTable({
                "order": [[0, "asc"]]
            });

            table.on('order.dt search.dt', function () {
                table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            //ajax


            //ajax delete code
            $('#blogsTable tbody').on('click', 'i.fa-trash', function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                blog_id = $(this).parent().data('id');
                var blog = this;
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
                }, function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "DELETE",
                            // url: "{!! url('blogs' ) !!}" + "/" + blog_id,
                            url: "{{ route('blogs.index') }}" + "/" + blog_id,
                            // data: "blog_id=" + blog_id,
                            dataType: "JSON",
                            data: {
                                id: blog_id
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "blog deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row($(blog).parents('tr'))
                                    .remove()
                                    .draw();
                            },
                            error: function (response) {
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
                            text: "Your blog is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });

        //ajax status change code
        function statusChange(blog_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('blogs.changeblogStatus', 0) }}",
                data: "blog_id=" + blog_id,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    swal({
                        title: "<small class='text-success'>Success!</small>",
                        type: "success",
                        text: "Status successfully updated!",
                        timer: 1000,
                        html: true,
                    });
                },
                error: function (response) {
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

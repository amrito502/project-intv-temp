@extends('admin.layouts.master')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')


<div class="row">
    <div class="col-md-12">
        <div class="card" style="margin-bottom: 200px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $data->title }}</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a style="font-size: 16px;" class="btn btn-outline-info btn-lg" href="{{ route($addNewLink)}}">
                                <i class="fa fa-plus-circle"></i> Add new
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Notice</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i =1;
                            @endphp
                            @foreach ($data->notices as $notice)
                            <tr id="{{$notice->id}}">
                                <td>{{ $i++ }}</td>
                                <td>{{ $notice->description }}</td>
                                <td>
                                    {!! \App\Link::status($notice->id, $notice->status) !!}
                                </td>
                                <td>
                                    {!! \App\Link::action($notice->id) !!}
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



@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        var updateThis;

        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });


        //ajax delete code
        $('#dataTable tbody').on('click', 'i.fa-trash', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var id = $(this).parent().data('id');
            swal({
                title: "Are you sure?"
                , text: "You will not be able to recover this imaginary file!"
                , type: "warning"
                , showCancelButton: true
                , confirmButtonColor: "#DD6B55"
                , confirmButtonText: "Yes, delete it!"
                , cancelButtonText: "No, cancel plx!"
                , closeOnConfirm: false
                , closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "DELETE"
                        , url: "notice/" + id
                        , dataType: "JSON"
                        , cache: false
                        , contentType: false
                        , processData: false
                        , success: function(response) {
                            swal({
                                title: "<small class='text-success'>Success!</small>"
                                , type: "success"
                                , text: "Deleted Successfully!"
                                , timer: 1000
                                , html: true
                            , });
                            $('#'+id).remove();
                        }
                        , error: function(response) {
                            error = "Failed.";
                            swal({
                                title: "<small class='text-danger'>Error!</small>"
                                , type: "error"
                                , text: error
                                , timer: 1000
                                , html: true
                            , });
                        }
                    });
                } else {
                    swal({
                        title: "Cancelled"
                        , type: "error"
                        , text: "Item is safe :)"
                        , timer: 1000
                        , html: true
                    , });
                }
            });
        });

    });

    //ajax status change code
    function statusChange(id) {
        $.ajax({
            type: "GET"
            , url: "{{ route('notice.status', 0) }}"
            , data: "id=" + id
            , cache: false
            , contentType: false
            , processData: false
            , success: function(response) {
                swal({
                    title: "<small class='text-success'>Success!</small>"
                    , type: "success"
                    , text: "Status successfully updated!"
                    , timer: 1000
                    , html: true
                , });
            }
            , error: function(response) {
                error = "Failed.";
                swal({
                    title: "<small class='text-danger'>Error!</small>"
                    , type: "error"
                    , text: error
                    , timer: 2000
                    , html: true
                , });
            }
        });
    }

</script>
@endsection

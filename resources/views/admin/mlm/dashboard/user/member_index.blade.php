@extends('admin.layouts.master')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="col-md-12">
    <div class="card" style="margin-bottom: 200px;">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">{{ $title }}</h4>
                </div>
                <div class="col-md-6">
                    <span class="shortlink">
                        <a style="font-size: 16px;" class="btn btn-outline-info btn-lg" href="{{ route('member.registration')}}">
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
                            <th>Reference</th>
                            <th>Placement</th>
                            <th>Username</th>
                            <th>Rank</th>
                            <th>Mobile</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($data->members as $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ @$member->refMember->name }} ({{ @$member->refMember->username }})</td>
                                <td>{{ @$member->placeMember->name }} ({{ @$member->placeMember->username }})</td>
                                <td>{{ $member->name }} ({{ $member->username }})</td>
                                <td>{{ $member->currentRank() }}</td>
                                <td>{{ $member->mobile }}</td>
                                <td>
                                    <?php echo \App\Link::action($member->id)?>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection

@section('custom-js')




<script>
    // member table start

    var updateThis;

    // Switchery
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });



    function toggleStatus(id) {
        axios.get(route('user.status', id))
            .then(function(response) {})
            .catch(function(error) {})
    }


    $(document).ready(function () {
        $('#tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                user_id = $(this).parent().data('id');
                var user = this;
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
                            // url: "{!! url('categories' ) !!}" + "/" + user_id,
                            url: "{{ route('users.index') }}" + "/" + user_id,
                            // data: "user_id=" + user_id,
                            dataType: "JSON",
                            data: {
                                id:user_id
                            },
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "user deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(user).parents('tr'))
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

</script>

@endsection

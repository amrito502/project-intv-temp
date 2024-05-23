@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="">
            <div class="row">
                <div class="col-md-2">
                    <a href="{{ route($data->backroute) }}" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </a>
                </div>
                <div class="col-md-8">
                    <h2 class="h2 text-center text-uppercase">Requisition Communication</h2>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-8 card offset-md-2 my-1">
                    <div class="p-2">

                        <div class="row">

                            <div class="col-md-12">
                                <div>

                                    <p>
                                        Project - {{ $data->cashrequisition->project->project_name }}, Unit - {{ $data->cashrequisition?->unit?->name }}, Tower - {{ $data->cashrequisition?->tower?->name }}
                                    </p>

                                    <p>Serial No - {{ $data->cashrequisition->thisSerial() }}</p>

                                    <p>Date - {{ date('d-m-Y', strtotime($data->cashrequisition->date)) }}</p>

                                    <p>Remarks - {{ $data->cashrequisition->remarks }}</p>

                                </div>
                            </div>

                        </div>

                        <div class="row material_table">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <input type="hidden" value="{{ $data->cashrequisition->project->id }}"
                                        id="project_id" readonly>

                                    <input type="hidden" value="{{ $data->cashrequisition->unit->id }}" id="unit_id"
                                        readonly>



                                    <table class="table mobile-changes">
                                        <thead>
                                            <tr>
                                                <th>Material</th>
                                                <th>Estimated Amount</th>
                                                <th>Issued Amount</th>
                                                <th>Balance</th>
                                                <th>Requisition Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->cashrequisition->items as $item)
                                            <tr>
                                                <td>{{ $item->budgethead->name }}</td>
                                                <td>{{ $item->estimated_amount }}</td>
                                                <td>{{ $item->issued_amount }}</td>
                                                <td>{{ $item->balance_amount }}</td>
                                                <td>{{ $item->requisition_amount }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-md-8 card offset-md-2 my-1">
                    <div class="p-2">
                        <form
                            action="{{ route('material.requisitioncommunication.saveComment', $data->cashrequisition->id) }}"
                            method="post">
                            @csrf

                            <div class="row">

                                <div class="col-md-1">
                                    <img class="img-fluid mt-3" src="{{ Auth::user()->profileImage() }}" alt="">
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                        <input type="text" class="form-control" name="comment" placeholder="Comment">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-success" style="margin-top: 29px;">Comment</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                @foreach ($data->requisitioncommunications as $comment)

                <div class="col-md-8 card offset-md-2 my-1">
                    <div class="p-2">

                        <div class="row">

                            <div class="col-md-1">
                                <img class="img-fluid mt-3" src="{{ $comment->user->profileImage() }}" alt="">
                            </div>

                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="comment">{{ $comment->user->name }}</label>
                                    <input type="text" class="form-control" name="comment"
                                        id="comment_{{ $comment->id }}" placeholder="Comment"
                                        value="{{ $comment->comment }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2" style="padding-top:35px;">
                                @if ($comment->created_by == Auth::user()->id)

                                <button id="editbtn_{{ $comment->id }}" onclick="editCommentInit({{ $comment->id }})"
                                    class="text-primary mr-4">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>

                                <button id="updatebtn_{{ $comment->id }}" onclick="updateComment({{ $comment->id }})"
                                    class="d-none btn btn-primary mr-4">
                                    Update
                                </button>

                                <a href="{{ route('material.requisitioncommunication.deleteComment', $comment->id) }}"
                                    class="text-danger">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                @endif
                            </div>

                        </div>

                    </div>
                </div>

                @endforeach

            </div>

        </div>
    </div>
</div>


@endsection


@section('custom-script')


{{-- comment start --}}

<script>
    function editCommentInit(commentId) {

        const input = $('#comment_'+commentId);
        const editBtn = $('#editbtn_'+ commentId);
        const updateBtn = $('#updatebtn_' +commentId);

        editBtn.addClass('d-none');
        updateBtn.removeClass('d-none');

        input.removeAttr('readonly');

    }


    function updateComment(commentId) {


        const input = $('#comment_'+commentId);
        const editBtn = $('#editbtn_'+ commentId);
        const updateBtn = $('#updatebtn_' +commentId);

        const comment = input.val();

        editBtn.removeClass('d-none');
        updateBtn.addClass('d-none');

        input.attr('readonly','readonly');


        axios.get(route('material.requisitioncommunication.updateComment', commentId), {
            params: {
                comment:comment
            }
        })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
        })

    }

</script>

@endsection

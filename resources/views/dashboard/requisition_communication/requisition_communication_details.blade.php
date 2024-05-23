@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="">
            <div class="row">
                <div class="col-md-2">
                    <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
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
                                <div class="d-flex">
                                    <p>Project - {{ $data->cashrequisition->project->project_name }}, &nbsp;</p>
                                    <p>Unit - {{ $data->cashrequisition?->unit?->name }}, &nbsp;</p>
                                    <p>Tower - {{ $data->cashrequisition?->tower?->name }}, &nbsp;</p>
                                    <p>Serial No - {{ $data->cashrequisition->thisSerial() }}, &nbsp;</p>
                                    <p>Date - {{ date('d-m-Y', strtotime($data->cashrequisition->date)) }}, &nbsp;</p>
                                    <p>Remarks - {{ $data->cashrequisition->remarks }}, &nbsp;</p>
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


                                    @foreach ($data->cashrequisition->items as $item)

                                    <div class="d-flex">
                                        <p>
                                            <input type="hidden" class="itemList itemList_{{ $item->id + 999 }}"
                                                value="{{ $item?->vendor?->id }}">
                                            {{ $item?->vendor?->name }}, &nbsp;
                                        </p>

                                        <p>
                                            <input type="hidden" class="unitList unitList_{{ $item->id + 999 }}"
                                                value="{{ $item?->vendor?->id }}">
                                            {{ $item->budgethead->name }}, &nbsp;
                                        </p>

                                        <p class="estimated estimated_{{ $item->id + 999 }}"></p>
                                        <p class="issued issued_{{ $item->id + 999 }}"></p>
                                        <p class="amount amount_{{ $item->id + 999 }}">{{ $item->requisition_amount
                                            }}</p>
                                    </div>


                                    @endforeach

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-md-8 card offset-md-2 my-1">
                    <div class="p-2">
                        <form action="{{ route('requisitioncommunication.saveComment', $data->cashrequisition->id) }}"
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

                                <a href="{{ route('requisitioncommunication.deleteComment', $comment->id) }}"
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


{{-- projectwise unit start --}}

<script>
    $(document).ready(function () {

        $('#project_id').change(function (e) {
            e.preventDefault();

            const projectId = +$(this).val();

            if(projectId == ''){
                $('#unit_id').html('');
                return false;
            }

            // projectwise unit start
            axios.get(route('project.units', projectId))
            .then(function (response) {

                const data = response.data.project_units;

                let options = `<option value="">Select An Option</option>`;

                data.forEach(el => {

                    let option = `<option value="${el.unit.id}">${el.unit.name}</option>`;

                    options += option;

                });

                $('#unit_id').html(options);

            })
            .catch(function (error) {
            })
            // projectwise unit end



            // projectwise tower start
            axios.get(route('projectwise.tower', projectId))
            .then(function (response) {

                const data = response.data.project_towers;

                let options = `<option value="">Select An Option</option>`;

                data.forEach(el => {

                    let option = `<option value="${el.id}">${el.name}</option>`;

                    options += option;

                });

                $('#tower').html(options);

            })
            .catch(function (error) {
            })
            // projectwise tower end


        });

        $('#unit_id').change(function (e) {
            e.preventDefault();

            const unitId = +$(this).val();

            if(unitId == ''){
                $('#unit_id').html('');
                return false;
            }

            let projectId = $('#project_id').val();


            axios.get(route('projectUnitWiseBudgetHeadCashOnly', [projectId, unitId]))
            .then(function (response) {


                const items = response.data;


                let options = `<option value="">Select An Option</option>`;


                items.forEach(item => {

                    let option = `<option value="${item.id}">${item.name}</option>`;

                    options += option;

                });

                $('#unitList .input select').html('');
                $('#unitList .input select').html(options);

            })
            .catch(function (error) {
            })

        });

    });

    function budgetHeadWiseTotalEstimated(id){
        const projectId = +$('#project_id').val();
        const unitId = +$('#unit_id').val();
        const budget_head_id = $('.unitList_' + id).val();

        // get estimated amount start
            axios.get(route('budgetHeadWiseTotalEstimated', [projectId, unitId, budget_head_id]))
            .then(function (response) {

                let data = response.data + ", &nbsp;";

                $('.estimated_' + id).html(data);

                row_sum();

            })
            .catch(function (error) {
            })
        // get estimated amount end


    }

    function alreadyIssuedAmount(id){

        const projectId = +$('#project_id').val();
        const unitId = +$('#unit_id').val();
        const budget_head_id = $('.unitList_' + id).val();

        // get issued amount start
        axios.get(route('budgetHeadWiseTotalPaid', [projectId, unitId, budget_head_id]))
        .then(function (response) {

            let data = response.data + ", &nbsp;";

            $('.issued_' + id).html(data);

            row_sum();

        })
        .catch(function (error) {
        })
        // get issued amount end

    }

    function updateItemRow(e, id){

        const budget_head_id = $('.unitList_' + id).val();


        if(!budget_head_id){
            return false;
        }


        budgetHeadWiseTotalEstimated(id);
        alreadyIssuedAmount(id);

    }
</script>

{{-- projectwise unit end --}}


{{-- table start --}}

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


        axios.get(route('requisitioncommunication.updateComment', commentId), {
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

@foreach ($data->cashrequisition->items as $item)
<script>
    document.addEventListener("DOMContentLoaded", function(){
        updateItemRow(event, {{ $item->id + 999 }});
    });
</script>
@endforeach

@endsection

@extends('dashboard.layouts.app')

@section('custom-css')
    <style>
        .table th, .table td{
            padding: 0.75rem 0.30rem;
        }

        .table th{
            padding-right: 5px;
        }
    </style>
@endsection

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('cashrequisition.approve') }}" method="POST">
    @csrf

    <input type="hidden" name="cashRequisitionId" value="{{ $data->cashrequisition->id }}">

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-3">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-center my-3 d-md-none d-block text-uppercase">{{ $data->title }}</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">{{ $data->title }}</h3>
                    </div>
                    <div class="col-md-3 text-right">
                        <button class="btn btn-success">
                            <i class="fa fa-check-circle" aria-hidden="true"></i> Approve
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="">

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project_id">Project</label>
                            <input type="hidden" value="{{ $data->cashrequisition->project->id }}" id="project_id"
                                readonly>
                            <input type="text" class="form-control"
                                value="{{ $data->cashrequisition->project->project_name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit_id">Unit</label>
                            <input type="hidden" value="{{ $data->cashrequisition->unit->id }}" id="unit_id" readonly>
                            <input type="text" class="form-control" value="{{ $data->cashrequisition?->unit?->name }}"
                                readonly>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <input type="text" class="form-control" value="{{ $data->cashrequisition?->tower?->name }}"
                                readonly>

                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="serial_no">Serial No</label>
                            <input class="form-control" name="text" id="serial_no" type="text"
                                value="{{ $data->cashrequisition->thisSerial() }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input class="form-control datepicker" value="{{ $data->cashrequisition->date }}"
                                name="date" id="date" type="text" autocomplete="off" readonly>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <input class="form-control" name="remarks" id="remarks" type="text"
                                value="{{ $data->cashrequisition->remarks }}" readonly>
                        </div>
                    </div>

                </div>

                <div class="row material_table">
                    <div class="col-md-12" style="overflow-y: auto">
                        <div class="form-group">
                            <table class="table gridTable">
                                <thead>
                                    <tr>
                                        <th width="15%">Vendor</th>
                                        <th width="300px">Budget Head</th>
                                        <th class="text-center">Budget</th>
                                        <th class="text-center">Approved</th>
                                        <th class="text-center">Payment</th>
                                        <th class="text-center">Pending</th>
                                        <th class="text-center">Requisition</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Requisition Approve</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody">
                                    @foreach ($data->cashrequisition->items as $item)
                                    <tr id="itemRow_{{ $item->id + 999 }}">
                                        <td>
                                            <select name="vendor[]"
                                                onchange="updateItemRow(event, '{{ $item->id + 999 }}')"
                                                class="form-control chosen-select itemList itemList_{{ $item->id + 999 }}"
                                                disabled>
                                                <option value="">Select Vendor</option>
                                                @foreach ($data->vendors as $vendor)
                                                <option value="{{$vendor->id}}" @if ($vendor->id == $item->vendor_id)
                                                    selected @endif>{{$vendor->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="budget_head[]"
                                                onchange="updateItemRow(event, '{{ $item->id + 999 }}')"
                                                class="form-control chosen-select unitList unitList_{{ $item->id + 999 }}"
                                                disabled>
                                                <option value="">Select BudgetHead</option>
                                                @foreach ($data->budgetHeads as $budgetHead)
                                                <option value="{{$budgetHead->id}}" @if ($budgetHead->id ==
                                                    $item->budget_head_id)
                                                    selected
                                                    @endif
                                                    >{{$budgetHead->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control estimated estimated_{{ $item->id + 999 }}"
                                                type="number" step="any" name="estimated[]" value="" required readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control approved_amount_{{ $item->id + 999 }}" type="number"
                                                step="any" value="{{ $item->approved_amount_log }}" required readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control issued issued_{{ $item->id + 999 }}" type="number"
                                                step="any" name="issued[]" value="" step="any" required readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control approved_due_{{ $item->id + 999 }}" type="number"
                                                step="any" name="approved_due[]" value="{{ $item->approved_due_log }}"
                                                readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control amount amount_{{ $item->id + 999 }}" type="number"
                                                step="any" name="amount[]" value="{{ $item->requisition_amount }}"
                                                onkeyup="row_sum()" step="any" required readonly>
                                        </td>
                                        <td>
                                            <input class="form-control remarks remarks_{{ $item->id + 999 }}"
                                                type="text" name="item_remarks[]" value="{{ $item->remarks }}" readonly>
                                        </td>
                                        <td align="center">
                                            {{-- <span class="btn btn-success" onclick="addItem()">
                                                <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i>
                                            </span>
                                            <span class="btn btn-danger item_remove"
                                                onclick="itemRemove('{{ $item->id + 999 }}')">
                                                <i class="fa fa-trash" style="font-size: 20px"></i>
                                            </span> --}}

                                            <input style="text-align: center;"
                                                class="form-control approved_amount approved_amount_{{ $item->id + 999 }}"
                                                type="number" step="any" name="approved_amount[{{ $item->id }}]" value="{{ $item->approved_amount }}"
                                                onkeyup="row_sum()" required>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="px-1 py-1">
                                            <p class='text-right mb-0 mt-2'>Summary</p>
                                        </th>

                                        {{-- <th class="py-2 py-1">
                                            <input class="text-center total_estimated_amount form-control text-right" type="number"
                                                step="any" name="total_estimated_amount" value="0" readonly>
                                        </th> --}}

                                        <th class="py-2 py-1">
                                            <input class="text-center total_issued_amount form-control text-right" type="number"
                                                step="any" name="total_issued_amount" value="0" readonly>
                                        </th>

                                        <th class="py-2 py-1">
                                            <input class="text-center total_amount form-control text-right" type="number" step="any"
                                                name="total_amount" value="0" readonly>
                                        </th>

                                        <th></th>

                                        <th align="center" class="py-2 py-1">

                                            <input class="text-center total_approved_amount form-control text-right" type="number"
                                                step="any" name="total_approved_amount" value="0" readonly>

                                        </th>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success float-right">
                        <i class="fa fa-check-circle" aria-hidden="true"></i> Approve
                    </button>
                </div>
            </div>
        </div>
    </div>


</form>

<div id="itemList" style="display:none">
    <div class="input select">
        <select>
            <option value=" ">Select Vendor</option>
            <?php
                foreach ($data->vendors as $vendor)
                {
            ?>
            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
            <?php
                }
            ?>
        </select>
    </div>
</div>

<div id="unitList" style="display:none">
    <div class="input select">
        <select>
            <option value=" ">Select BudgetHead</option>
            <?php
                foreach ($data->budgetHeads as $budgetHead)
                {
            ?>
            <option value="{{$budgetHead->id}}">{{$budgetHead->name}}</option>
            <?php
                }
            ?>
        </select>
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
        const budget_head_id = $('.unitList_' + id + ' option:selected').val();

        // get estimated amount start
            axios.get(route('budgetHeadWiseTotalEstimated', [projectId, unitId, budget_head_id]))
            .then(function (response) {

                let data = response.data;

                $('.estimated_' + id).val(data);

                row_sum();

            })
            .catch(function (error) {
            })
        // get estimated amount end


    }

    function alreadyIssuedAmount(id){

        const projectId = +$('#project_id').val();
        const unitId = +$('#unit_id').val();
        const budget_head_id = $('.unitList_' + id + ' option:selected').val();

        // get issued amount start
        axios.get(route('budgetHeadWiseTotalPaid', [projectId, unitId, budget_head_id]))
        .then(function (response) {

            let data = response.data;

            $('.issued_' + id).val(data);

            row_sum();

        })
        .catch(function (error) {
        })
        // get issued amount end

    }

    function updateItemRow(e, id){

        const budget_head_id = $('.unitList_' + id + ' option:selected').val();

        if(!budget_head_id){
            return false;
        }

        budgetHeadWiseTotalEstimated(id);
        alreadyIssuedAmount(id);

    }
</script>

{{-- projectwise unit end --}}


{{-- table start --}}


@foreach ($data->cashrequisition->items as $item)
<script>
    document.addEventListener("DOMContentLoaded", updateItemRow(event, {{ $item->id + 999 }}));
</script>
@endforeach

<script type="text/javascript">
    function row_sum(){
        var total_amount = 0;
        $(".amount").each(function () {
            var stvalAmount = parseFloat($(this).val());
            total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
        });
        $('.total_amount').val(total_amount.toFixed(2));


        var total_approved_amount = 0;
        $(".approved_amount").each(function () {
            var stvalAmount = parseFloat($(this).val());
            total_approved_amount += isNaN(stvalAmount) ? 0 : stvalAmount;

        });
        $('.total_approved_amount').val(total_approved_amount.toFixed(2));


        var total_estimated_amount = 0;
        $(".estimated").each(function () {
            var stvalAmount = parseFloat($(this).val());
            total_estimated_amount += isNaN(stvalAmount) ? 0 : stvalAmount;

        });
        $('.total_estimated_amount').val(total_estimated_amount.toFixed(2));

        var total_issued_amount = 0;
        $(".issued").each(function () {
            var stvalAmount = parseFloat($(this).val());
            console.log($(this).val());
            total_issued_amount += isNaN(stvalAmount) ? 0 : stvalAmount;

        });
        $('.total_issued_amount').val(total_issued_amount.toFixed(2));

    }
</script>

{{-- table end --}}


@endsection

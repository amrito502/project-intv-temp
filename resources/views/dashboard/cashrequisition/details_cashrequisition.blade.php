@extends('dashboard.layouts.app')

@section('custom-css')
<style>
    .table th,
    .table td {
        padding: 0.75rem 0.30rem;
    }

    .table th {
        padding-right: 5px;
    }
</style>
@endsection

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('cashrequisition.pay') }}" method="POST">
    @csrf

    <input type="hidden" name="cash_requisition_id" value="{{ $data->cashrequisition->id }}">

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Cash Requisition Payment</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Cash Requisition Payment</h3>
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
                                        <th width="12%">Vendor</th>
                                        <th width="250px">Budget Head</th>
                                        <th class="text-center">Budget</th>
                                        <th class="text-center">Approved</th>
                                        <th class="text-center">Payment</th>
                                        <th class="text-center">Pending</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Requisition</th>
                                        <th class="text-center">Paid</th>
                                        <th class="text-center">Payment</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody">
                                    @foreach ($data->cashrequisition->items as $item)

                                    @php
                                    $rowPaid = $item->totalPaid();

                                    if($rowPaid >= $item->approved_amount){
                                    continue;
                                    }
                                    @endphp

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
                                                class="form-control estimated_{{ $item->id + 999 }}" type="number"
                                                step="any" value="" readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control approved_amount_{{ $item->id + 999 }}" type="number"
                                                step="any" value="{{ $item->approved_due_log }}" required readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control issued_{{ $item->id + 999 }}" type="number"
                                                step="any" value="{{ $item->issued_amount_log }}" readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control approved_due_{{ $item->id + 999 }}" type="number"
                                                step="any"
                                                value="{{ $item->approved_due_log - $item->issued_amount_log}}"
                                                readonly>
                                        </td>
                                        <td>
                                            <input class="form-control remarks remarks_{{ $item->id + 999 }}"
                                                type="text" value="{{ $item->remarks }}" readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control current_amount current_amount_{{ $item->id + 999 }}"
                                                type="number" step="any" value="{{ $item->approved_amount }}" readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control pay pay_{{ $item->id + 999 }}" type="number"
                                                value="{{ $rowPaid }}" readonly>
                                        </td>
                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control pay pay_{{ $item->id + 999 }}" type="number"
                                                name="pay[{{ $item->id }}]" value="0"
                                                max="{{ $item->approved_amount - $rowPaid }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                                {{-- <tfoot>
                                    <tr>
                                        <th colspan="7" class="px-1 py-1">
                                            <p class='text-center mb-0 mt-2'>Amount</p>
                                        </th>
                                        <th class="py-2 py-1">
                                            <input class="total_amount form-control text-right" type="number" step="any"
                                                name="total_amount" value="0" readonly>
                                        </th>

                                        <td align="center" class="py-2 py-1">

                                        </td>

                                    </tr>
                                </tfoot> --}}
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
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
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
    function budgetHeadWiseTotalEstimated(id){
        const projectId = +$('#project_id').val();
        const unitId = +$('#unit_id').val();
        const budget_head_id = $('.unitList_' + id + ' option:selected').val();

        // get estimated amount start
            axios.get(route('budgetHeadWiseTotalEstimated', [projectId, unitId, budget_head_id]))
            .then(function (response) {

                let data = response.data;

                $('.estimated_' + id).val(data);

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

            calculateDue(id);

        })
        .catch(function (error) {
        })
        // get issued amount end

    }

    function alreadyApprovedAmount(id){

        const projectId = +$('#project_id').val();
        const unitId = +$('#unit_id').val();
        const budget_head_id = $('.unitList_' + id + ' option:selected').val();

        // get issued amount start
        axios.get(route('budgetHeadWiseTotalApproved'), {
            params: {
                projectId: projectId,
                unitId: unitId,
                budgetHeadId: budget_head_id
            }
        })
        .then(function (response) {

            let data = response.data;

            $('.approved_amount_' + id).val(data);

            calculateDue(id);

        })
        .catch(function (error) {
        })
        // get issued amount end

    }

    function updateItemRow(id){

        const budget_head_id = $('.unitList_' + id + ' option:selected').val();

        if(!budget_head_id){
            return false;
        }

        budgetHeadWiseTotalEstimated(id);
        alreadyApprovedAmount(id);
        alreadyIssuedAmount(id);
    }

    function calculateDue(id){

        const approved_amount = +$('.approved_amount_' + id).val();
        const issued_amount = +$('.issued_' + id).val();

        const due = approved_amount - issued_amount;

        console.log(approved_amount, issued_amount, due);

        $('.approved_due_' + id).val(due);

    }

</script>

<script>
    function sleep(ms) {
      return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function initCalculation(rowId){
        updateItemRow(rowId);

        // await sleep(3000);

        // calculateDue(rowId);

    }
</script>

{{-- projectwise unit end --}}



@foreach ($data->cashrequisition->items as $item)
<script>
    document.addEventListener("DOMContentLoaded", initCalculation({{ $item->id + 999 }}));
</script>
@endforeach

@endsection

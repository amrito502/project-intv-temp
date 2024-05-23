@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('materialrequisition.approve.step.one') }}" method="POST">
    @csrf

    <input type="hidden" name="materialRequisitionId" value="{{ $data->materialrequisition->id }}">

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Material Requisition Approve</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Material Requisition Approve</h3>
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
                            <input type="hidden" value="{{ $data->materialrequisition->project->id }}" id="project_id"
                                readonly>
                            <input type="text" class="form-control"
                                value="{{ $data->materialrequisition->project->project_name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit_id">Unit</label>
                            <input type="hidden" value="{{ $data->materialrequisition->unit->id }}" id="unit_id" readonly>
                            <input type="text" class="form-control" value="{{ $data->materialrequisition?->unit?->name }}"
                                readonly>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <input type="text" class="form-control" value="{{ $data->materialrequisition?->tower?->name }}"
                                readonly>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="serial_no">Serial No</label>
                            <input class="form-control" name="text" id="serial_no" type="text"
                                value="{{ $data->materialrequisition->thisSerial() }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input class="form-control datepicker" value="{{ $data->materialrequisition->date }}"
                                name="date" id="date" type="text" autocomplete="off" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <input class="form-control" name="remarks" id="remarks" type="text"
                                value="{{ $data->materialrequisition->remarks }}" readonly>
                        </div>
                    </div>

                </div>

                <div class="row material_table">
                    <div class="col-md-12" style="overflow-y: auto">
                        <div class="form-group">
                            <table class="table gridTable">
                                <thead>
                                    <tr>
                                        <th width="300px">Material</th>
                                        <th class="text-right">Estimated Amount</th>
                                        <th class="text-right">Issued Amount</th>
                                        <th class="text-right">Balance</th>
                                        <th width="400px" class="text-right">Requisition Qty</th>
                                        <th>Approved Amount</th>
                                        <th>Final Amount</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody">
                                    @foreach ($data->materialrequisition->items as $item)
                                    <tr id="itemRow_{{ $item->id + 999 }}">
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
                                            <input style="text-align: right;" class="form-control" type="number"
                                                step="any" value="{{ $item->estimated_amount }}" readonly>
                                        </td>

                                        <td>
                                            <input style="text-align: right;" class="form-control" type="number"
                                                step="any" value="{{ $item->issued_amount }}" readonly>
                                        </td>

                                        <td>
                                            <input style="text-align: right;" class="form-control" type="number"
                                                step="any" value="{{ $item->balance_amount }}" readonly>
                                        </td>

                                        <td>
                                            <input style="text-align: right;"
                                                class="form-control amount amount_{{ $item->id + 999 }}" type="number" step="any"
                                                name="amount[]" value="{{ $item->requisition_amount }}"
                                                onkeyup="row_sum()" step="any" required readonly>
                                        </td>

                                        <td align="center">
                                            <input style="text-align: right;"
                                                class="form-control"
                                                type="number" step="any" value="{{ $item->approved_amount_one }}" onkeyup="row_sum()" required readonly>
                                        </td>

                                        <td align="center">
                                            <input style="text-align: right;"
                                                class="form-control approved_amount approved_amount_{{ $item->id + 999 }}"
                                                type="number" step="any" value="{{ $item->approved_amount_one }}" name="approved_amount[{{ $item->id }}]"
                                                onkeyup="row_sum()" required>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="px-1 py-1">
                                            <p class='text-right mb-0 mt-2'>Amount</p>
                                        </th>

                                        <th align="center" class="py-2 py-1">

                                            <input class="total_approved_amount form-control text-right" type="number" step="any"
                                                name="total_approved_amount" value="0" readonly>

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


            axios.get(route('projectUnitWiseBudgetHeadMaterialOnly', [projectId, unitId]))
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


@foreach ($data->materialrequisition->items as $item)
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
        $('.total_amount').val(total_amount.toFixed(4));


        var total_approved_amount = 0;
        $(".approved_amount").each(function () {
            var stvalAmount = parseFloat($(this).val());
            total_approved_amount += isNaN(stvalAmount) ? 0 : stvalAmount;

        });
        $('.total_approved_amount').val(total_approved_amount.toFixed(4));


        var total_estimated_amount = 0;
        $(".estimated").each(function () {
            var stvalAmount = parseFloat($(this).val());
            total_estimated_amount += isNaN(stvalAmount) ? 0 : stvalAmount;

        });
        $('.total_estimated_amount').val(total_estimated_amount.toFixed(4));

        var total_issued_amount = 0;
        $(".issued").each(function () {
            var stvalAmount = parseFloat($(this).val());
            console.log($(this).val());
            total_issued_amount += isNaN(stvalAmount) ? 0 : stvalAmount;

        });
        $('.total_issued_amount').val(total_issued_amount.toFixed(4));

    }
</script>

{{-- table end --}}


@endsection

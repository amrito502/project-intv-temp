@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('supplierpayment.store') }}">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class=" mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Create Supplier Payment</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Create Supplier Payment</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="">

                <div class="row">

                    @include('dashboard.layouts.partials.company_dropdown', [
                        'columnClass'=> 'col-md-4',
                        'company_id' => 0,
                    ])

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select class="select2" name="project" id="project" required>
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit_id">Unit</label>
                            <select class="select2" name="unit_config_id" id="unit_id" required>
                                <option value="">Select Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <select class="select2" name="tower" id="tower">
                                <option value="">Select Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="payment_no">Payment No</label>
                            <input class="form-control" name="payment_no" id="payment_no" type="text"
                                value="{{ $data->paymentNo }}" autocomplete="off" disabled>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date">Payment Date</label>
                            <input class="form-control" name="date" id="date" type="date" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="money_receipt">Money Receipt</label>
                            <input class="form-control" name="money_receipt" id="money_receipt" type="text">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="payment_type">Payment Type</label>
                            <select class="select2" name="payment_type" id="payment_type" required>
                                <option value="">Select Payment Type</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <input class="form-control" name="remarks" id="remarks" type="text">
                        </div>
                    </div>

                </div>

                <div class="row material_table" style="height: 600px;">
                    <div class="col-md-12" style="overflow-y: auto">
                        <table class="table gridTable mobile-changes">
                            <thead>
                                <tr>
                                    <th width="15%">Vendor</th>
                                    <th width="300px">Budget Head</th>
                                    <th class="text-right">Current Due</th>
                                    <th class="text-right">Payment Now</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody id="tbody">
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="3" class="px-1 py-1">
                                        <p class='text-center mb-0 mt-2'>Amount</p>
                                    </th>
                                    <th class="py-2 py-1">
                                        <input class="total_amount form-control text-right" type="number" step="any"
                                            name="total_amount" value="0" readonly>
                                    </th>
                                    <th class="py-2 py-1">
                                        <input type="hidden" class="row_count" value="1">
                                        <span class="btn btn-block btn-success add_item">
                                            <i class="fa fa-plus" style="font-size: 20px"></i>
                                        </span>
                                    </th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success mt-2 float-right">
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
        const projectId = +$('#project').val();
        const unitId = +$('#unit_id').val();
        const TowerId = +$('#tower').val();
        const budget_head_id = $('.unitList_' + id + ' option:selected').val();
        const vendorId = $('.itemList_' + id + ' option:selected').val();


        // get estimated amount start
            axios.get(route('project.wise.vendor.due', [projectId, vendorId]),{
            params: {
                unitId:unitId,
                TowerId:TowerId,
                budget_head_id:budget_head_id,
            }
        })
            .then(function (response) {

                let data = response.data;

                $('.current_due_' + id).val(data);

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

<script type="text/javascript">
    function addItem() {
        var row_count = $('.row_count').val();
        var total = parseInt(row_count) + 1;

        let rate_attr = '';
        let liftingType = $('#lifting_type').val();

        if(['Project wise Company Provide', 'Central Company Provide'].includes(liftingType)){
            rate_attr = 'readonly'
        }

        $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
            '<td>'+
            '<select name="vendor[]" onchange="updateItemRow(event, ' + total + ')" class="form-control chosen-select itemList itemList_'+total+'">'+
            '</select>'+
            '</td>'+
            '<td>'+
            '<select name="budget_head[]" onchange="updateItemRow(event, ' + total + ')" class="form-control chosen-select unitList unitList_'+total+'" required>'+
            '</select>'+
            '</td>'+
            '<td><input style="text-align: right;" class="form-control current_due_'+total+'" type="number" step="any" name="current_due[]" value="0" required readonly></td>'+
            '<td><input style="text-align: right;" class="form-control amount_'+total+'" type="number" step="any" name="amount[]" value="0" required '+ rate_attr +'></td>'+
            '<td align="center"><span class="btn btn-success" onclick="addItem()"> <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i> </span> <span class="btn btn-danger item_remove" onclick="itemRemove(' + total + ')"><i class="fa fa-trash" style="font-size: 20px"></i> </span></td>'+
            '</tr>');
        $('.row_count').val(total);

        var itemList = $("#itemList div select").html();
        $('.itemList_'+total).html(itemList);
        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        var unitList = $("#unitList div select").html();
        $('.unitList_'+total).html(unitList);
        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        row_sum();
    }

    $(".add_item").click(function () {
        addItem();
    });

    function itemRemove(i) {
        var total_amount = $('.total_amount').val();

        var amount = $('.amount_'+i).val();

        total_amount = total_amount - amount;

        $('.total_amount').val(total_amount.toFixed(2));

        $("#itemRow_" + i).remove();
    }

    function row_sum(){
        var total_amount = 0;

        $(".amount").each(function () {
            var stvalAmount = parseFloat($(this).val());
            total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
        });

        $('.total_amount').val(total_amount.toFixed(2));
    }
</script>

{{-- table end --}}

{{-- get Due start --}}
<script>
    $(document).ready(function () {

        $('#project').change(function (e) {
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

    });
</script>
{{-- get Due end --}}

@endsection

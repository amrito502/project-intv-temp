@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('materialrequisition.store') }}">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class=" mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Create Material Requisition</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Create Material Requisition</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div>

                <div class="row">

                    @include('dashboard.layouts.partials.company_dropdown', [
                    'columnClass'=> 'col-md-4',
                    'company_id' => 0,
                    ])

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project_id">Project</label>
                            <select class="select2" name="project_id" id="project_id" required>
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

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="serial_no">Serial No</label>
                            <input class="form-control" name="serial_no" id="serial_no" type="text"
                                value="{{ $data->serial }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input class="form-control datepicker" value="{{ date('d-m-Y') }}" name="date" id="date"
                                type="text" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <input class="form-control" name="remarks" id="remarks" type="text">
                        </div>
                    </div>

                </div>

                <div class="row material_table">
                    <div class="col-md-12" style="overflow-y: auto; height: 600px;">
                        <table class="table mobile-changes">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th class="text-right">Estimated Amount</th>
                                    <th class="text-right">Issued Amount</th>
                                    <th class="text-right">Balance</th>
                                    <th width="400px" class="text-right">Requisition Qty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody id="tbody">
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="4" class="px-1 py-1">
                                        <p class='mb-0 mt-2 text-right'>Amount</p>
                                    </th>
                                    <th class="py-2 py-1">
                                        <input class="total_amount form-control text-right" type="number" step="any"
                                            name="total_amount" value="0" readonly>
                                    </th>
                                    <td align="center" class="py-2 py-1">
                                        <input type="hidden" class="row_count" value="1">
                                        <span class="btn btn-block btn-success add_item">
                                            <i class="fa fa-plus" style="font-size: 20px"></i>
                                        </span>
                                    </td>

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

        // $('#unit_id').change(function (e) {
        //     e.preventDefault();

        //     const unitId = +$(this).val();

        //     if(unitId == ''){
        //         $('#unit_id').html('');
        //         return false;
        //     }

        //     let projectId = $('#project_id').val();


        //     axios.get(route('projectUnitWiseBudgetHeadMaterialhOnly', [projectId, unitId]))
        //     .then(function (response) {


        //         const items = response.data;


        //         let options = `<option value="">Select An Option</option>`;


        //         items.forEach(item => {

        //             let option = `<option value="${item.id}">${item.name}</option>`;

        //             options += option;

        //         });

        //         $('#unitList .input select').html('');
        //         $('#unitList .input select').html(options);

        //     })
        //     .catch(function (error) {
        //     })

        // });

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

            let budgetAmount = $('.estimated_' + id).val();
            let issuedAmount = $('.issued_' + id).val();

            let balance = budgetAmount - issuedAmount;


            $('.balance_' + id).val(balance);

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

        let vendorUser = false;
        let vendorUserId = 0;

        @if (auth()->user()->hasRole('Vendor'))
            vendorUser = true;
            vendorUserId = {{ auth()->user()->id }};
        @endif

        var row_count = $('.row_count').val();
        var total = parseInt(row_count) + 1;

        let rate_attr = '';
        let liftingType = $('#lifting_type').val();

        if(['Project wise Company Provide', 'Central Company Provide'].includes(liftingType)){
            rate_attr = 'readonly'
        }

        $("#tbody").append('<tr id="itemRow_' + total + '">' +
            '<td>'+
            '<select name="budget_head[]" onchange="updateItemRow(event, ' + total + ')" class="form-control chosen-select unitList unitList_'+total+'" required>'+
            '</select>'+
            '</td>'+
            '<td><input style="text-align: right;" class="form-control estimated_'+total+'" type="number" step="any" name="estimated[]" value="0" required readonly></td>'+
            '<td><input style="text-align: right;" class="form-control issued_'+total+'" type="number" step="any" name="issued[]" value="0" required '+ rate_attr +' readonly></td>'+
            '<td><input style="text-align: right;" class="form-control balance_'+total+'" type="number" step="any" name="balance[]" value="0" required '+ rate_attr +' readonly></td>'+
            '<td><input style="text-align: right;" class="form-control amount amount_'+total+'" type="number" step="any" name="amount[]" value="0" onkeyup="row_sum()" required></td>'+
            '<td align="center"><span class="btn btn-success" onclick="addItem()"> <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i> </span> <span class="btn btn-danger item_remove" onclick="itemRemove(' + total + ')"><i class="fa fa-trash" style="font-size: 20px"></i> </span></td>'+
            '</tr>');
        $('.row_count').val(total);

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

        $('.total_amount').val(total_amount.toFixed(4));

        $("#itemRow_" + i).remove();
    }

    function row_sum(){
        var total_amount = 0;

        $(".amount").each(function () {
            var stvalAmount = parseFloat($(this).val());
            total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
        });

        $('.total_amount').val(total_amount.toFixed(4));
    }

</script>

{{-- table end --}}
@endsection

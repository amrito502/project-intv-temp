@extends('dashboard.layouts.app')

@section('content')

@include('dashboard.projectwise_budget.partials.modal.new_material_modal')
@include('dashboard.projectwise_budget.partials.modal.new_budgetHead_modal')


<form method="POST" action="{{ route('additionalbudget.store') }}">
    @csrf

    <div class="tile">
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
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success float-right">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
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

                    <div class="col-md-3 mb-5">
                        <div class="row">

                            @include('dashboard.layouts.partials.company_dropdown', [
                            'columnClass'=> 'col-md-12',
                            'company_id' => 0,
                            ])

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" class="form-control" name="remarks_overall">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="project_id">Project</label>
                                    <select class="select2" name="project_id" id="project_id" required>
                                        <option value="">Select Project</option>
                                        @foreach ($data->projects as $project)
                                        <option value="{{ $project->id }}" pt="{{ $project->project_type }}">{{
                                            $project->project_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unit_id">Unit</label>
                                    <select class="select2" name="unit_id" id="unit_id" required>
                                        <option value="">Select Project First</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 project_type_tower d-none mb-3">
                                <div class="form-group">
                                    <label for="tower">Tower</label>
                                    <select class="select2" name="tower" id="tower">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 ">
                                <span class="btn btn-block btn-success" style="margin-top: 28px;" data-toggle="modal"
                                    data-target="#budgetHeadModal">
                                    New Cost
                                </span>
                            </div>

                            <div class="col-md-12 ">
                                <span class="btn btn-block btn-success" style="margin-top: 28px;" data-toggle="modal"
                                    data-target="#newMaterialModal">
                                    New Material
                                </span>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-9">

                        <div class="">

                            <div class="row">
                                <div class="col-md-6">

                                    <span class="btn btn-block btn-success add_item add_item_primary">
                                        <i class="fa fa-plus-circle" style="font-size: 20px"></i> Material
                                    </span>

                                </div>
                                <div class="col-md-6">

                                    <span
                                        class="btn btn-block btn-success add_item_OtherCost add_item_primary_OtherCost">
                                        <i class="fa fa-plus-circle" style="font-size: 20px"></i> Cash
                                    </span>

                                </div>
                            </div>

                        </div>

                        <div class="container-fluid">
                            <div class="row mt-3 text-light text-center">
                                <div class="col-md-3 bg-success">Budget Head</div>
                                <div class="col-md-2 bg-success">Rate</div>
                                <div class="col-md-2 bg-success">QTY</div>
                                <div class="col-md-2 bg-success">Amount</div>
                                <div class="col-md-2 bg-success">Remarks</div>
                                <div class="col-md-1 bg-success"></div>
                            </div>
                        </div>

                        <div class="row">

                            <input type="hidden" class="row_count" value="1">

                            <div class="col-md-12">
                                <div id="projectBudgetItems"></div>
                            </div>

                            <div class="col-md-12">
                                <div id="projectBudgetItemsOtherCost"></div>
                            </div>

                        </div>

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
            <option value="">Select Item</option>
            <?php
                foreach ($data->budgetheads->where('type', 'Material') as $budgethead)
                {

                    if($budgethead->materialInfo() == null) {
                        continue;
                    }
            ?>
            <option value="{{$budgethead->id}}">
                {{$budgethead->name}}
                ({{ $budgethead->materialInfo()->materialUnit->name }})
            </option>
            <?php
                }
            ?>
        </select>
    </div>
</div>

<div id="itemListOtherCost" style="display:none">
    <div class="input select">
        <select>
            <option value="">Select Item</option>
            <?php
                foreach ($data->budgetheads->where('type', 'Cash') as $budgethead)
                {

                    // if($budgethead->materialInfo() == null) {
                    //     continue;
                    // }
            ?>
            <option value="{{$budgethead->id}}">{{$budgethead->name}}</option>
            <?php
                }
            ?>
        </select>
    </div>
</div>

@endsection

@section('custom-script')

@include('dashboard.helper_js')

{{-- c3, cft calculation --}}
<script src="{{ asset('js/unit_estimation/footing_work_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/brick_soling_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/cap_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/pile_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/pluster_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/sand_filling_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/tiles_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/wall_calculation.js') }}"></script>


{{-- update amount on self defined head start --}}
<script>
    function updateCostAmount(class_name){
        let amount = +$('.' + class_name + '_rate').val() * +$('.' + class_name + '_qty').val();

        amount = parseFloat(amount).toFixed(2);

        $('.' + class_name + '_amount').val(amount);

        row_sum();
    }

    function updateAllCostAmount(){
        let rateEls = $('.rate');

        rateEls.each(function(i, el) {
            let El = $(el);
            let elClass = El.attr('sl');

            updateCostAmount(elClass);

        });

        // console.log(rateEls);
    }
</script>
{{-- update amount on self defined head end --}}


{{-- projectwise unit start --}}
<script>
    function getProjectTower(){

        let projectId = $('#project_id option:selected').val();


        // fetch tower start
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
        // fetch tower end

    }


    $(document).ready(function () {

        $('#project_id').change(function (e) {
            e.preventDefault();

            const projectId = +$(this).val();

            if(projectId == ''){
                $('#unit_id').html('');
                return false;
            }

            // fetch unit start
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
            // fetch unit end

            let projectType = $('#project_id option:selected').attr('pt');

            if(projectType == 'tower'){
                $('.project_type_tower').removeClass('d-none');
                getProjectTower();
            }else{
                $('.project_type_tower').addClass('d-none');
            }

        });

    });
</script>
{{-- projectwise unit end --}}


{{-- unit wise inputs start --}}
<script>
    function hideUnitDependentInputs(){
        $('.form').each(function(i, e){
            $(e).addClass('d-none');
        });
    }

    function calculateCftOfCap(cube){

        let m3 = getVolume(cube.length,cube.height ,cube.width) * 1.54;
        let cft = volumeToCft(m3);
        return cft;

    }

    function onNumberOfPileUpdate() {

        let number_of_pile = +$('#number_of_pile').val();

        let rateEls = $('.rate');

        rateEls.each(function(i, el) {
            let El = $(el);
            let class_name = El.attr('sl');

            let rate = +$('.' + class_name + '_rate').val();
            let qty = +$('.' + class_name + '_qty_oval').val();

            let newQty = qty * number_of_pile;

            let amount = rate * newQty;


            $('.' + class_name + '_qty').val(newQty);
            $('.' + class_name + '_amount').val(amount);

        });

        row_sum();

    }

    function updateQtyOval(class_name) {
        let qty = +$('.' + class_name + '_qty').val();
        $('.' + class_name + '_qty_oval').val(qty);

    }

</script>
{{-- unit wise inputs end --}}


{{-- budgetheadwise qty field enable/disable start --}}
<script>
    function budgetHeadChanged(i) {

        // const budgetHeadVal = $('.budgethead_' + i).val();

        // axios.get(route('budgetheadById', budgetHeadVal))
        // .then(function (response) {

        //     const data = response.data;

        //     const type = data.type;

        //     if(type == 'Material'){
        //         $('.qty_' + i).val('');
        //         $('.qty_' + i).attr('readonly', false);
        //     }else{
        //         $('.qty_' + i).attr('readonly', true);
        //     }

        // })
        // .catch(function (error) {
        // })

    }

</script>
{{-- budgetheadwise qty field enable/disable end --}}


{{-- invoice summation, add, delete start --}}
<script type="text/javascript">
    function addNewItem(){
        var row_count = $('.row_count').val();
        var total = parseInt(row_count) + 1;

        let html = `
        <div class="col-md-12" id="itemRow_${total}">

            <div class="row border mt-2 pt-3">

                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control chosen-select itemList_${total} budgethead_${total}" name="material_id[]"
                            required="" onchange="budgetHeadChanged(${total})">
                            <option value=" ">Select Item</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group text-center">
                        <input style="text-align: right;" class="rate form-control text-center ${total}_rate"
                            id="rate" type="number" step="any" name="rate[]" min="1" oninput="updateCostAmount('${total}')" sl="${total}" value="1">
                        <input type="hidden" name="uom[]" value="0">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group text-center">
                        <input type="hidden" class="${total}_qty_oval">
                        <input class="qty qty_${total} ${total}_qty form-control text-center" type="number" step="any"
                            name="qty[]" oninput="updateCostAmount('${total}');updateQtyOval('${total}')" min="1" value="0" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group text-center">
                        <input class="amount amount_${total} form-control ${total}_amount text-center" type="number" step="any"
                            name="amount[]" oninput="totalAmount('${total}')" value="0" min="1" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group text-center">
                        <input class="remarks remarks_${total} form-control ${total}_remarks text-center" type="text" name="remarks[]">
                    </div>
                </div>

                <div class="col-md-1">
                    <button class="btn btn-danger" onclick="itemRemove(${total})">
                        <i class="fa fa-trash" aria-hidden="true" style="font-size: 20px"></i>
                    </button>
                </div>


            </div>

        </div>
        `;

        // <button type="button" class="btn btn-primary" onclick="addNewItem()" style="margin-top: 29px;">
        //                 <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i>
        //             </button>

        $("#projectBudgetItems").append(html);
        $('.row_count').val(total);

        var itemList = $("#itemList div select").html();
        $('.itemList_'+total).html(itemList);
        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        // $(".add_item_primary").hide();

        row_sum();
    }

    $(".add_item").click(function () {
        addNewItem();
    });

    function addNewItemOtherCost(){
        var row_count = $('.row_count').val();
        var total = parseInt(row_count) + 1;

        let html = `
        <div class="col-md-12" id="itemRow_${total}">

            <div class="row border mt-2 pt-3">

                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control chosen-select itemList_${total} budgethead_${total}" name="material_id[]"
                            required="" onchange="budgetHeadChanged(${total})">
                            <option value=" ">Select Item</option>
                        </select>
                    </div>
                </div>


                <div class="col-md-2 ">
                    <div class="form-group text-center">
                        <input style="text-align: right;" class="rate form-control text-center ${total}_rate"
                            id="rate" type="number" step="any" name="rate[]" oninput="updateCostAmount('${total}')"  sl="${total}" value="1">
                        <input type="hidden" name="uom[]" value="0">
                    </div>
                </div>

                <div class="col-md-2 ">
                    <div class="form-group text-center">
                        <input type="hidden" class="${total}_qty_oval">
                        <input class="qty qty_${total} form-control ${total}_qty text-center" type="number" step="any"
                            name="qty[]" value="1" oninput="updateCostAmount('${total}');updateQtyOval('${total}')" required>
                    </div>
                </div>

                <div class="col-md-2 ">
                    <div class="form-group text-center">
                        <input class="amount amount_${total} ${total}_amount form-control text-center" type="number" step="any"
                            name="amount[]" oninput="totalAmount('0')" value="1" required>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group text-center">
                        <input class="remarks remarks_${total} form-control ${total}_remarks text-center" type="text" name="remarks[]">
                    </div>
                </div>

                <div class="col-md-1">
                    <button class="btn btn-danger" onclick="itemRemove(${total})">
                        <i class="fa fa-trash" aria-hidden="true" style="font-size: 20px"></i>
                    </button>
                </div>

            </div>

        </div>
        `;

        // <button type="button" class="btn btn-primary" onclick="addNewItemOtherCost()" style="margin-top: 29px;">
        //     <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i>
        // </button>

        $("#projectBudgetItemsOtherCost").append(html);
        $('.row_count').val(total);

        var itemList = $("#itemListOtherCost div select").html();
        $('.itemList_'+total).html(itemList);
        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        // $(".add_item_primary_OtherCost").hide();

        row_sum();
    }

    $(".add_item_OtherCost").click(function () {
        addNewItemOtherCost();
    });

    function itemRemove(i) {
        var total_qty = $('.total_qty').val();
        var total_amount = $('.total_amount').val();

        var quantity = $('.qty_'+i).val();
        var amount = $('.amount_'+i).val();

        total_qty = total_qty - quantity;
        total_amount = total_amount - amount;

        $('.total_qty').val(total_qty.toFixed(4));
        $('.total_amount').val(total_amount.toFixed(4));

        $("#itemRow_" + i).remove();
    }

    function totalAmount(i){
        // var amount = $(".amount_" + i).val();
        // var sum_total = parseFloat(amount);
        // $(".amount_" + i).val(sum_total.toFixed(4));
        row_sum();
    }

    function row_sum(){
        var total_amount = 0;
        var total_qty = 0;


        $(".qty").each(function () {
            var stvalQty = parseFloat($(this).val());
            total_qty += isNaN(stvalQty) ? 0 : stvalQty;
        });


        $(".amount").each(function () {
            var stvalAmount = parseFloat($(this).val());
            total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
        });

        $('.total_qty').val(total_qty.toFixed(4));
        $('.total_amount').val(total_amount.toFixed(4));
    }
</script>
{{-- invoice summation, add, delete end --}}


{{-- save new material start --}}
<script>
    $(document).ready(function () {
        $('#create_new_material_submit_btn').click(function (e) {
            e.preventDefault();

            // scrap data from inputs
            let data = {
                'code': $('#code').val(),
                'name': $('#name').val(),
                'unit': $('#unitId option:selected').val(),
                'budgetHead':$('#budgetHead').is(':checked'),
            }

            if(data.code == '' || data.name == '' || data.unit == ''){
                return false;
            }

            // send ajax request
            axios.post(route('material.store'), data)
            .then(function (response) {
                // update Dropdowns
                let rData = response.data;

                let option = `<option value="${rData.budgetHead.id}">${rData.budgetHead.name} (${rData.budgetHeadMaterialUnit.name})</option>`;

                $("#itemList div select").append(option);

            })
            .catch(function (error) {
            })

            // close modal
            $('#newMaterialModal').modal('hide');


        });
    });
</script>
{{-- save new material end --}}

{{-- save new budgethead start --}}
<script>
    $(document).ready(function () {

        $('#create_new_budgethead_submit_btn').click(function (e) {
            e.preventDefault();

            // scrap data from inputs
            let data = {
                'name': $('#bname').val(),
            }

            if(data.name == ''){
                return false;
            }

            // send ajax request
            axios.post(route('budgethead.store'), data)
            .then(function (response) {

                // update Dropdowns
                let rData = response.data;

                let option = `<option value="${rData.budgetHead.id}">${rData.budgetHead.name}</option>`;

                $("#itemListOtherCost div select").append(option);

            })
            .catch(function (error) {
            })

            // close modal
            $('#budgetHeadModal').modal('hide');


        });

    });
</script>
{{-- save new budgethead end --}}

@endsection

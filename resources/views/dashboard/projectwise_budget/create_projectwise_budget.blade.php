@extends('dashboard.layouts.app')


@section('custom-css')
<style>
    .title-text{
        font-size: 16px;
        font-weight: 600;
        padding: 7px 0;
        background-color: #009688;
    }

    .item-list .form-group{
        margin-bottom: 0 !important;
    }
</style>
@endsection

@section('content')

@include('dashboard.projectwise_budget.partials.modal.inherit_modal')
@include('dashboard.projectwise_budget.partials.modal.new_material_modal')
@include('dashboard.projectwise_budget.partials.modal.new_budgetHead_modal')


<form method="POST" action="{{ route('projectwisebudget.store') }}">
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

                                <button type="button" class="btn btn-block btn-primary text-center" data-toggle="modal"
                                    data-target="#inheritModal">Inherit</button>
                            </div>

                            <div class="col-md-6 project_type_tower">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date">
                                </div>
                            </div>

                            <div class="col-md-6 project_type_tower">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unit_config_id">Unit Config</label>
                                    <select class="select2" name="unit_config_id" id="unit_config_id" required>
                                        <option value="">Select Unit First</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 form">
                                <div class="form-group">
                                    <label for="undefined">Long/Volume</label>
                                    <input type="text" class="form-control" name="undefined" id="undefined" disabled>
                                </div>
                            </div>

                            <div class="col-md-6 form form-8 d-none">
                                <div class="form-group">
                                    <label for="long">Long</label>
                                    <input type="text" class="form-control" name="long" id="long" value>
                                </div>
                            </div>

                            <div class="col-md-6 form form-9 d-none">
                                <div class="form-group">
                                    <label for="volume">Volume</label>
                                    <input type="text" class="form-control" name="volume" id="volume">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_of_pile">Piles Qty</label>
                                    <input type="number" step="any" name="number_of_pile" id="number_of_pile"
                                        onkeyup="onNumberOfPileUpdate()" class="form-control" value="1">
                                </div>
                            </div>

                            <div class="col-md-12 ">
                                <div class="form-group text-center">
                                    <label for="">Total Amount</label>
                                    <input class="total_amount form-control mt-2 text-center" type="number" step="any"
                                        name="total_amount" value="0" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 ">
                                <div class="form-group text-center">
                                    <label for="">Volume</label>
                                    <input class="total_volume form-control mt-2 text-center" id="total_volume"
                                        type="text" name="total_volume" value="0" readonly>
                                </div>
                            </div>

                            <div class="col-md-12  d-none">
                                <div class="form-group text-center">
                                    <label for="">Total Qty</label>
                                    <input class="total_qty form-control mt-2 text-center" type="number" step="any"
                                        name="total_qty" value="0" readonly>
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

                    <div class="col-md-9 ">

                        <div class="row">
                            <div class="col-md-6">
                                <span class="btn btn-block btn-success add_item add_item_primary">
                                    <i class="fa fa-plus-circle" style="font-size: 20px"></i> Material
                                </span>
                            </div>
                            <div class="col-md-6">
                                <span class="btn btn-block btn-success add_item_OtherCost add_item_primary_OtherCost">
                                    <i class="fa fa-plus-circle" style="font-size: 20px"></i> Cash
                                </span>
                            </div>
                        </div>

                        <div class="container-fluid">
                            <div class="row mt-3 text-light text-center">
                                <div class="col-md-5 title-text text-left pl-3">Material/Cost Name</div>
                                <div class="col-md-2 title-text">Rate</div>
                                <div class="col-md-2 title-text">QTY</div>
                                <div class="col-md-2 title-text">Amount</div>
                                <div class="col-md-1 title-text"></div>
                            </div>
                        </div>

                        <div class="container-fluid item-list">

                            {{-- cement qty start --}}
                            <div class="row permanent_product_qty mt-2">

                                <div class="col-md-5 px-0">
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-control" id="cement_label_uom"
                                            value="Cement (Bosta)" disabled>
                                        <input type="hidden" name="material_id[]" value="3">
                                    </div>
                                </div>

                                <div class="col-md-2 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input style="text-align: right;" class="rate form-control text-center 1_rate"
                                            sl="1" id="rate" type="number" step="any" name="rate[]" min="1"
                                            oninput="updateCostAmount('1')" value="1">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>

                                <div class="col-md-2 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input type="hidden" class="1_qty_oval">
                                        <input class="qty form-control text-center 1_qty" type="number" step="any"
                                            id="cement-qty" name="qty[]"
                                            oninput="updateCostAmount('1');updateQtyOval('1')" min="1" value="" readonly
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-2 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input class="amount form-control text-center 1_amount" type="number" step="any"
                                            name="amount[]" oninput="totalAmount('0')" min="1" value="0" required>
                                    </div>
                                </div>

                            </div>
                            {{-- cement qty end --}}

                            {{-- sand qty start --}}
                            <div class="row permanent_product_qty mt-2">
                                <div class="col-md-5 px-0">
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-control" id="sand_label_uom" value="Sand (CFT)"
                                            disabled>
                                        <input type="hidden" name="material_id[]" value="4">
                                    </div>
                                </div>

                                <div class="col-md-2 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input style="text-align: right;" class="rate form-control text-center 2_rate"
                                            id="rate" type="number" step="any" name="rate[]" min="1" sl="2"
                                            oninput="updateCostAmount('2');updateQtyOval('2')" value="1">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>

                                <div class="col-md-2 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input type="hidden" class="2_qty_oval">
                                        <input class="qty form-control 2_qty text-center" id="sand-qty" type="number"
                                            step="any" name="qty[]" oninput="updateCostAmount('2')" min="1" value=""
                                            readonly required>
                                    </div>
                                </div>

                                <div class="col-md-2 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input class="amount form-control 2_amount text-center" type="number" step="any"
                                            oninput="totalAmount('0')" value="0" min="1" name="amount[]" required>
                                    </div>
                                </div>

                            </div>
                            {{-- sand qty end --}}

                            {{-- stone qty start --}}
                            <div class="row permanent_product_qty mt-2">
                                <div class="col-md-5 px-0">
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-control" id="stone_label_uom" value="Stone (CFT)"
                                            disabled>
                                        <input type="hidden" name="material_id[]" value="5">
                                    </div>
                                </div>

                                <div class="col-md-2 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input style="text-align: right;" class="rate form-control text-center 3_rate"
                                            id="rate" type="number" step="any" name="rate[]" sl="3" min="1"
                                            oninput="updateCostAmount('3');updateQtyOval('3')" value="1">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>

                                <div class="col-md-2 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input type="hidden" class="3_qty_oval">
                                        <input class="qty form-control 3_qty text-center" id="stone-qty" type="number"
                                            step="any" name="qty[]" oninput="updateCostAmount('3')" min="1" value=""
                                            readonly required>
                                    </div>
                                </div>


                                <div class="col-md-2 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input class="amount form-control 3_amount text-center" type="number" step="any"
                                            oninput="totalAmount('0')" value="0" min="1" name="amount[]" required>
                                    </div>
                                </div>
                                <input type="hidden" class="row_count" value="4">

                            </div>
                            {{-- stone qty end --}}

                        </div>

                        <div class="row item-list">

                            <div class="col-md-12">
                                <div id="projectBudgetItems"></div>
                            </div>

                            {{-- roa start --}}
                            <div class="container-fluid">
                                <div class="col-md-12 mt-2">

                                    <div class="row permanent_product_qty">
                                        <div class="col-md-5 px-0">
                                            <div class="form-group mt-2">
                                                <input type="text" class="form-control" value="ROA Cost" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-2 pr-0">
                                            <div class="form-group text-center mt-2">
                                                <input style="text-align: right;" class="rate form-control text-center"
                                                    type="number" step="any" value="0" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2 pr-0">
                                            <div class="form-group text-center mt-2">
                                                <input class="form-control text-center" type="number" step="any"
                                                    value="0" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2 pr-0">
                                            <div class="form-group text-center mt-2">
                                                <input class="form-control text-center" type="number" step="any"
                                                    value="0" readonly>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            {{-- roa end --}}

                            {{-- labor start --}}
                            <div class="container-fluid ">
                                <div class="col-md-12 mt-2">

                                    <div class="row permanent_product_qty ">
                                        <div class="col-md-5 px-0">
                                            <div class="form-group mt-2">
                                                <input type="text" class="form-control" value="Rig Labor Cost" disabled>
                                                <input type="hidden" name="material_id[]" value="6">
                                            </div>
                                        </div>

                                        <div class="col-md-2 pr-0">
                                            <div class="form-group text-center mt-2">
                                                <input style="text-align: right;"
                                                    class="rate form-control text-center labor_rate"
                                                    oninput="updateCostAmount('labor');updateQtyOval('labor')"
                                                    sl="labor" id="labor_rate" type="number" step="any" name="rate[]"
                                                    value="1">
                                                <input type="hidden" name="uom[]" value="0" min="1">
                                            </div>
                                        </div>

                                        <div class="col-md-2 pr-0">
                                            <div class="form-group text-center mt-2">
                                                <input type="hidden" class="labor_qty_oval">
                                                <input class="qty form-control text-center labor_qty" id="labor-qty"
                                                    type="number" step="any" name="qty[]"
                                                    oninput="updateCostAmount('labor')" value="" min="1" required
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2 pr-0">
                                            <div class="form-group text-center mt-2">
                                                <input id="labor-amount"
                                                    class="amount form-control text-center labor_amount" type="number"
                                                    step="any" name="amount[]" oninput="totalAmount('0')" value="0"
                                                    min="1" required>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            {{-- labor end --}}

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

{{-- calculate on unit start --}}
<script>
    function updateUnitConfigVolume(){

        let cube = 0;
        let unitEstimationEl =  $('#unit_config_id option:selected');
        let unitId = unitEstimationEl.attr('unitid');


        if(unitId == 8){

            let pileLength = unitEstimationEl.attr('pile_length');
            let dia = unitEstimationEl.attr('dia');
            dia = (dia / 1000);

            let value = (pileLength * 3.1416 * dia) / 4;
            cube = calculateCubeOfPile(value, 1.54);

        }

        if(unitId == 9){
            let length = unitEstimationEl.attr('length') / 1000;
            let width = unitEstimationEl.attr('width') / 1000;
            let height = unitEstimationEl.attr('height') / 1000;
            cube = getVolume(length, width, height);
        }

        if(unitId == 10){
            let length = unitEstimationEl.attr('length') / 1000;
            let width = unitEstimationEl.attr('width') / 1000;
            let height = unitEstimationEl.attr('height') / 1000;
            cube = getVolume(length, width, height);
        }

        if(unitId == 11){
            let length = unitEstimationEl.attr('length') / 1000;
            let width = unitEstimationEl.attr('width') / 1000;
            let height = unitEstimationEl.attr('height') / 1000;
            cube = getVolume(length, width, height);
        }

        if(unitId == 12){
            let length = unitEstimationEl.attr('length') / 1000;
            let width = unitEstimationEl.attr('width') / 1000;
            let height = unitEstimationEl.attr('height') / 1000;
            cube = getVolume(length, width, height);
        }

        if(unitId == 13){
            let length = unitEstimationEl.attr('length') / 1000;
            let width = unitEstimationEl.attr('width') / 1000;
            let height = unitEstimationEl.attr('height') / 1000;
            cube = getVolume(length, width, height);
        }

        if(unitId == 14){
            let length = unitEstimationEl.attr('length') / 1000;
            let width = unitEstimationEl.attr('width') / 1000;
            let height = unitEstimationEl.attr('height') / 1000;
            cube = getVolume(length, width, height);
        }

        if(unitId == 15){
            let length = unitEstimationEl.attr('length') / 1000;
            let width = unitEstimationEl.attr('width') / 1000;
            let height = unitEstimationEl.attr('height') / 1000;
            cube = getVolume(length, width, height);
        }

        if(unitId == 16){
            let length = unitEstimationEl.attr('length');
            let width = unitEstimationEl.attr('width');
            let height = unitEstimationEl.attr('height');
            cube = getVolume(length, width, height);
        }

        if(unitId == 17){
            let length = unitEstimationEl.attr('length') / 1000;
            let height = unitEstimationEl.attr('height') / 1000;
            cube = getArea(length, height);
        }

        if(unitId == 18){
            let length = unitEstimationEl.attr('length');
            let width = unitEstimationEl.attr('width');
            cube = getArea(length, width);
        }

        if(unitId == 19){
            let length = unitEstimationEl.attr('length') / 1000;
            let width = unitEstimationEl.attr('width') / 1000;
            let height = unitEstimationEl.attr('height') / 1000;
            cube = getVolume(length, width, height);
        }

        if(unitId == 20){
            let length = unitEstimationEl.attr('length') / 1000;
            let width = unitEstimationEl.attr('width') / 1000;
            cube = getArea(length, width);
        }

        cube = cube.toFixed(4);

        $('#total_volume').val(cube);

    }

</script>
{{-- calculate on unit end--}}

{{-- inherit start --}}
<script>
    $(document).ready(function () {

        $('#inheritBtn').click(function (e) {
            e.preventDefault();

            // close modal
            $('#inheritModal').modal('hide')

            // get input data
            const towerId = $('#tower_inherit option:selected').val();
            const unitConfigId = $('#unit_config_id_inherit option:selected').val();
            const newTower = $('#tower option:selected').val();

            if (towerId == 0 || unitConfigId == 0 || newTower == 0) {
                alert('Please select all fields');
                return;
            }

            // window redirect
            let url = route('projectwisebudget.inherit.view', [towerId, unitConfigId, newTower]);
            window.location = url;

        });

    });
</script>
{{-- inherit end --}}

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


        // fetch inherit tower start
        axios.get(route('projectwise.tower.inherit', projectId))
            .then(function (response) {

            const data = response.data.project_inherit_towers;
            const dataForUnitConfig = response.data.project_inherit_unit_configs;

            let options = `<option value="">Select An Option</option>`;
            let optionsForUnitConfig = `<option value="">Select An Option</option>`;

            data.forEach(el => {

                let option = `<option value="${el.id}">${el.name}</option>`;

                options += option;

            });

            dataForUnitConfig.forEach(conf => {

                let option = `<option value="${conf.id}">${conf.unit_name}</option>`;


                optionsForUnitConfig += option;

            });

            $('#tower_inherit').html(options);


            $('#unit_config_id_inherit').html(optionsForUnitConfig);


        })
        .catch(function (error) {
        })
        // fetch inherit tower end

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

        $('#unit_id').change(function (e) {
            e.preventDefault();

            const unitId = +$(this).val();
            const projectId = +$('#project_id').val();

            if(unitId == ''){
                $('#unit_config_id').html('');
                return false;
            }

            axios.get(route('project.unit.config', [projectId, unitId]))
            .then(function (response) {

                const data = response.data.unit_config;
                let static_materials = response.data.static_material_info;

                let options = `<option value="">Select An Option</option>`;

                data.forEach(el => {

                    let option = `<option value="${el.id}" unitid="${el.unit_id}" pile_length="${el.pile_length}" dia="${el.dia}" length="${el.length}" width="${el.width}" height="${el.height}" cementqty="${el.cement_qty}" cementunit="${static_materials[0].material_unit.name}" sandqty="${el.sand_qty}" sandunit="${static_materials[1].material_unit.name}" stoneqty="${el.stone_qty}" stoneunit="${static_materials[2].material_unit.name}" >${el.unit_name}</option>`;

                    options += option;

                });


                $('#unit_config_id').html(options);

            })
            .catch(function (error) {
            })

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


    $(document).ready(function () {

        $('#unit_config_id').change(function (e) {
            e.preventDefault();

            hideUnitDependentInputs();

            const unitEstimationEl =  $('#unit_config_id option:selected');
            const unitId =  +unitEstimationEl.attr('unitid');

            updateUnitConfigVolume();

            let forms = $('.form-' + unitId);

            // get permanent items data
            let number_of_pile = +$('#number_of_pile').val();

            let cementQty =  number_of_pile * +unitEstimationEl.attr('cementqty');
            let sandQty =  number_of_pile * +unitEstimationEl.attr('sandqty');
            let stoneQty =  number_of_pile * +unitEstimationEl.attr('stoneqty');


            $('#cement-qty').val(cementQty);
            $('#sand-qty').val(sandQty);
            $('#stone-qty').val(stoneQty);

            $('.1_qty_oval').val(cementQty);
            $('.2_qty_oval').val(sandQty);
            $('.3_qty_oval').val(stoneQty);


            forms.removeClass('d-none');

            $('#cement_label_uom').val(`Cement (${unitEstimationEl.attr('cementunit')})`);
            $('#sand_label_uom').val(`Sand (${unitEstimationEl.attr('sandunit')})`);
            $('#stone_label_uom').val(`Stone (${unitEstimationEl.attr('stoneunit')})`);


            let laborQty = 0;

            if(unitId == 8){

                const pile_length =  +unitEstimationEl.attr('pile_length');

                $('#long').val(pile_length)

                laborQty = pile_length * number_of_pile;

            }

            if (unitId == 9) {

                let cube = {
                    'length' : +unitEstimationEl.attr('length') / 1000,
                    'width' : +unitEstimationEl.attr('width') / 1000,
                    'height' : +unitEstimationEl.attr('height') / 1000,
                }

                let cft = parseFloat(calculateCftOfCap(cube)).toFixed(4);

                $('#volume').val(cft)

                laborQty = cft * number_of_pile;

            }

            $('#labor-qty').val(laborQty);
            $('.labor_qty_oval').val(laborQty);


            row_sum();

            updateAllCostAmount();


        });

    });
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

            <div class="row  mt-2">

                <div class="col-md-5 px-0">
                    <div class="form-group mt-2">
                        <select class="form-control chosen-select itemList_${total} budgethead_${total}" name="material_id[]"
                            required="" onchange="budgetHeadChanged(${total})">
                            <option value=" ">Select Item</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group mt-2 text-center">
                        <input style="text-align: right;" class="rate form-control text-center ${total}_rate"
                            id="rate" type="number" step="any" name="rate[]" min="1" oninput="updateCostAmount('${total}')" sl="${total}" value="1">
                        <input type="hidden" name="uom[]" value="0">
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group mt-2 text-center">
                        <input type="hidden" class="${total}_qty_oval">
                        <input class="qty qty_${total} ${total}_qty form-control text-center" type="number" step="any"
                            name="qty[]" oninput="updateCostAmount('${total}');updateQtyOval('${total}')" min="1" value="0" required>
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group mt-2 text-center">
                        <input class="amount amount_${total} form-control ${total}_amount text-center" type="number" step="any"
                            name="amount[]" oninput="totalAmount('${total}')" value="0" min="1" required>
                    </div>
                </div>


                <div class="col-md-1">
                    <button class="btn btn-danger mt-2" onclick="itemRemove(${total})">
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

            <div class="row mt-2">

                <div class="col-md-5 px-0">
                    <div class="form-group mt-2">
                        <select class="form-control chosen-select itemList_${total} budgethead_${total}" name="material_id[]"
                            required="" onchange="budgetHeadChanged(${total})">
                            <option value=" ">Select Item</option>
                        </select>
                    </div>
                </div>


                <div class="col-md-2 pr-0">
                    <div class="form-group text-center mt-2">
                        <input style="text-align: right;" class="rate form-control text-center ${total}_rate"
                            id="rate" type="number" step="any" name="rate[]" oninput="updateCostAmount('${total}')"  sl="${total}" value="1">
                        <input type="hidden" name="uom[]" value="0">
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group text-center mt-2">
                        <input type="hidden" class="${total}_qty_oval">
                        <input class="qty qty_${total} form-control ${total}_qty text-center" type="number" step="any"
                            name="qty[]" value="1" oninput="updateCostAmount('${total}');updateQtyOval('${total}')" required>
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group text-center mt-2">
                        <input class="amount amount_${total} ${total}_amount form-control text-center" type="number" step="any"
                            name="amount[]" oninput="totalAmount('0')" value="1" required>
                    </div>
                </div>

                <div class="col-md-1">
                    <button class="btn btn-danger mt-2" onclick="itemRemove(${total})">
                        <i class="fa fa-trash" aria-hidden="true" style="font-size: 20px"></i>
                    </button>
                </div>

            </div>

        </div>
        `;

        // <button type="button" class="btn btn-primary" onclick="addNewItemOtherCost()" style="margin-top: 29px;">
        //                 <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i>
        //             </button>

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

@endsection

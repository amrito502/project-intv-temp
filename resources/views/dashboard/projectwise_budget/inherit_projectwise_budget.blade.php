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
@include('dashboard.layouts.partials.error')

<form method="POST" action="{{ route('projectwisebudget.store') }}">
    @csrf

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Create Budget Prepare</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Create Budget Prepare</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="">

                <div class="row">

                    <div class="col-md-3">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="project_id">Project</label>
                                    <input type="text" class="form-control" id="project_name"
                                        value="{{ $data->projectwisebudget->project->project_name }}" readonly>
                                    <input type="hidden" id="project_id" name="project_id"
                                        value="{{ $data->projectwisebudget->project->id }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unit_id">Unit</label>
                                    <input type="text" class="form-control"
                                        value="{{ $data->projectwisebudget->unitConfig->unit->name }}" readonly>
                                    <input type="hidden" id="unit_id" name="unit_id"
                                        value="{{ $data->projectwisebudget->unitConfig->unit->id }}">

                                </div>
                            </div>

                            @if ($data->projectwisebudget->project->project_type == "tower")

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tower">Tower</label>
                                    <select class="select2" name="tower" id="tower" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 project_type_tower">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date"
                                        value="{{ $data->projectwisebudget->start_date }}">
                                </div>
                            </div>

                            <div class="col-md-6 project_type_tower">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date"
                                        value="{{ $data->projectwisebudget->end_date }}">
                                </div>
                            </div>
                            @endif


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unit_config">Unit Config</label>
                                    <input type="text" class="form-control" id="unit_config"
                                        value="{{ $data->projectwisebudget->unitConfig->unit_name }}" readonly>

                                    <input type="hidden" name="unit_config_id"
                                        value="{{ $data->projectwisebudget->unitConfig->id }}">

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="undefined">Long/Volume</label>
                                    @php
                                    $longOrVolume = 0;
                                    $unitId = $data->projectwisebudget->unitConfig->unit->id;

                                    if($unitId == 8){
                                    $longOrVolume = $data->projectwisebudget->long_l;
                                    }

                                    if ($unitId == 9){
                                    $longOrVolume = $data->projectwisebudget->volume;
                                    }

                                    @endphp
                                    <input type="text" class="form-control text-center" name="long" id="long"
                                        value="{{ $longOrVolume }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_of_pile">Piles Qty</label>
                                    <input type="text" name="number_of_pile" id="number_of_pile"
                                        class="form-control text-center" onkeyup="onNumberOfPileUpdate()"
                                        value="{{ $data->projectwisebudget->number_of_pile }}">
                                </div>
                            </div>

                            <div class="col-md-12 col-6">
                                <div class="form-group text-center">
                                    <label for="">Total Amount</label>
                                    <input class="total_amount form-control text-center mt-2" type="number" step="any"
                                        name="total_amount"
                                        value="{{ $data->projectwisebudget->BudgetGrandTotalAmount() }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-12 col-6">
                                <div class="form-group text-center">
                                    <label for="">Total Qty</label>
                                    <input class="total_qty form-control text-center mt-2" type="number" step="any"
                                        name="total_qty" value="{{ $data->projectwisebudget->BudgetGrandTotalQty() }}"
                                        readonly>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-md-9">

                        <div class="row mb-4">
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

                                @php
                                $cement = $data->projectwisebudget->items->where('budget_head', 3)->first();
                                @endphp

                                <div class="col-md-5 px-0">
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-control" value="Cement (Bosta)" disabled>
                                        <input type="hidden" name="material_id[]" value="3">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input style="text-align: right;" class="rate form-control text-center 1_rate"
                                            sl="1" id="rate" type="number" step="any" name="rate[]" min="1"
                                            oninput="updateCostAmount('1')"
                                            value="{{ $cement->amount / $cement->qty }}">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input type="hidden" class="1_qty_oval" value="{{ $cement->qty }}">
                                        <input class="qty form-control text-center 1_qty" type="number" step="any" id="cement-qty"
                                            name="qty[]" oninput="updateCostAmount('1');updateQtyOval('1')" min="1"
                                            value="{{ $cement->qty }}" readonly required>
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input class="amount form-control text-center 1_amount" type="number" step="any"
                                            name="amount[]" oninput="totalAmount('0')" min="1"
                                            value="{{ $cement->amount }}" required>
                                    </div>
                                </div>

                            </div>
                            {{-- cement qty end --}}

                            {{-- sand qty start --}}
                            <div class="row permanent_product_qty mt-2">

                                @php
                                $sand = $data->projectwisebudget->items->where('budget_head', 4)->first();
                                @endphp

                                <div class="col-md-5 px-0">
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-control" value="Sand (CFT)" disabled>
                                        <input type="hidden" name="material_id[]" value="4">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input style="text-align: right;" class="rate form-control text-center 2_rate"
                                            id="rate" type="number" step="any" name="rate[]" min="1" sl="2"
                                            oninput="updateCostAmount('2');updateQtyOval('2')"
                                            value="{{ $sand->amount / $sand->qty }}">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input type="hidden" class="2_qty_oval" value="{{ $sand->qty }}">
                                        <input class="qty form-control 2_qty text-center" id="sand-qty" type="number" step="any"
                                            name="qty[]" oninput="updateCostAmount('2')" value="{{ $sand->qty }}"
                                            readonly required>
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input class="amount form-control 2_amount text-center" type="number" step="any"
                                            oninput="totalAmount('0')" value="{{ $sand->amount }}" name="amount[]"
                                            required>
                                    </div>
                                </div>

                            </div>
                            {{-- sand qty end --}}

                            {{-- stone qty start --}}
                            <div class="row permanent_product_qty mt-2">

                                @php
                                $stone = $data->projectwisebudget->items->where('budget_head', 5)->first();
                                @endphp

                                <div class="col-md-5 px-0">
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-control" value="Stone (CFT)" disabled>
                                        <input type="hidden" name="material_id[]" value="5">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input style="text-align: right;" class="rate form-control text-center 3_rate"
                                            id="rate" type="number" step="any" name="rate[]" sl="3" min="1"
                                            oninput="updateCostAmount('3');updateQtyOval('3')"
                                            value="{{ $stone->amount / $stone->qty }}">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input type="hidden" class="3_qty_oval" value="{{ $stone->qty }}">
                                        <input class="qty form-control 3_qty text-center" id="stone-qty" type="number" step="any"
                                            name="qty[]" oninput="updateCostAmount('3')" min="1"
                                            value="{{ $stone->qty }}" readonly required>
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input class="amount form-control 3_amount text-center" type="number" step="any"
                                            oninput="totalAmount('0')" value="{{ $stone->amount }}" name="amount[]"
                                            required>
                                    </div>
                                </div>

                            </div>
                            {{-- stone qty end --}}


                            {{-- others material start --}}
                            @foreach ($data->projectwisebudget->items as $item)
                            @php
                            if($item->budgetHead->type == 'Cash'){
                            continue;
                            }

                            if(in_array($item->budget_head, [3,4,5])){
                            continue;
                            }
                            @endphp


                            <div class="row permanent_product_qty mt-2" id="itemRow_{{ $item->budgetHead->id+1000 }}">

                                <div class="col-md-5 px-0">
                                    <div class="form-group mt-2">
                                        <input type="text" class="form-control" value="{{ $item->budgetHead->name }}"
                                            disabled>
                                        <input type="hidden" name="material_id[]" value="{{ $item->budgetHead->id }}">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input step="any" style="text-align: right;"
                                            class="rate form-control text-center {{ $item->budgetHead->id+1000 }}_rate"
                                            id="rate" type="number" step="any" sl="{{ $item->budgetHead->id+1000 }}" name="rate[]"
                                            oninput="updateCostAmount('{{ $item->budgetHead->id+1000 }}')"
                                            value="{{ $item->amount / $item->qty }}">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input type="hidden" class="{{ $item->budgetHead->id+1000 }}_qty_oval"
                                            value="{{ $item->qty }}">
                                        <input class="qty form-control text-center {{ $item->budgetHead->id+1000 }}_qty"
                                            type="number" step="any" name="qty[]"
                                            oninput="updateCostAmount('{{ $item->budgetHead->id+1000 }}')"
                                            value="{{ $item->qty }}" required>
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group mt-2 text-center">
                                        <input
                                            class="amount form-control text-center {{ $item->budgetHead->id+1000 }}_amount"
                                            type="number" step="any" oninput="totalAmount('{{ $item->amount }}')"
                                            value="{{ $item->amount }}" name="amount[]" required>
                                    </div>
                                </div>

                                <div class="col-md-1 mt-2 pr-0">
                                    <button class="btn btn-danger" style="margin-left: 10px;"
                                        onclick="itemRemove('{{ $item->id }}')">
                                        <i class="fa fa-trash" aria-hidden="true" style="font-size: 20px"></i>
                                    </button>
                                </div>

                            </div>

                            @endforeach
                            {{-- others material end --}}

                        </div>

                        <div class="row item-list">

                            <div class="col-md-12">
                                <div id="projectBudgetItems"></div>
                            </div>

                            <div class="container-fluid">
                                <div class="col-md-12">

                                    {{-- labor start --}}
                                    <div class="row permanent_product_qty mt-2">

                                        @php
                                        $labor = $data->projectwisebudget->items->where('budget_head', 6)->first();
                                        @endphp

                                        <div class="col-md-5 px-0">
                                            <div class="form-group mt-2">
                                                <input type="text" class="form-control" value="Rig Labor Cost" disabled>
                                                <input type="hidden" name="material_id[]" value="6">
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group mt-2 text-center">
                                                <input class="rate form-control text-center labor_rate" sl="labor"
                                                    id="labor_rate" type="number" step="any"
                                                    value="{{ $labor->amount / $labor->qty }}">
                                                <input type="hidden" name="uom[]" value="0">
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group mt-2 text-center">
                                                <input type="hidden" class="labor_qty_oval" value="{{ $labor->qty }}">
                                                <input class="qty form-control text-center labor_qty" id="labor-qty"
                                                    type="number" step="any" name="qty[]" oninput="totalQty('0')"
                                                    value="{{ $labor->qty }}" required readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group mt-2 text-center">
                                                <input id="labor-amount" class="amount form-control text-center"
                                                    type="number" step="any" name="amount[]" oninput="totalAmount('0')"
                                                    value="{{ $labor->amount }}" required>
                                            </div>
                                        </div>

                                    </div>
                                    {{-- labor end --}}


                                    {{-- other cash start --}}

                                    @foreach ($data->projectwisebudget->items as $item)
                                    @php
                                    if($item->budgetHead->type == 'Material'){
                                    continue;
                                    }

                                    if($item->budget_head == 6){
                                    continue;
                                    }
                                    @endphp
                                    <div class="row permanent_product_qty mt-2"
                                        id="itemRow_{{ $item->budgetHead->id + 1000 }}">

                                        <div class="col-md-5 px-0">
                                            <div class="form-group mt-2">
                                                <input type="text" class="form-control"
                                                    value="{{ $item->budgetHead->name }}" disabled>
                                                <input type="hidden" name="material_id[]"
                                                    value="{{ $item->budgetHead->id }}">
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group mt-2 text-center">
                                                <input
                                                    class="rate form-control text-center {{ $item->budgetHead->id + 1000 }}_rate"
                                                    type="number" step="any" value="{{ $item->amount / $item->qty }}"
                                                    sl="{{ $item->budgetHead->id + 1000 }}">
                                                <input type="hidden" name="uom[]" value="0">
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group mt-2 text-center">
                                                <input type="hidden" class="{{ $item->budgetHead->id + 1000 }}_qty_oval"
                                                    value="{{ $item->qty }}">
                                                <input class="qty form-control text-center" type="number" step="any" name="qty[]"
                                                    oninput="totalQty('{{ $item->qty }}')" value="{{ $item->qty }}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group mt-2 text-center">
                                                <input class="amount form-control text-center" type="number" step="any"
                                                    name="amount[]" oninput="totalAmount('{{ $item->amount }}')"
                                                    value="{{ $item->amount }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-1 mt-2 pr-0">
                                            <button class="btn btn-danger" style="margin-left: 10px;"
                                                onclick="itemRemove('{{ $item->id }}')">
                                                <i class="fa fa-trash" aria-hidden="true" style="font-size: 20px"></i>
                                            </button>
                                        </div>

                                    </div>
                                    @endforeach

                                    {{-- other cash end --}}

                                </div>
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
            <option value="">Select Item</option>
            <?php
                foreach ($data->budgetheads->where('type', 'Material') as $budgethead)
                {
            ?>
            <option value="{{$budgethead->id}}">{{$budgethead->name}}</option>
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


{{-- update amount on self defined head start --}}
<script>
    function updateCostAmount(class_name){
        let amount = +$('.' + class_name + '_rate').val() * +$('.' + class_name + '_qty').val();

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

        let projectId = $('#project_id').val();


        // fetch tower start
        axios.get(route('projectwise.tower', projectId))
            .then(function (response) {

            const data = response.data.project_towers;

            let options = `<option value="">Select An Option</option>`;

            data.forEach(el => {

                let selected = "";

                if(el.id == '{{ $data->newTower }}'){
                    selected = "selected";
                }

                let option = `<option value="${el.id}" ${selected}>${el.name}</option>`;

                options += option;

            });


            $('#tower').html(options);
            $('#tower_inherit').html(options);


        })
        .catch(function (error) {
        })
        // fetch tower end
    }


    $(document).ready(function () {

        getProjectTower();

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

            let projectType = $('#project_id').attr('pt');

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

                    let option = `<option value="${el.id}" unitid="${el.unit_id}" pile_length="${el.pile_length}" length="${el.length}" width="${el.width}" height="${el.height}" cementqty="${el.cement_qty}" cementunit="${static_materials[0].material_unit.name}" sandqty="${el.sand_qty}" sandunit="${static_materials[1].material_unit.name}" stoneqty="${el.stone_qty}" stoneunit="${static_materials[2].material_unit.name}" >${el.unit_name}</option>`;

                    options += option;

                });


                $('#unit_config_id').html(options);
                $('#unit_config_id_inherit').html(options);


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

            const unitEstimationEl =  $('#unit_config_id');
            const unitId =  +unitEstimationEl.attr('unitid');

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

                let cft = Math.round(calculateCftOfCap(cube))

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

            <div class="row">

                <div class="col-md-5 px-0">
                    <div class="form-group mt-2">
                        <select class="form-control chosen-select itemList_${total} budgethead_${total}" name="material_id[]"
                            required="" onchange="budgetHeadChanged(${total})">
                            <option value=" ">Select Item</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group mt-2 text-center">
                        <input style="text-align: right;" class="rate form-control text-center ${total}_rate"
                            id="rate" type="number" step="any" name="rate[]" min="1" oninput="updateCostAmount('${total}')" sl="${total}" value="1">
                        <input type="hidden" name="uom[]" value="0">
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group mt-2 text-center">
                        <input type="hidden" class="${total}_qty_oval">
                        <input class="qty qty_${total} ${total}_qty form-control text-center" type="number" step="any"
                            name="qty[]" oninput="updateCostAmount('${total}');updateQtyOval('${total}')" min="1" value="0" required>
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group mt-2 text-center">
                        <input class="amount amount_${total} form-control ${total}_amount text-center" type="number" step="any"
                            name="amount[]" oninput="totalAmount('${total}')" value="0" min="1" required>
                    </div>
                </div>


                <div class="col-md-1 mt-2 pr-0">
                    <button class="btn btn-danger" style="margin-left: 10px;" onclick="itemRemove(${total})">
                        <i class="fa fa-trash" aria-hidden="true" style="font-size: 20px"></i>
                    </button>
                </div>


            </div>

        </div>
        `;

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

            <div class="row">

                <div class="col-md-5 px-0">
                    <div class="form-group mt-2">
                        <select class="form-control chosen-select itemList_${total} budgethead_${total}" name="material_id[]"
                            required="" onchange="budgetHeadChanged(${total})">
                            <option value=" ">Select Item</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group mt-2 text-center">
                        <input style="text-align: right;" class="rate form-control text-center ${total}_rate"
                            id="rate" type="number" step="any" name="rate[]" oninput="updateCostAmount('${total}')"  sl="${total}" value="1">
                        <input type="hidden" name="uom[]" value="0">
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group mt-2 text-center">
                        <input type="hidden" class="${total}_qty_oval">
                        <input class="qty qty_${total} form-control ${total}_qty text-center" type="number" step="any"
                            name="qty[]" value="1" oninput="updateCostAmount('${total}');updateQtyOval('${total}')" required>
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group mt-2 text-center">
                        <input class="amount amount_${total} ${total}_amount form-control text-center" type="number" step="any"
                            name="amount[]" oninput="totalAmount('0')" value="1" required>
                    </div>
                </div>

                <div class="col-md-1 mt-2 pr-0">
                    <button class="btn btn-danger" style="margin-left: 10px;" onclick="itemRemove(${total})">
                        <i class="fa fa-trash" aria-hidden="true" style="font-size: 20px"></i>
                    </button>
                </div>


            </div>

        </div>
        `;

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

@endsection

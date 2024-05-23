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

@include('dashboard.projectwise_budget.partials.modal.new_material_modal')
@include('dashboard.projectwise_budget.partials.modal.new_budgetHead_modal')
@include('dashboard.projectwise_budget.partials.modal.roa_details_modal')

<form action="{{ route('projectwisebudget.update', $data->projectwisebudget->id) }}" method="POST">
    @csrf
    @method('patch')

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

                    <div class="col-md-3">
                        <div class="row">

                            @include('dashboard.layouts.partials.company_dropdown', [
                            'columnClass'=> 'col-md-12',
                            'company_id' => $data->projectwisebudget->company_id,
                            ])

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="project_id">Project</label>
                                    <input type="text" class="form-control"
                                        value="{{ $data->projectwisebudget->project->project_name }}" readonly>
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

                            <div class="col-md-12 project_type_tower">
                                <div class="form-group">
                                    <label for="tower">Tower</label>
                                    <input type="text" class="form-control" name="tower" id="tower"
                                        value="{{ $data->projectwisebudget?->tower?->name }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6 project_type_tower">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date"
                                        value="{{ $data->projectwisebudget->start_date }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6 project_type_tower">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date"
                                        value="{{ $data->projectwisebudget->end_date }}" disabled>
                                </div>
                            </div>
                            @endif

                            @php
                            $unitConfig = $data->projectwisebudget->unitConfig;

                            // dd($unitConfig);
                            @endphp

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unit_config">Unit Config</label>
                                    <input type="text" class="form-control" id="unit_config"
                                        value="{{ $data->projectwisebudget->unitConfig->unit_name }}" readonly>

                                    <input type="hidden" name="unit_config_id" id="unit_config_id"
                                        value="{{ $data->projectwisebudget->unitConfig->id }}"
                                        unitid="{{ $unitConfig->unit_id }}" pile_length="{{ $unitConfig->pile_length }}"
                                        dia="{{ $unitConfig->dia }}" length="{{ $unitConfig->length }}"
                                        width="{{ $unitConfig->width }}" height="{{ $unitConfig->height }}"
                                        cementqty="{{ $unitConfig->cement_qty }}" sandqty="{{ $unitConfig->sand_qty }}"
                                        stoneqty="{{ $unitConfig->stone_qty }}">

                                </div>
                            </div>


                            <div class="col-md-6 form">
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
                                    <input type="text" class="form-control text-center" id="undefined"
                                        value="{{ $longOrVolume }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_of_pile">Piles Qty</label>
                                    <input type="text" name="number_of_pile" id="number_of_pile"
                                        class="form-control text-center" onkeyup="onNumberOfPileUpdate()"
                                        value="{{ $data->projectwisebudget->number_of_pile }}" required>
                                </div>
                            </div>

                            <div class="col-md-12 col-6">
                                <div class="form-group text-center">
                                    <label for="">Total Amount</label>
                                    <input class="total_amount form-control text-center mt-2" type="number" step="any"
                                        name="total_amount" value="0" readonly>
                                </div>
                            </div>

                            @php

                            @endphp

                            <div class="col-md-12 col-6">
                                <div class="form-group  text-center">
                                    <label for="volume">Volume</label>
                                    <input type="text" class="form-control text-center" name="volume" id="volume"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-12 col-6 d-none">
                                <div class="form-group text-center">
                                    <label for="">Total Qty</label>
                                    <input class="total_qty form-control text-center mt-2" type="number" step="any"
                                        name="total_qty" value="0" readonly>
                                </div>

                            </div>

                            <div class="col-md-12 col-6">
                                <span class="btn btn-block btn-success" style="margin-top: 28px;" data-toggle="modal"
                                    data-target="#budgetHeadModal">
                                    New Cost
                                </span>
                            </div>

                            <div class="col-md-12 col-6">
                                <span class="btn btn-block btn-success" style="margin-top: 28px;" data-toggle="modal"
                                    data-target="#newMaterialModal">
                                    New Material
                                </span>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-9">

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

                                @php
                                $cement = $data->projectwisebudget->items->where('budget_head', 3)->first();
                                @endphp

                                <div class="col-md-5 px-0">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="Cement (Bosta)" disabled>
                                        <input type="hidden" name="material_id[]" value="3">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input step="any" style="text-align: right;"
                                            class="rate form-control text-center 1_rate" sl="1" id="rate" type="number"
                                            step="any" name="rate[]" oninput="updateCostAmount('1');updateQtyOval('1')"
                                            value="{{ round($cement->amount / $cement->qty, 2) }}">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>


                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input type="hidden" class="1_qty_oval" value="{{ $cement->qty }}">
                                        <input class="qty form-control text-center 1_qty" type="number" step="any"
                                            id="cement-qty" name="qty[]" oninput="updateCostAmount('1')"
                                            value="{{ $cement->qty }}" readonly required>
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input class="amount form-control 1_amount text-center" type="number" step="any"
                                            name="amount[]" oninput="totalAmount('0')" value="{{ $cement->amount }}"
                                            required>
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
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="Sand (CFT)" disabled>
                                        <input type="hidden" name="material_id[]" value="4">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input step="any" style="text-align: right;"
                                            class="rate form-control text-center 2_rate" sl="2" id="rate" type="number"
                                            step="any" name="rate[]" oninput="updateCostAmount('2');updateQtyOval('2')"
                                            value="{{ round($sand->amount / $sand->qty, 2) }}">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input type="hidden" class="2_qty_oval" value="{{ $sand->qty }}">
                                        <input class="qty form-control 2_qty text-center" id="sand-qty" type="number"
                                            step="any" name="qty[]" oninput="updateCostAmount('2')"
                                            value="{{ $sand->qty }}" readonly required>
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
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
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="Stone (CFT)" disabled>
                                        <input type="hidden" name="material_id[]" value="5">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input step="any" style="text-align: right;"
                                            class="rate form-control text-center 3_rate" sl="3" id="rate" type="number"
                                            step="any" name="rate[]" oninput="updateCostAmount('3');updateQtyOval('3')"
                                            value="{{ round($stone->amount / $stone->qty) }}">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input type="hidden" class="3_qty_oval" value="{{ $stone->qty }}">
                                        <input class="qty form-control 3_qty text-center" id="stone-qty" type="number"
                                            step="any" name="qty[]" oninput="updateCostAmount('3')"
                                            value="{{ $stone->qty }}" readonly required>
                                    </div>
                                </div>


                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input class="amount form-control 3_amount text-center" type="number" step="any"
                                            oninput="totalAmount('0')" value="{{ $stone->amount }}" name="amount[]"
                                            required>
                                    </div>
                                </div>
                                <input type="hidden" class="row_count" value="4">

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


                            <div class="row permanent_product_qty mt-2" id="itemRow_{{ $item ->id}}">

                                <div class="col-md-5 px-0">
                                    <div class="form-group">
                                        <input type="text" class="form-control"
                                            value="{{ $item->budgetHead->name }} ({{ $item->budgetHead->materialInfo()->materialUnit->name }})"
                                            disabled>
                                        <input type="hidden" name="material_id[]" value="{{ $item->budgetHead->id }}">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input step="any" style="text-align: right;"
                                            class="rate form-control text-center {{ $item->budgetHead->id+1000 }}_rate"
                                            id="rate" type="number" step="any" sl="{{ $item->budgetHead->id+1000 }}" name="rate[]"
                                            oninput="updateCostAmount('{{ $item->budgetHead->id+1000 }}');updateQtyOval('{{ $item->budgetHead->id+1000 }}')"
                                            value="{{ round($item->amount / $item->qty, 2) }}">
                                        <input type="hidden" name="uom[]" value="0">
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input type="hidden" class="{{ $item->budgetHead->id+1000 }}_qty_oval" value="{{ $item->qty }}">
                                        <input class="qty form-control text-center {{ $item->budgetHead->id+1000 }}_qty"
                                            type="number" step="any" name="qty[]"
                                            oninput="updateCostAmount('{{ $item->budgetHead->id+1000 }}');updateQtyOval('{{ $item->budgetHead->id+1000 }}')"
                                            value="{{ $item->qty }}" required>
                                    </div>
                                </div>

                                <div class="col-md-2 col-6 pr-0">
                                    <div class="form-group text-center">
                                        <input
                                            class="amount form-control text-center {{ $item->budgetHead->id+1000 }}_amount"
                                            type="number" step="any" oninput="totalAmount('{{ $item->amount }}')"
                                            value="{{ $item->amount }}" name="amount[]" required>
                                    </div>
                                </div>

                                <div class="col-md-1">
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

                                    {{-- roa start --}}

                                    <div class="row permanent_product_qty mt-2">
                                        <div class="col-md-5 px-0">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="ROA Cost" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group text-center">
                                                <input style="text-align: right;" class="form-control text-center"
                                                    type="number" step="any" value="0" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group text-center">
                                                <input class="form-control text-center" type="number" step="any"
                                                    value="{{ $data->projectBudgetWiseRoa->count() }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group text-center">
                                                <input class="form-control text-center" type="number" step="any"
                                                    value="{{ $data->projectBudgetWiseRoa->sum('total') }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-1 pr-0">
                                            <span class="btn btn-block btn-success" data-toggle="modal"
                                                data-target="#RoaDetails">
                                                <i class="fa fa-list" aria-hidden="true"></i>
                                            </span>
                                        </div>

                                    </div>

                                    {{-- roa end --}}

                                    {{-- labor start --}}
                                    <div class="row permanent_product_qty mt-2">

                                        @php
                                        $labor = $data->projectwisebudget->items->where('budget_head', 6)->first();
                                        @endphp

                                        <div class="col-md-5 px-0">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="Rig Labor Cost" disabled>
                                                <input type="hidden" name="material_id[]" value="6">
                                            </div>
                                        </div>


                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group text-center">
                                                <input class="rate form-control text-center labor_rate" id="labor_rate"
                                                    oninput="updateCostAmount('labor');updateQtyOval('labor')"
                                                    type="number" step="any"  sl="labor" value="{{ $labor->amount / $labor->qty }}">
                                                <input type="hidden" name="uom[]" value="0">
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group text-center">
                                                <input type="hidden" class="labor_qty_oval" value="{{ $labor->qty }}">
                                                <input class="qty form-control text-center" id="labor-qty" type="number"
                                                    step="any" name="qty[]" oninput="totalQty('0');updateQtyOval('labor')"
                                                    value="{{ $labor->qty }}" required readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group text-center">
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
                                    <div class="row permanent_product_qty mt-2" id="itemRow_{{ $item->id }}">

                                        <div class="col-md-5 px-0">
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    value="{{ $item->budgetHead->name }}" disabled>
                                                <input type="hidden" name="material_id[]"
                                                    value="{{ $item->budgetHead->id }}">
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group  text-center">
                                                <input class="rate form-control text-center" sl="{{ $item->budgetHead->id }}" type="number" step="any"
                                                    value="{{ $item->amount / $item->qty }}">
                                                <input type="hidden" name="uom[]" value="0">
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group text-center">
                                                <input type="hidden" class="qty_qty_oval" value="{{ $item->qty }}">
                                                <input class="qty form-control text-center" type="number" step="any"
                                                    name="qty[]" oninput="totalQty('{{ $item->qty }}')"
                                                    value="{{ $item->qty }}" required readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-6 pr-0">
                                            <div class="form-group text-center">
                                                <input class="amount form-control text-center" type="number" step="any"
                                                    name="amount[]" oninput="totalAmount('{{ $item->amount }}')"
                                                    value="{{ $item->amount }}" required>
                                            </div>
                                        </div>


                                        <div class="col-md-1 pr-0">
                                            {{-- <button type="button" class="btn btn-primary"
                                                onclick="addNewItemOtherCost()" style="margin-top: 29px;">
                                                <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i>
                                            </button> --}}
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

{{-- c3, cft calculation --}}
<script src="{{ asset('js/unit_estimation/footing_work_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/brick_soling_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/cap_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/pile_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/pluster_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/sand_filling_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/tiles_calculation.js') }}"></script>
<script src="{{ asset('js/unit_estimation/wall_calculation.js') }}"></script>

{{-- calculate on unit --}}
<script>
    function updateUnitConfigVolume(){

        let cube = 0;
        let unitEstimationEl =  $('#unit_config_id');
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

        $('#volume').val(cube);

    }


    $(document).ready(function () {
        updateUnitConfigVolume();
    });
</script>
{{-- inherit start --}}

{{-- update amount on self defined head start --}}
<script>
    function updateCostAmount(class_name){
        let amount = +$('.' + class_name + '_rate').val() * +$('.' + class_name + '_qty').val();

        $('.' + class_name + '_amount').val(amount);

        row_sum();
    }
</script>
{{-- update amount on self defined head end --}}

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

            axios.get(route('projectWiseUnits', projectId))
            .then(function (response) {

                const data = response.data.unit_config;

                let options = `<option value="">Select An Option</option>`;

                data.forEach(el => {

                    let option = `<option value="${el.id}" unitid="${el.unit_id}" pile_length="${el.pile_length}" length="${el.length}" width="${el.width}" height="${el.height}" cementqty="${el.cement_qty}" sandqty="${el.sand_qty}" stoneqty="${el.stone_qty}">${el.unit_name}</option>`;

                    options += option;

                });


                $('#unit_id').html(options);


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

        let m3 = (cube.length * cube.height * cube.width) * 1.54;
        let cft = m3 * 35.32;
        return cft

    }

    function updateQtyOval(class_name) {

        let qty = +$('.' + class_name + '_qty').val();
        $('.' + class_name + '_qty_oval').val(qty);

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

            console.log(rate, qty, number_of_pile);
            // console.log(newQty, amount);


            $('.' + class_name + '_qty').val(newQty);
            $('.' + class_name + '_amount').val(amount);

        });

        row_sum();

        }

    $(document).ready(function () {

        $('.cement_uom').chosen().chosenReadonly();
        $('.sand_uom').chosen().chosenReadonly();
        $('.stone_uom').chosen().chosenReadonly();

        row_sum();

        $('#unit_id').change(function (e) {
            e.preventDefault();

            hideUnitDependentInputs();

            const unitEstimationEl =  $('#unit_id option:selected');
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

            forms.removeClass('d-none');


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

            row_sum();

        });


        // $('#number_of_pile').keyup(function (e){

        //     const unitEstimationEl =  $('#unit_id option:selected');
        //     let number_of_pile = +$('#number_of_pile').val();
        //     let pile_length =  +unitEstimationEl.attr('pile_length');


        //     let cementQty =  number_of_pile * +unitEstimationEl.attr('cementqty');
        //     let sandQty =  number_of_pile * +unitEstimationEl.attr('sandqty');
        //     let stoneQty =  number_of_pile * +unitEstimationEl.attr('stoneqty');

        //     $('#cement-qty').val(cementQty);
        //     $('#sand-qty').val(sandQty);
        //     $('#stone-qty').val(stoneQty);


        //     let cube = {
        //             'length' : +unitEstimationEl.attr('length') / 1000,
        //             'width' : +unitEstimationEl.attr('width') / 1000,
        //             'height' : +unitEstimationEl.attr('height') / 1000,
        //     }

        //     let laborQty = 0;
        //     let unitId = unitEstimationEl.val();

        //     if(unitId == 8){
        //         laborQty = pile_length * number_of_pile;

        //     }
        //     if(unitId == 9){
        //         let cft = Math.round(calculateCftOfCap(cube))
        //         laborQty = cft * number_of_pile;
        //     }

        //     $('#labor-qty').val(laborQty);

        //     row_sum();

        // });


        $('#labor_rate').keyup(function (e) {
            e.preventDefault();

            let amount = +$('#labor_rate').val() * +$('#labor-qty').val();

            $('#labor-amount').val(amount);

            row_sum();

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
        <div class="col-md-12  mt-2" id="itemRow_${total}">

            <div class="row">

                <div class="col-md-5 px-0">
                    <div class="form-group">
                        <select class="form-control chosen-select itemList_${total} budgethead_${total}" name="material_id[]"
                            required="" onchange="budgetHeadChanged(${total})">
                            <option value=" ">Select Item</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group text-center">
                        <input style="text-align: right;" class="rate form-control text-center ${total}_rate"
                            id="rate" type="number" step="any" name="rate[]" oninput="updateCostAmount('${total}');updateQtyOval('${total}')" sl="${total}" value="1">
                        <input type="hidden" name="uom[]" value="0">
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group text-center">
                        <input type="hidden" class="${total}_qty_oval" value="{{ $item->qty }}">
                        <input class="qty qty_${total} form-control ${total}_qty text-center" type="number" step="any"
                            name="qty[]" oninput="updateCostAmount('${total}');updateQtyOval('${total}')" value="0" required>
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group text-center">
                        <input class="text-center amount amount_${total} form-control ${total}_amount" type="number" step="any"
                            name="amount[]" oninput="totalAmount('0')" value="0" required>
                    </div>
                </div>

                <div class="col-md-1 pr-0">
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
        <div class="col-md-12  mt-2" id="itemRow_${total}">

            <div class="row">

                <div class="col-md-5 px-0">
                    <div class="form-group">
                        <select class="form-control chosen-select itemList_${total} budgethead_${total}" name="material_id[]"
                            required="" onchange="budgetHeadChanged(${total})">
                            <option value=" ">Select Item</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group text-center">
                        <input style="text-align: right;" class="rate form-control text-center ${total}_rate"
                            id="rate" type="number" step="any" name="rate[]" oninput="updateCostAmount('${total}');updateQtyOval('${total}')" sl="${total}" value="1">
                        <input type="hidden" name="uom[]" value="0">
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group text-center">
                        <input type="hidden" class="${total}_qty_oval">
                        <input class="qty qty_${total} form-control ${total}_qty text-center" type="number" step="any"
                            name="qty[]" value="1" oninput="updateCostAmount('${total}');updateQtyOval('${total}')" required>
                    </div>
                </div>

                <div class="col-md-2 col-6 pr-0">
                    <div class="form-group text-center">
                        <input class="amount amount_${total} ${total}_amount form-control text-center" type="number" step="any"
                            name="amount[]" oninput="totalAmount('0')" value="1" required>
                    </div>
                </div>

                <div class="col-md-1 pr-0">
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

    function totalQty(i) {
        row_sum();
    }

    function row_sum(){
        var total_amount = 0;
        var total_qty = 0;


        $(".qty").each(function () {
            var stvalQty = +parseFloat($(this).val());
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

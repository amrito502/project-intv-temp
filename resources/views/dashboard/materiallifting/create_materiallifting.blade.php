@extends('dashboard.layouts.app')

@section('custom-css')
<style>
    /* .table tfoot th {
        background-color: #fff;
    } */
</style>
@endsection

@section('content')
@include('dashboard.layouts.partials.error')

@include('dashboard.projectwise_budget.partials.modal.new_material_modal')



<form method="POST" action="{{ route('materiallifting.store') }}" enctype="multipart/form-data">
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

                    @include('dashboard.layouts.partials.company_dropdown', [
                    'columnClass'=> 'col-md-3',
                    'company_id' => 0,
                    ])

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="system_serial">System Serial</label>
                            <input type="text" id="system_serial" class="form-control"
                                value="{{ $data->system_serial }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lifting_type">Lifting Type</label>
                            <select name="lifting_type" id="lifting_type" class="select2" required>
                                <option value="Client Provide To Project">Client Provide To Project</option>
                                <option value="Client Provide To Central Store">Client Provide To Central Store</option>
                                <option value="Local Lifting To Project">Local Lifting To Project</option>
                                <option value="Product Lifting To Central Store">Product Lifting To Central Store
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date">Voucher Date</label>
                            <input type="text" id="date" name="voucher_date" class="form-control datepicker"
                                autocomplete="off" value="{{ date('d-m-Y', time()) }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <span class="btn btn-block btn-success" style="margin-top: 28px;" data-toggle="modal"
                            data-target="#newMaterialModal">
                            New Material
                        </span>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select name="project" id="project" class="select2">
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="unit">Unit</label>
                            <select class="select2" name="unit" id="unit">
                                <option value="">Select Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <select class="select2" name="tower" id="tower">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lifting_files">Lifting files</label>
                            <input type="file" id="lifting_files" name="lifting_files[]" class="form-control" multiple>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select name="vendor" id="vendor" class="select2" readonly="true">
                                <option value="">Select Vendor</option>
                                @foreach ($data->vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="voucher_no">Voucher No</label>
                            <input type="text" id="voucher_no" name="voucher" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="logistics_associate">Logistics Associate</label>
                            <select name="logistics_associate" id="logistics_associate" class="select2" readonly="true">
                                <option value="">Select Vendor</option>
                                @foreach ($data->logistics_vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="truck_no">Truck No</label>
                            <input type="text" id="truck_no" name="truck_no" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="row material_table">
                    <div class="col-md-12">
                        <div style="overflow-x: auto;height: 500px">
                            <table class="table gridTable mobile-changes" style="overflow-y: auto">
                                <thead>
                                    <tr>
                                        <th style="width: 450px;">Material Name</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Rate</th>
                                        <th class="text-center">Amount</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody">
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>
                                            <p class='text-right mb-0 mt-2'>Total Quantity</p>
                                        </th>
                                        <th>
                                            <input class="total_qty form-control text-center" type="number" step="any"
                                                name="total_qty" value="0" readonly>
                                        </th>
                                        <th>
                                            <p class='text-right mb-0 mt-2'>Total Amount</p>
                                        </th>
                                        <th>
                                            <input class="total_amount form-control text-center" type="number" step="any"
                                                name="total_amount" value="0" readonly>

                                            <input type="hidden" class="row_count" value="1">

                                        </th>
                                        <th colspan="2"></th>

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
            <option value=" ">Select Item</option>
            <?php
                foreach ($data->materials as $material)
                {
            ?>
            <option value="{{$material->id}}">{{$material->name}} ({{$material->code}}) / {{
                $material->materialUnit->name }}</option>
            <?php
                }
            ?>
        </select>
    </div>
</div>

{{-- <div id="unitList" style="display:none">
    <div class="input select">
        <select>
            <option value=" ">Select UOM</option>
            <?php
                foreach ($data->units as $unit)
                {
            ?>
            <option value="{{$unit->id}}">{{$unit->name}}</option>
            <?php
                }
            ?>
        </select>
    </div>
</div> --}}
@endsection

@section('custom-script')

<script type="text/javascript">
    function addItem() {
        var row_count = $('.row_count').val();
        var total = parseInt(row_count) + 1;

        let rate_attr = '';
        let liftingType = $('#lifting_type').val();

        @if(!auth()->user()->hasRole(['Software Admin', 'Company Admin']))

        if(['Client Provide To Project', 'Client Provide To Central Store'].includes(liftingType)){
            rate_attr = 'readonly'
        }

        @endif

        // console.log(row_count);
        let deleteBtn = '';
        if(row_count > 1){
            deleteBtn = `<span class="btn btn-danger item_remove" onclick="itemRemove(${total})"><i class="fa fa-trash" style="font-size: 20px"></i> </span>`;
        }

        $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
            '<td class="pl-0">'+
            '<select name="material_id[]" onchange="updateItemRow(event, ' + total + ')" class="form-control chosen-select itemList itemList_'+total+'">'+
            '</select>'+
            '</td>'+
            '<td><input style="text-align: center;" class="form-control qty qty_'+total+'" type="number" step="any" name="qty[]" value="1" required oninput="totalAmount('+total+')"></td>'+
            '<td><input style="text-align: center;" class="form-control rate_'+total+'" type="number" step="any" name="rate[]" value="0" required oninput="totalAmount('+total+')" '+ rate_attr +'></td>'+
            '<td><input style="text-align: center;" class="form-control amount amount_'+total+'" type="number" step="any" name="amount[]" value="0" required readonly></td>'+
            '<td><input class="form-control remarks remarks_'+total+'" type="text" name="remarks[]" value=""></td>'+
            '<td><span class="btn btn-success" onclick="addItem()"> <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i> </span>  '+ deleteBtn + ' </td>'+
            '</tr>');
        $('.row_count').val(total);

        var itemList = $("#itemList div select").html();
        $('.itemList_'+total).html(itemList);
        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        // var unitList = $("#unitList div select").html();
        // $('.unitList_'+total).html(unitList);
        // $('.chosen-select').chosen();
        // $('.chosen-select').trigger("chosen:updated");

        row_sum();
    }

    $(".add_item").click(function () {
        addItem();
    });

    function itemRemove(i) {
        var total_qty = $('.total_qty').val();
        var total_amount = $('.total_amount').val();

        var quantity = $('.qty_'+i).val();
        var amount = $('.amount_'+i).val();

        total_qty = total_qty - quantity;
        total_amount = total_amount - amount;

        $('.total_qty').val(total_qty.toFixed(2));
        $('.total_amount').val(total_amount.toFixed(2));

        $("#itemRow_" + i).remove();
    }

    function totalAmount(i){
        var qty = $(".qty_" + i).val();
        var rate = $(".rate_" + i).val();
        var sum_total = parseFloat(qty) *parseFloat(rate);
        $(".amount_" + i).val(sum_total.toFixed(2));
        row_sum();
    }

    function row_sum(){
        var total_qty = 0;
        var total_amount = 0;
        $(".qty").each(function () {
            var stvalTotal = parseFloat($(this).val());
            // console.log(stval);
            total_qty += isNaN(stvalTotal) ? 0 : stvalTotal;
        });

        $(".amount").each(function () {
            var stvalAmount = parseFloat($(this).val());
            // console.log(stval);
            total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
        });

        $('.total_qty').val(total_qty.toFixed(2));
        $('.total_amount').val(total_amount.toFixed(2));
    }

    // function getProjectWiseMaterials(){

    //     let projectId = $('#project').val();

    //     axios.get(route('projectWiseMaterial', projectId))
    //     .then(function (response) {

    //         let data = response.data;

    //     let options = '<option value="">Select Option</option>';

    //     data.forEach(element => {
    //             let option = `<option value="${element.id}">${element.name}(${element.code})</option>`;

    //             options += option;
    //     });

    //     $('#itemList .input select').html('');
    //     $('#itemList .input select').html(options);

    //     })
    //     .catch(function (error) {
    //     })

    // }

    function toggleLiftingMaterialTableVisibility(){
        let projectId = $('#project').val();

        if(projectId != ''){
            $('.material_table').show();
        }
        else{
            $('.material_table').hide();
        }

    }


    $(function () {

        addItem();
    });
</script>

<script>
    function updateItemRow(e, rowId) {

        // let changeInputVal = +$(e.target).val();

        // axios.get(route('budgetHeadToMaterialInfo', changeInputVal))
        // .then(function (response) {
        //     let data = response.data;

        //     $('.unitList_' + rowId).val(data.unit);
        //     $('.unitList_' + rowId).trigger("chosen:updated");

        //     // $('.cement_uom').chosen().chosenReadonly();

        //     $('.unitList_' + rowId).chosen().chosenReadonly();

        // })
        // .catch(function (error) {
        // })

        // console.log(changeInputVal, rowId);
    }
</script>

<script>
    function updateInputStateOnLiftingType(){

        let liftingType = $('#lifting_type').val();

        switch(liftingType) {

            case 'Client Provide To Project':
                $("#vendor").select2({disabled:'readonly'});
                $("#project").select2({disabled:''});
                // $('.material_table').hide();
                break;

            case 'Local Lifting To Project':
                $("#vendor").select2({disabled:''});
                $("#project").select2({disabled:''});
                // $('.material_table').hide();
            break;

            case 'Product Lifting To Central Store':
                $("#vendor").select2({disabled:''});
                $("#project").select2({disabled:'readonly'});
                // $('.material_table').show();
                break;

            case 'Client Provide To Central Store':
                $("#vendor").select2({disabled:'readonly'});
                $("#project").select2({disabled:'readonly'});
                // $('.material_table').show();
                break;

        }

    }

    $(document).ready(function () {

        updateInputStateOnLiftingType();

        $('#lifting_type').change(function (e) {
            e.preventDefault();

            updateInputStateOnLiftingType();

        });

    });

</script>

<script>
    $(document).ready(function () {

        $('#project').change(function (e) {
            e.preventDefault();

            const projectId = +$(this).val();

            if(projectId == ''){
                $('#unit').html('');
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

                $('#unit').html(options);

            })
            .catch(function (error) {
            })
            // fetch unit end

            toggleLiftingMaterialTableVisibility();

            getProjectTower(projectId);

        });
    });

</script>

<script>
    function getProjectTower(projectId){


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
</script>

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

                let option = `<option value="${rData.id}">${rData.name}</option>`;

                $("#itemList div select").append(option);

                $('.itemList').each(function(i, el){

                    let El = $(el);

                    var option = new Option(rData.name, rData.id);
                    El.append(option);

                    El.trigger("chosen:updated");
                    El.trigger("liszt:updated");

                });

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

@extends('dashboard.layouts.app')

@section('content')
    <form method="POST" action="{{ route('dailyuses.store') }}">
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
                <div class="row">
                    @include('dashboard.layouts.partials.company_dropdown', [
                        'columnClass' => 'col-md-3',
                        'company_id' => 0,
                    ])
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="system_serial">System Serial</label>
                            <input type="text" name="system_serial" class="form-control"
                                value="{{ $data->system_serial }}" required readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select name="project" id="project" class="select2" required>
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                    <option value="{{ $project->id }}" ptype="{{ $project->project_type }}"
                                        @if (request()->project == $project->id) selected @endif>{{ $project->project_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="unit_ids">Unit</label>
                            <select class="select2" name="unit_id" id="unit_ids" required>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <select class="select2" name="tower" id="tower">
                                <option value="">Select Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pile_no">Pile No</label>
                            <input type="text" id="pile_no" name="pile_no" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Working Length</label>
                            <input type="text" id="working_length" name="working_length" class="form-control">
                            <input type="hidden" id="original_working_length">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="site_engineer">Site Engineer</label>
                            <input type="text" id="site_engineer" name="site_engineer" class="form-control">
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


                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="epc_engineer">EPC Engineer</label>
                            <input type="text" id="epc_engineer" name="epc_engineer" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="department_engineer">Department Engineer</label>
                            <input type="text" id="department_engineer" name="department_engineer"
                                class="form-control">
                        </div>
                    </div>


                </div>

                <div class="row d-none" id="autoCalculateParent">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit_config_id">Unit Config</label>
                            <select class="select2" name="unit_config_id[]" id="unit_config_id">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row dynamic-form">

                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 budgethead-table-here">
                        <input type="hidden" class="row_count" value="1">
                        <div style="overflow-x: auto; max-height: 500px">
                            <table class="table gridTable d-none mobile-changes">
                                <thead>
                                    <tr>
                                        <th width="350px">Material Name & Code</th>
                                        <th width="300px" class="d-none">UOM</th>
                                        <th width="150px" class="text-center">Stock Qty</th>
                                        <th width="150px" class="text-center">Design Qty</th>
                                        <th width="150px" class="text-center">Use Qty</th>
                                        <th width="150px" class="text-center">Design Diff</th>
                                        <th width="380px" class="">Remarks</th>
                                        <th width="120px" class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody">
                                </tbody>
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
        <div class="input select budgetheadlist">
            <select>
                <option value="">Select Item</option>
            </select>
        </div>
    </div>

    <div id="unitList" style="display:none">
        <div class="input select">
            <select>
                <option value=" ">Select UOM</option>
                <?php
                foreach ($data->units as $unit)
                {
            ?>
                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                <?php
                }
            ?>
            </select>
        </div>
    </div>
@endsection

@section('custom-script')
    {{-- autoCalculateToggle start --}}

    <script>
        $(document).ready(function() {


            $('#unit_ids').change(function(e) {
                e.preventDefault();

                const unitId = +$(this).val();
                const projectId = +$('#project').val();

                if (unitId == '') {
                    $('#unit_config_id').html('');
                    return false;
                }

                axios.get(route('project.unit.config', [projectId, unitId]))
                    .then(function(response) {

                        const data = response.data.unit_config;
                        let static_materials = response.data.static_material_info;

                        let options = `<option value="">Select An Option</option>`;

                        data.forEach(el => {

                            let option =
                                `<option value="${el.id}" unitid="${el.unit_id}" pile_length="${el.pile_length}" length="${el.length}" width="${el.width}" height="${el.height}" cementqty="${el.cement_qty}" cementunit="${static_materials[0].material_unit.name}" sandqty="${el.sand_qty}" sandunit="${static_materials[1].material_unit.name}" stoneqty="${el.stone_qty}" stoneunit="${static_materials[2].material_unit.name}" >${el.unit_name}</option>`;

                            options += option;

                        });


                        $('#unit_config_id').html(options);

                    })
                    .catch(function(error) {})

            });

        });
    </script>

    {{-- autoCalculateToggle end --}}


    {{-- projectwise unit start --}}
    <script>
        function getProjectWiseUnit() {
            const projectId = +$('#project').val();
            const projectType = $('#project option:selected').attr('ptype');

            if (projectId == '') {
                $('#unit_ids').html('');
                return false;
            }

            axios.get(route('project.units', projectId))
                .then(function(response) {

                    const data = response.data.project_units;

                    let options = '<option value="">Select Unit</option>';

                    data.forEach(el => {

                        let option = `<option value="${el.unit.id}" >${el.unit.name}</option>`;

                        options += option;

                    });


                    $('#unit_ids').html(options);

                })
                .catch(function(error) {})


            // fetch project towers
            if (projectType == 'tower') {

                axios.get(route('projectwise.tower', projectId))
                    .then(function(response) {

                        const data = response.data.project_towers;

                        let options = '<option value="">Select Tower</option>';

                        data.forEach(el => {

                            let option = `<option value="${el.id}" >${el.name}</option>`;

                            options += option;

                        });


                        $('#tower').html(options);

                    })
                    .catch(function(error) {})

            }

        }

        function getProjectAndUnitWiseBudgetHeads() {
            const projectId = +$('#project').val();
            const unitIds = $('#unit_ids').val();

            if (projectId == '') {
                $('#unit_ids').html('');
                return false;
            }

            if (unitIds == []) {
                return false;
            }


            axios.get(route('projectUnitToMaterials', [projectId, unitIds]))
                .then(function(response) {

                    const data = response.data;

                    let options = `<option value="">Select Item</option>`;


                    $('.budgetheadlist > select').html(data);


                    showTableAndAddRow();

                })
                .catch(function(error) {})

        }

        function showTableAndAddRow() {
            $('.gridTable').removeClass('d-none');
            addItem();
        }


        $(document).ready(function() {


            $('#project').change(function(e) {
                e.preventDefault();

                getProjectWiseUnit();

            });


            $('#unit_ids').change(function(e) {
                e.preventDefault();

                getProjectAndUnitWiseBudgetHeads();

            });

        });
    </script>
    {{-- projectwise unit end --}}


    <script type="text/javascript">
        function addItem(budgetHeadId = null, designQty = 0) {
            var row_count = $('.row_count').val();
            var total = parseInt(row_count) + 1;

            let rate_attr = '';
            let liftingType = $('#lifting_type').val();

            if (['Project wise Company Provide', 'Central Company Provide'].includes(liftingType)) {
                rate_attr = 'readonly'
            }

            $(".gridTable tbody").append(`<tr id="itemRow_${total}">'
            <td class="pl-0">
            <select name="budgetHeadIds[]" onchange="updateItemRow(event, ${total})" class="form-control chosen-select itemList itemList_${total}">
            </select>
            </td>
            <td class="d-none">
            <select name="unit_id[]" class="form-control chosen-select unitList_${total}" required readonly>
            </select>
            </td>
            <td><input class="text-center form-control stock stock_${total}" type="number" step="any" name="stock_balance[]" value="0" readonly></td>
            <td>
                <input class="text-center form-control design_stock design_stock_${total}" iteration="${total}" type="number" step="any" name="design_stock_balance[]" value="${designQty}" readonly>
                <input type="hidden" class="original_design_stock" id="original_design_stock_${total}" value="${designQty}">
            </td>
            <td><input class="text-center form-control qty qty_${total}" type="number" step="any" name="consumption_qty[]" value="0" required oninput="totalAmount(${total})"></td>
            <td><input class="text-center form-control design_balance design_balance_${total}" type="number" step="any" name="design_balance[]" value="0" disabled></td>
            <td><input class="text-center form-control remarks remarks_${total}" type="text" name="remarks[]"></td>
            <td align="center" class="pr-0"><span class="btn btn-success" onclick="addItem()"> <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i> </span> <span class="btn btn-danger item_remove" onclick="itemRemove(${total})"><i class="fa fa-trash" style="font-size: 20px"></i> </span></td>
            </tr>`);
            $('.row_count').val(total);

            var itemList = $("#itemList div select").html();
            $('.itemList_' + total).html(itemList);


            if (budgetHeadId) {
                $('.itemList_' + total).val(budgetHeadId);
            }

            $('.chosen-select').chosen();
            $('.chosen-select').trigger("chosen:updated");


            // var unitList = $("#unitList div select").html();
            // $('.unitList_'+total).html(unitList);
            // $('.chosen-select').chosen();
            // $('.chosen-select').trigger("chosen:updated");

            // row_sum();

            // getBudgetInfo(total);

        }

        $(".add_item").click(function() {
            addItem();
        });

        function itemRemove(i) {
            var total_qty = $('.total_qty').val();
            var total_amount = $('.total_amount').val();

            var quantity = $('.qty_' + i).val();
            var amount = $('.amount_' + i).val();

            total_qty = total_qty - quantity;
            total_amount = total_amount - amount;

            $('.total_qty').val(total_qty.tofixed(2));
            $('.total_amount').val(total_amount.tofixed(2));

            $("#itemRow_" + i).remove();
        }

        function totalAmount(i) {
            var qty = parseFloat($(".qty_" + i).val());
            var designQty = parseFloat($(".design_stock_" + i).val());
            var sum_total = designQty - qty;

            if (sum_total < 0) {
                $('.remarks_' + i).attr('required', true);
            } else {
                $('.remarks_' + i).attr('required', false);
            }

            $(".design_balance_" + i).val(sum_total.tofixed(2));
            // row_sum();
        }
    </script>

    <script>
        function getBudgetInfo(rowId) {

            const materialId = $(`.itemList_${rowId} option:selected`).attr('material-id');
            const budgetHeadId = $(`.itemList_${rowId} option:selected`).val();


            // budgethead stock qty start
            axios.get(route('getProjectMaterialLocalStock'), {
                    params: {
                        project_id: $('#project option:selected').val(),
                        unit_id: $('#unit_ids option:selected').val(),
                        tower_id: $('#tower option:selected').val(),
                        material_id: materialId,
                    }
                })
                .then(function(response) {

                    let data = response.data;

                    $('.stock_' + rowId).val(data.stock_balance);
                    // $('.qty_' + rowId).attr('max', data.stock_balance);

                })
                .catch(function(error) {})
            // budgethead stock qty end


            // budgethead design qty start
            axios.get(route('getProjectMaterialDesignStock'), {
                    params: {
                        project_id: $('#project option:selected').val(),
                        unit_id: $('#unit_ids option:selected').val(),
                        tower_id: $('#tower option:selected').val(),
                        material_id: budgetHeadId,
                    }
                })
                .then(function(response) {
                    let data = response.data;

                    $('.design_stock_' + rowId).val(data);
                    $('#original_design_stock_' + rowId).val(data);

                    $(".design_balance_" + rowId).val(data);

                })
                .catch(function(error) {})



        }

        function updateItemRow(e, rowId) {

            // let changeInputVal = +$(e.target).val();
            // let changeInputText = $(e.target).find("option:selected").text();

            // get material info start
            // axios.get(route('budgetHeadToMaterialByName', changeInputText))
            // .then(function (response) {
            //     let data = response.data;

            //     $('.unitList_' + rowId).val(data.unit);
            //     $('.unitList_' + rowId).trigger("chosen:updated");

            //     // $('.cement_uom').chosen().chosenReadonly();

            //     $('.unitList_' + rowId).chosen().chosenReadonly();

            // })
            // .catch(function (error) {
            // })
            // get material info end


            // get budget info start
            getBudgetInfo(rowId);
            // get budget info end

        }
    </script>


    <script>
        $(document).ready(function() {

            // on tower change get tower material start
            $('#tower').change(function(e) {
                e.preventDefault();

                // on tower change fetch project, unit, towerwise budget materials
                axios.get(route('projectUnitTowerWiseBudget'), {
                        params: {
                            project_id: $('#project option:selected').val(),
                            unit_id: $('#unit_ids option:selected').val(),
                            tower_id: $('#tower option:selected').val(),
                        }
                    })
                    .then(function(response) {

                        itemRemove(2);

                        let data = response.data;

                        // show working length
                        $('#working_length').val(data.projectWiseBudget.long_l);
                        $('#original_working_length').val(data.projectWiseBudget.long_l);

                        let noOfPiles = data.projectWiseBudget.number_of_pile;

                        data.materials.forEach(function(item, index) {

                            let onePileQty = item.qty / noOfPiles;

                            addItem(item.budget_head.id, onePileQty);
                        });

                    })
                    .catch(function(error) {})


            });
            // on tower change get tower material end

            // on working length change start
            $('#working_length').keyup(function(e) {
                e.preventDefault();

                let workingLength = +$('#working_length').val();
                let originalWorkingLength = +$('#original_working_length').val();

                // working length percentage of original working length
                let workingLengthPercentage = (workingLength / originalWorkingLength) * 100;

                workingLengthPercentage = parseFloat(workingLengthPercentage).toFixed(2);

                // loop throught the material design qty
                $('.design_stock').each(function(index, item) {
                    // console.log(item);
                    let iterationNo = +$(item).attr('iteration');
                    // console.log(iterationNo);
                    let originalDesignQty = +$('#original_design_stock_' + iterationNo).val();

                    let newDesignQty = (originalDesignQty / 100) * workingLengthPercentage;

                    $(item).val(newDesignQty.tofixed(2));
                });


            });
            // on working length change end


        });
    </script>
@endsection

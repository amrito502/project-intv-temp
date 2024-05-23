@extends('dashboard.layouts.app')

@section('custom-css')
    <style>
        .table td,
        .table th {
            padding: .75rem .50rem;
        }
    </style>
@endsection

@section('content')
    <form method="POST" action="{{ route('dailyconsumption.store') }}">
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
                        'columnClass' => 'col-md-4',
                        'company_id' => 0,
                    ])
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="system_serial">System Serial</label>
                            <input type="text" name="system_serial" class="form-control"
                                value="{{ $data->system_serial }}" required readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4">
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

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit_ids">Unit</label>
                            <select class="select2" name="unit_id" id="unit_ids" required>
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
                            <label for="logistics_associate">Logistics Associate</label>
                            <select name="logistics_associate" id="logistics_associate" class="select2" readonly="true">
                                <option value="">Select Vendor</option>
                                @foreach ($data->logistics_vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="truck_no">Truck No</label>
                            <input type="text" id="truck_no" name="truck_no" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="issue_by">Issue By</label>
                            <input type="text" id="issue_by" name="issue_by" class="form-control" required>
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
                                        <th>Material Name</th>
                                        <th width="150px" class="text-center">Quantity</th>
                                        <th width="150px" class="text-center">Design Balance</th>
                                        <th width="150px" class="text-center">Stock Balance</th>
                                        <th width="150px" class="text-center">Action</th>
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
                <?php
                foreach ($data->materials as $material)
                {
            ?>
                <option value="{{ $material->id }}">{{ $material->name }} ({{ $material->code }})</option>
                <?php
                }
            ?>
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
        // toggle unit form
        function toggleUnitForm() {

            let selectedId = $('#unit_ids option:selected').val();

            axios.get(route('dailyConsumptionAutoCalculateForm', selectedId))
                .then(function(response) {

                    html = response.data;

                    $('.dynamic-form').html(html);

                })
                .catch(function(error) {})
        }

        function autoCalculateToggle() {
            let autoCalculateStatus = $('#autoCalculateToggle').is(':checked');

            if (autoCalculateStatus) {
                $('#autoCalculateParent').removeClass('d-none');
            } else {
                $('#autoCalculateParent').addClass('d-none');
            }

        }

        function getNewLengthMaterials() {

            let unit_config_id = $('#unit_config_id option:selected').val();
            let length = $('#length').val();

            if (!unit_config_id) {
                alert('Please select a unit config');
                return false;
            }

            if (!length) {
                alert('Please enter length');
                return false;
            }


            axios.get(route('UnitConfigById', unit_config_id))
                .then(function(response) {

                    let data = response.data;

                    let length = data.length > 0 ? data.length : data.pile_length;
                    let cement_qty = data.cement_qty;
                    let sand_qty = data.sand_qty;
                    let stone_qty = data.stone_qty;
                    let soil_qty = data.soil_qty;
                    let tiles_sft = data.tiles_sft;

                })
                .catch(function(error) {})

        }

        $(document).ready(function() {

            $('#autoCalculateToggle').click(function(e) {
                autoCalculateToggle();
            });

            $('#unit_ids').change(function(e) {
                e.preventDefault();

                toggleUnitForm();

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
        function addItem() {
            var row_count = $('.row_count').val();
            var total = parseInt(row_count) + 1;

            $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
                '<td class="pl-0">' +
                '<select name="budgetHeadIds[]" onchange="updateItemRow(event, ' + total +
                ')" class="form-control chosen-select itemList itemList_' + total + '">' +
                '</select>' +
                '</td>' +
                '<td class="d-none">' +
                '<select class="form-control chosen-select unitList_' + total + '" required readonly>' +
                '</select>' +
                '</td>' +
                '<td><input style="text-align: center;" class="form-control qty qty_' + total +
                '" type="number" step="any" name="consumption_qty[]" value="1" required oninput="totalAmount(' + total +
                ')"></td>' +
                '<td><input style="text-align: center;" class="form-control budget budget_' + total +
                '" type="number" step="any" name="budget_balance[]" value="0" readonly></td>' +
                '<td><input style="text-align: center;" class="form-control stock stock_' + total +
                '" type="number" step="any" name="stock_balance[]" value="0" readonly></td>' +
                '<td align="center"><span class="btn btn-success" onclick="addItem()"> <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i> </span> <span class="btn btn-danger item_remove" onclick="itemRemove(' +
                total + ')"><i class="fa fa-trash" style="font-size: 20px"></i> </span></td>' +
                '</tr>');
            $('.row_count').val(total);

            var itemList = $("#itemList div select").html();
            $('.itemList_' + total).html(itemList);
            $('.chosen-select').chosen();
            $('.chosen-select').trigger("chosen:updated");

            var unitList = $("#unitList div select").html();
            $('.unitList_' + total).html(unitList);
            $('.chosen-select').chosen();
            $('.chosen-select').trigger("chosen:updated");

            row_sum();
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

            $('.total_qty').val(total_qty.toFixed(4));
            $('.total_amount').val(total_amount.toFixed(4));

            $("#itemRow_" + i).remove();
        }

        function totalAmount(i) {
            var qty = $(".qty_" + i).val();
            var rate = $(".rate_" + i).val();
            var sum_total = parseFloat(qty) * parseFloat(rate);
            $(".amount_" + i).val(sum_total.toFixed(4));
            row_sum();
        }

        function row_sum() {
            var total_qty = 0;
            var total_amount = 0;
            $(".qty").each(function() {
                var stvalTotal = parseFloat($(this).val());
                // console.log(stval);
                total_qty += isNaN(stvalTotal) ? 0 : stvalTotal;
            });

            $(".amount").each(function() {
                var stvalAmount = parseFloat($(this).val());
                // console.log(stval);
                total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
            });

            $('.total_qty').val(total_qty.toFixed(4));
            $('.total_amount').val(total_amount.toFixed(4));
        }
    </script>

    <script>
        function updateItemRow(e, rowId) {

            let changeInputVal = +$(e.target).val();
            let changeInputText = $(e.target).find("option:selected").text();

            // get budget info start
            axios.get(route('getProjectMaterialStock'), {
                    params: {
                        project_id: $('#project option:selected').val(),
                        unit_id: $('#unit_ids option:selected').val(),
                        tower_id: $('#tower option:selected').val(),
                        material_id: $(e.target).find("option:selected").attr('material-id'),
                    }
                })
                .then(function(response) {

                    let data = response.data;

                    $('.budget_' + rowId).val(data.budget_balance);
                    $('.stock_' + rowId).val(data.stock_balance);

                })
                .catch(function(error) {})
            // get budget info end

        }
    </script>
@endsection

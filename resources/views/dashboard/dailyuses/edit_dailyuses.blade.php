@extends('dashboard.layouts.app')

@section('content')
    <form method="POST" action="{{ route('dailyuses.update', $data->dailyConsumption->id) }}">
        @csrf
        @method('PATCH')
        <div class="tile">
            <div class="tile-body">
                <div class="">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('dailyuses.index') }}" type="button" class="btn btn-info float-left">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                            </a>
                        </div>
                        <div class="col-md-7">
                            <h3 class="text-center my-3 d-md-none d-block text-uppercase">{{ $data->title }}</h3>
                            <h3 class="text-center d-md-block d-none text-uppercase">{{ $data->title }}</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <a target="_blank" href="{{ route('dailyuses.print', $data->dailyConsumption->id) }}"
                                class="btn btn-info">
                                <i class="fa fa-print" aria-hidden="true"></i> Print
                            </a>

                            <button type="submit" class="btn btn-success">
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
                        'company_id' => $data->dailyConsumption->company_id,
                    ])

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="system_serial">System Serial</label>
                            <input type="text" id="system_serial" class="form-control"
                                value="{{ $data->dailyConsumption->system_serial }}" name="system_serial" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ $data->dailyConsumption->date }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <input type="hidden" id="project_id" value="{{ $data->dailyConsumption->project->id }}">
                            <input type="text" class="form-control" name="project"
                                value="{{ $data->dailyConsumption->project->project_name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="unit">Unit</label>
                            <input type="hidden" id="unit_id" value="{{ $data->dailyConsumption->unit->id }}">

                            <input type="text" class="form-control" name="unit"
                                value="{{ $data->dailyConsumption->unit->name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <select class="select2" name="tower[]" id="tower">
                                @foreach ($data->projectTowers as $projectTower)
                                    <option value="{{ $projectTower->id }}"
                                        @if ($projectTower->id == $data->dailyConsumption->tower_id) selected @endif>{{ $projectTower->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pile_no">Pile No</label>
                            <input type="text" id="pile_no" name="pile_no" class="form-control"
                                value="{{ $data->dailyConsumption->pile_no }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Working Length</label>
                            <input type="text" id="working_length" name="working_length"
                                value="{{ $data->dailyConsumption->working_length }}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="site_engineer">Site Engineer</label>
                            <input type="text" id="site_engineer" name="site_engineer" class="form-control"
                                value="{{ $data->dailyConsumption->site_engineer }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="logistics_associate">Logistics Associate</label>
                            <select name="logistics_associate" id="logistics_associate" class="select2" readonly="true">
                                <option value="">Select Vendor</option>
                                @foreach ($data->logistics_vendors as $vendor)
                                    <option value="{{ $vendor->id }}" @if ($vendor->id == $data->dailyConsumption->logistics_associate_id) selected @endif>
                                        {{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="truck_no">Truck No</label>
                            <input type="text" id="truck_no" name="truck_no" class="form-control"
                                value="{{ $data->dailyConsumption->truck_no }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="epc_engineer">EPC Engineer</label>
                            <input type="text" id="epc_engineer" name="epc_engineer" class="form-control"
                                value="{{ $data->dailyConsumption->epc_engineer }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="department_engineer">Department Engineer</label>
                            <input type="text" id="department_engineer" name="department_engineer"
                                class="form-control" value="{{ $data->dailyConsumption->department_engineer }}">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 budgethead-table-here">
                        @include('dashboard.dailyuses.table.edit_table', [
                            'dailyconsumptionItems' => $data->dailyconsumptionItems,
                            'budgetHeads' => $data->budgetHeads,
                        ])
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
                {!! $data->budgetHeadSelect !!}
            </select>
        </div>
    </div>

    <div id="unitList" style="display:none">
        <div class="input select">
            <select>
                <option value="">Select UOM</option>
                @foreach ($data->units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection

@section('custom-script')
    <script type="text/javascript">
        function addItem() {
            var row_count = $('.row_count').val();
            var total = parseInt(row_count) + 1;

            let rate_attr = '';
            let liftingType = $('#lifting_type').val();

            if (['Project wise Company Provide', 'Central Company Provide'].includes(liftingType)) {
                rate_attr = 'readonly'
            }

            $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
                '<td class="pl-0">' +
                '<select name="budgetHeadIds[]" onchange="updateItemRow(event, ' + total +
                ')" class="form-control chosen-select itemList itemList_' + total + '">' +
                '</select>' +
                '</td>' +
                '<td class="d-none">' +
                '<select name="unit_id[]" class="form-control chosen-select unitList_' + total +
                '" required readonly>' +
                '</select>' +
                '</td>' +
                '<td><input style="text-align: right;" class="form-control qty qty_' + total +
                '" type="number" step="any" name="consumption_qty[]" value="1" required oninput="totalAmount(' + total +
                ')"></td>' +
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
            // console.log(i);

            var qty = $(".qty_" + i).val();
            var rate = $(".rate_" + i).val();
            var sum_total = parseFloat(qty) * parseFloat(rate);
            $(".amount_" + i).val(sum_total.toFixed(2));
            row_sum();
            calculateDesignDiff();
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
        function getBudgetInfo(rowId) {

            const materialId = $(`.itemList_${rowId} option:selected`).attr('material-id');
            const budgetHeadId = $(`.itemList_${rowId} option:selected`).val();

            // budgethead stock qty start
            axios.get(route('getProjectMaterialLocalStock'), {
                    params: {
                        project_id: $('#project_id').val(),
                        unit_id: $('#unit_id').val(),
                        tower_id: $('#tower option:selected').val(),
                        material_id: materialId,
                    }
                })
                .then(function(response) {

                    let data = response.data;

                    $('.stock_' + rowId).val(data.stock_balance);
                    // $('.qty_' + rowId).attr('max', data.stock_balance);

                    calculateDesignDiff();

                })
                .catch(function(error) {})
            // budgethead stock qty end


            // budgethead design qty start
            axios.get(route('getProjectMaterialDesignStock'), {
                    params: {
                        project_id: $('#project_id').val(),
                        unit_id: $('#unit_id').val(),
                        tower_id: $('#tower option:selected').val(),
                        material_id: budgetHeadId,
                    }
                })
                .then(function(response) {
                    let data = response.data;

                    $('.design_stock_' + rowId).val(data);
                    $('#original_design_stock_' + rowId).val(data);

                    calculateDesignDiff();

                })
                .catch(function(error) {})

        }


        function updateItemRow(e, rowId) {

            // let changeInputVal = +$(e.target).val();
            // let changeInputText = $(e.target).find("option:selected").text();

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


            // get budget info start
            getBudgetInfo(rowId);
            // get budget info end
        }
    </script>


    <script>
        $(document).ready(function() {

            row_sum();

            // on tower change get tower material start
            $('#tower').change(function(e) {
                e.preventDefault();

                // on tower change fetch project, unit, towerwise budget materials
                axios.get(route('projectUnitTowerWiseBudget'), {
                        params: {
                            project_id: $('#project_id').val(),
                            unit_id: $('#unit_id').val(),
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

                    $(item).val(newDesignQty.toFixed(4));
                });


            });
            // on working length change end


        });
    </script>

    <script>
        function calculateDesignDiff(params) {
            // loop throught design_stock and calculate design balance
            $('.design_stock').each(function(index, item) {
                // console.log(item);
                let iterationNo = +$(item).attr('iteration');
                // console.log(iterationNo);
                let designStock = +$('.design_stock_' + iterationNo).val();
                let qty = +$('.qty_' + iterationNo).val();

                let designBalance = designStock - qty;

                $('.design_balance_' + iterationNo).val(designBalance.toFixed(2));
            });
        }

        $(document).ready(function() {
            // loop through itemList
            $('.itemList').each(function(index, item) {
                // console.log(item);
                let iterationNo = +$(item).attr('item-id');
                // console.log(iterationNo);
                getBudgetInfo(iterationNo);
            });


        });
    </script>
@endsection

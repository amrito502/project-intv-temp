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

    <form method="POST" action="{{ route('materialissue.store') }}">
        @csrf

        <div class="tile">
            <div class="tile-body">
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

        <div class="tile">
            <div class="tile-body">
                <div class="row">

                    @include('dashboard.layouts.partials.company_dropdown', [
                        'columnClass' => 'col-md-4',
                        'company_id' => 0,
                    ])

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="system_serial">Issue Serial</label>
                            <input type="text" id="system_serial" class="form-control" value="{{ $data->system_serial }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Issue Date</label>
                            <input type="text" id="date" name="issue_date" class="form-control datepicker"
                                autocomplete="off" value="{{ date('d-m-Y', time()) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="logistics_associate">Logistics Associate</label>
                            <select name="logistics_associate" id="logistics_associate" class="select2" required>
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
                            <label for="issue_to">Issue To (person name)</label>
                            <input type="text" id="issue_to" name="issue_to" class="form-control">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="source_project">Source Project</label>
                            <select name="source_project" id="source_project" class="select2" required>
                                <option value="">Select Project</option>
                                <option value="999999">Central Store</option>
                                @foreach ($data->projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="source_unit_id">Source Unit</label>
                            <select class="select2" name="source_unit_id" id="source_unit_id">
                                <option value="">Select Source Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="source_tower">Source Tower</label>
                            <select class="select2" name="source_tower" id="source_tower">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="issue_project">Issue Project</label>
                            <select name="project" id="issue_project" class="select2" required>
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="issue_unit_id">Issue Unit</label>
                            <select class="select2" name="issue_unit_id" id="issue_unit_id">
                                <option value="">Select Source Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="issue_tower">Issue Tower</label>
                            <select class="select2" name="issue_tower" id="issue_tower">
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12" style="overflow-y: auto">
                        <div style="overflow-x: auto;height: 500px">
                            <table class="table gridTable mobile-changes">
                                <thead>
                                    <tr>
                                        <th width="50%">Material Name & UOM</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Stock Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody">
                                    <tr>
                                        <td style="padding-left: 0;">
                                            <select onchange="updateItemRow(event, 1)"
                                                class="form-control form-control-danger chosen-select"
                                                name="material_id[]" required="">
                                                <option value=" ">Select Item</option>
                                                <?php
                                                    foreach ($data->materials as $material)
                                                    {
                                                ?>
                                                <option value="{{ $material->id }}">{{ $material->name }}
                                                    ({{ $material->materialUnit->name }})</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input style="text-align: center;" class="qty qty_1 form-control"
                                                type="number" step="any" name="qty[]" oninput="totalAmount('1')"
                                                value="1" required>
                                        </td>
                                        <td>
                                            <input style="text-align: center;" class="form-control stock stock_1"
                                                type="number" step="any" name="stock_balance[]" value="0"
                                                readonly>
                                        </td>
                                        <td>
                                            <span class="btn btn-success add_item">
                                                <i class="fa fa-plus" style="font-size: 20px"></i>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>
                                            <p class='text-right mb-0 mt-2'>Total Quantity</p>
                                        </th>
                                        <th colspan='1'>
                                            <input type="hidden" class="row_count" value="1">

                                            <input class="total_qty form-control text-center" type="number"
                                                step="any" name="total_qty" value="1" readonly>
                                        </th>

                                        <th align="center">
                                            {{-- <input type="hidden" class="row_count" value="1">
                                            <span class="btn btn-block btn-success add_item">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </span> --}}
                                        </th>
                                        <th></th>
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
                <option value=" ">Select Item</option>
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
                {{-- <option value=" ">Select UOM</option> --}}
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
    <script>
        function updateItemRow(e, rowId) {

            let changeInputVal = +$(e.target).val();

            // get budget info start
            axios.get(route('getProjectMaterialStock'), {
                    params: {
                        project_id: $('#source_project').val(),
                        material_id: changeInputVal,
                    }
                })
                .then(function(response) {

                    let data = response.data;

                    $('.budget_' + rowId).val(data.budget_balance);
                    $('.stock_' + rowId).val(data.stock_balance);
                    $('.qty_' + rowId).attr('max', data.stock_balance);

                })
                .catch(function(error) {})
            // get budget info end

        }
    </script>



    <script type="text/javascript">
        function addItem() {
            var row_count = $('.row_count').val();
            var total = parseInt(row_count) + 1;
            $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
                '<td style="padding-left: 0;">' +
                '<select onchange="updateItemRow(event, ' + total +
                ')" name="material_id[]" class="form-control chosen-select itemList_' + total + '">' +
                '</select>' +
                '</td>' +
                '<td><input class="text-center form-control qty qty_' + total +
                '" type="number" step="any" name="qty[]" value="1" required oninput="totalAmount(' + total +
                ')"></td>' +
                `
            <td>
                <input style="text-align: center;" class="form-control stock stock_${total}" type="number" step="any" name="stock_balance[]" value="0" readonly>
            </td>
            ` +
                '<td>' +
                '<span class="btn btn-success add_item mr-3" onclick="addItem()">' +
                '<i class="fa fa-plus" style="font-size: 20px"></i>' +
                '</span>' +
                '<span class="btn btn-danger item_remove" onclick="itemRemove(' + total +
                ')"><i class="fa fa-trash" style="font-size: 20px"></i></span>' +
                '</td>' +
                '</tr>');
            $('.row_count').val(total);

            var itemList = $("#itemList div select").html();
            $('.itemList_' + total).html(itemList);
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

            $('.total_qty').val(total_qty.toFixed(2));
            $('.total_amount').val(total_amount.toFixed(2));

            $("#itemRow_" + i).remove();
        }

        function totalAmount(i) {
            var qty = $(".qty_" + i).val();
            var rate = $(".rate_" + i).val();
            var sum_total = parseFloat(qty) * parseFloat(rate);
            $(".amount_" + i).val(sum_total.toFixed(2));
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

            $('.total_qty').val(total_qty.toFixed(2));
            $('.total_amount').val(total_amount.toFixed(2));
        }
    </script>

    <script>
        function getProjectWiseTowers(id, outputEl) {

            // fetch tower start
            axios.get(route('projectwise.tower', id))
                .then(function(response) {

                    const data = response.data.project_towers;

                    let options = `<option value="">Select An Option</option>`;

                    data.forEach(el => {

                        let option = `<option value="${el.id}">${el.name}</option>`;

                        options += option;

                    });

                    $(outputEl).html(options);

                })
                .catch(function(error) {})
            // fetch tower end

        }

        $(document).ready(function() {

            // source project wise units start
            $('#source_project').change(function(e) {
                e.preventDefault();

                const projectId = +$(this).val();

                if (projectId == '') {
                    $('#source_unit_id').html('');
                    return false;
                }

                // fetch unit start
                axios.get(route('project.units', projectId))
                    .then(function(response) {

                        const data = response.data.project_units;

                        let options = `<option value="">Select An Option</option>`;

                        data.forEach(el => {

                            let option =
                                `<option value="${el.unit.id}">${el.unit.name}</option>`;

                            options += option;

                        });

                        $('#source_unit_id').html(options);

                    })
                    .catch(function(error) {})
                // fetch unit end

                getProjectWiseTowers(projectId, '#source_tower');

            });
            // source project wise units end


            // issue project wise units start
            $('#issue_project').change(function(e) {
                e.preventDefault();

                const projectId = +$(this).val();

                if (projectId == '') {
                    $('#issue_unit_id').html('');
                    return false;
                }

                // fetch unit start
                axios.get(route('project.units', projectId))
                    .then(function(response) {

                        const data = response.data.project_units;

                        let options = `<option value="">Select An Option</option>`;

                        data.forEach(el => {

                            let option =
                                `<option value="${el.unit.id}">${el.unit.name}</option>`;

                            options += option;

                        });


                        $('#issue_unit_id').html(options);


                    })
                    .catch(function(error) {})
                // fetch unit end

                getProjectWiseTowers(projectId, '#issue_tower');


            });
            // issue project wise units end


        });
    </script>
@endsection

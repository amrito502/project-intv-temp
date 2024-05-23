@extends('dashboard.layouts.app')

@section('content')
    <form method="POST" action="{{ route('dailyconsumption.update', $data->dailyConsumption->id) }}">
        @csrf
        @method('PATCH')

        <div class="tile">
            <div class="tile-body">
                <div class="">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('dailyconsumption.index') }}" type="button" class="btn btn-info float-left">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                            </a>
                        </div>
                        <div class="col-md-7">
                            <h3 class="text-center my-3 d-md-none d-block text-uppercase">{{ $data->title }}</h3>
                            <h3 class="text-center d-md-block d-none text-uppercase">{{ $data->title }}</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <a target="_blank" href="{{ route('dailyconsumption.print', $data->dailyConsumption->id) }}"
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
                        'columnClass' => 'col-md-4',
                        'company_id' => $data->dailyConsumption->company_id,
                    ])

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="system_serial">System Serial</label>
                            <input type="text" id="system_serial" class="form-control"
                                value="{{ $data->dailyConsumption->system_serial }}" name="system_serial" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ $data->dailyConsumption->date }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project">Project</label>

                            <input type="hidden" id="project_id" value="{{ $data->dailyConsumption->project->id }}">

                            <input type="text" class="form-control" name="project"
                                value="{{ $data->dailyConsumption->project->project_name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit">Unit</label>

                            <input type="text" class="form-control" name="unit"
                                value="{{ $data->dailyConsumption->unit->name }}" readonly>

                            <input type="hidden" id="unit_ids" name="unit_ids[]"
                                value="{{ $data->dailyConsumption->unit->id }}">

                        </div>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="truck_no">Truck No</label>
                            <input type="text" id="truck_no" name="truck_no" class="form-control"
                                value="{{ $data->dailyConsumption->truck_no }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="issue_by">Issue By</label>
                            <input type="text" id="issue_by" name="issue_by" class="form-control"
                                value="{{ $data->dailyConsumption->issue_by_name }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @include('dashboard.dailyconsumption.table.edit_table', [
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
        <div class="input select">
            {!! $data->budgetHeadSelect !!}
        </div>
    </div>

    <div id="unitList" style="display:none">
        <div class="input select">
            <select>
                <option value=" ">Select UOM</option>
                @foreach ($data->units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection

@section('custom-script')
    {{-- projectwise unit start --}}
    {{-- <script>
    function getProjectWiseUnit() {
        const projectId = +$('#project').val();
        const projectType = $('#project option:selected').attr('ptype');

        if(projectId == ''){
            $('#unit_ids').html('');
            return false;
        }

        axios.get(route('project.units', projectId))
        .then(function (response) {

            const data = response.data.project_units;

            let options = '<option>Select Unit</option>';

            data.forEach(el => {

                let option = `<option value="${el.unit.id}" >${el.unit.name}</option>`;

                options += option;

            });


            $('#unit_ids').html(options);

        })
        .catch(function (error) {
        })


        // fetch project towers
        if(projectType == 'tower'){

            axios.get(route('projectwise.tower', projectId))
            .then(function (response) {

                const data = response.data.project_towers;

                let options = '<option value="">Select Tower</option>';

                data.forEach(el => {

                    let option = `<option value="${el.id}" >${el.name}</option>`;

                    options += option;

                });


                $('#tower').html(options);

            })
            .catch(function (error) {
            })

        }

    }





    $(document).ready(function () {

        $('#project').change(function (e) {
            e.preventDefault();

            getProjectWiseUnit();

        });


        $('#unit_ids').change(function (e) {
            e.preventDefault();

            getProjectAndUnitWiseBudgetHeads();

        });

    });
</script> --}}
    {{-- projectwise unit end --}}


    <script type="text/javascript">
        // $(document).ready(function () {
        //     getProjectAndUnitWiseBudgetHeads();
        // });


        //   function getProjectAndUnitWiseBudgetHeads() {
        //     const projectId = +$('#project').val();
        //     const unitIds = $('#unit_ids').val();

        //     if(projectId == ''){
        //         $('#unit_ids').html('');
        //         return false;
        //     }

        //     if(unitIds == []){
        //         return false;
        //     }

        //     axios.get(route('projectUnitToBudgetHead', [projectId, unitIds]))
        //     .then(function (response) {

        //         const data = response.data;

        //         $('.budgethead-table-here').html(data);

        //     })
        //     .catch(function (error) {
        //     })

        // }


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
                        project_id: $('#project_id').val(),
                        unit_id: $('#unit_ids').val(),
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

    <script>
        $(function() {
            row_sum();
        });
    </script>

    <script>
        $(document).ready(function() {

            // get row count
            var row_count = $('.row_count').val();

            // loop through each row
            for (let i = 1; i <= row_count; i++) {

                // get budget info start
                axios.get(route('getProjectMaterialStock'), {
                        params: {
                            project_id: $('#project_id').val(),
                            unit_id: $('#unit_ids').val(),
                            tower_id: $('#tower option:selected').val(),
                            material_id: $('.item_count_' + i).find("option:selected").attr('material-id'),
                        }
                    })
                    .then(function(response) {

                        let data = response.data;

                        $('.budget_count_' + i).val(data.budget_balance);
                        $('.stock_count_' + i).val(data.stock_balance);

                    })
                    .catch(function(error) {})
                // get budget info end

            }
        });
    </script>
@endsection

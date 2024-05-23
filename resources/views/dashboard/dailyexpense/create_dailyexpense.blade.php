@extends('dashboard.layouts.app')

@section('custom-css')
    <style>
        .table th,
        .table td {
            padding: 0.75rem 0.30rem;
        }

        .table th {
            padding-right: 5px;
        }
    </style>
@endsection

@section('content')
    <form method="POST" action="{{ route('dailyexpense.store') }}">
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
                            <label for="project_id">Project</label>
                            <select class="select2" name="project_id" id="project_id" required>
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit_id">Unit</label>
                            <select class="select2" name="unit_config_id" id="unit_id" required>
                                <option value="">Select Project First</option>
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

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="serial_no">Serial No</label>
                            <input class="form-control" name="serial_no" id="serial_no" type="text"
                                value="{{ $data->serial }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input class="form-control datepicker" value="{{ date('d-m-Y') }}" name="date" id="date"
                                type="text" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <input class="form-control" name="remarks" id="remarks" type="text">
                        </div>
                    </div>

                </div>

                <div class="row material_table">
                    <div class="col-md-12" style="overflow-y: auto">
                        <table class="table gridTable mobile-changes">
                            <thead>
                                <tr>
                                    <th width="12%">Vendor</th>
                                    <th width="250px">Budget Head</th>
                                    <th class="text-center">Budget</th>
                                    <th class="text-center">Approved</th>
                                    <th class="text-center">Issued</th>
                                    <th class="text-center">Used</th>
                                    <th class="text-center">Expence</th>
                                    <th class="text-center">Remarks</th>
                                    <th width="150px" class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody id="tbody">
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="6" class="px-1 py-1">
                                        <p class='mb-0 mt-2 text-right'>Amount</p>
                                    </th>
                                    <th class="py-2 py-1">
                                        <input class="total_amount form-control text-right" type="number" step="any"
                                            name="total_amount" value="0" readonly>
                                    </th>
                                    <th></th>
                                    <td align="center" class="py-2 py-1">
                                        <input type="hidden" class="row_count" value="1">
                                        <span class="btn btn-block btn-success add_item">
                                            <i class="fa fa-plus" style="font-size: 20px"></i>
                                        </span>
                                    </td>

                                </tr>
                            </tfoot>
                        </table>
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
                @if (!Auth::user()->hasRole('Vendor'))
                    <option value=" ">Select Vendor</option>
                @endif

                <?php
                foreach ($data->vendors as $vendor)
                {
            ?>
                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                <?php
                }
            ?>
            </select>
        </div>
    </div>

    <div id="unitList" style="display:none">
        <div class="input select">
            <select>
                <option value=" ">Select BudgetHead</option>
                <?php
                foreach ($data->budgetHeads as $budgetHead)
                {
            ?>
                <option value="{{ $budgetHead->id }}">{{ $budgetHead->name }}</option>
                <?php
                }
            ?>
            </select>
        </div>
    </div>
@endsection

@section('custom-script')
    {{-- projectwise unit start --}}
    <script>
        $(document).ready(function() {

            $('#project_id').change(function(e) {
                e.preventDefault();

                const projectId = +$(this).val();

                if (projectId == '') {
                    $('#unit_id').html('');
                    return false;
                }

                // projectwise unit start
                axios.get(route('project.units', projectId))
                    .then(function(response) {

                        const data = response.data.project_units;

                        let options = `<option value="">Select An Option</option>`;

                        data.forEach(el => {

                            let option =
                                `<option value="${el.unit.id}">${el.unit.name}</option>`;

                            options += option;

                        });

                        $('#unit_id').html(options);

                    })
                    .catch(function(error) {})
                // projectwise unit end



                // projectwise tower start
                axios.get(route('projectwise.tower', projectId))
                    .then(function(response) {

                        const data = response.data.project_towers;

                        let options = `<option value="">Select An Option</option>`;

                        data.forEach(el => {

                            let option = `<option value="${el.id}">${el.name}</option>`;

                            options += option;

                        });

                        $('#tower').html(options);

                    })
                    .catch(function(error) {})
                // projectwise tower end


            });

            $('#unit_id').change(function(e) {
                e.preventDefault();

                const unitId = +$(this).val();

                if (unitId == '') {
                    $('#unit_id').html('');
                    return false;
                }

                let projectId = $('#project_id').val();


                axios.get(route('projectUnitWiseBudgetHeadCashOnly', [projectId, unitId]))
                    .then(function(response) {

                        const items = response.data;

                        let options = `<option value="">Select An Option</option>`;

                        items.forEach(item => {

                            let option = `<option value="${item.id}">${item.name}</option>`;

                            options += option;

                        });

                        $('#unitList .input select').html('');
                        $('#unitList .input select').html(options);

                    })
                    .catch(function(error) {})

            });

        });

        function budgetHeadWiseTotalEstimated(id) {
            const projectId = +$('#project_id').val();
            const unitId = +$('#unit_id').val();
            const budget_head_id = $('.unitList_' + id + ' option:selected').val();

            // get estimated amount start
            axios.get(route('budgetHeadWiseTotalEstimated', [projectId, unitId, budget_head_id]))
                .then(function(response) {

                    let data = response.data;

                    $('.estimated_' + id).val(data);

                })
                .catch(function(error) {})
            // get estimated amount end


        }

        function alreadyIssuedAmount(id) {

            const projectId = +$('#project_id').val();
            const unitId = +$('#unit_id').val();
            const budget_head_id = $('.unitList_' + id + ' option:selected').val();

            // get issued amount start
            axios.get(route('budgetHeadWiseTotalPaid', [projectId, unitId, budget_head_id]))
                .then(function(response) {

                    let data = response.data;

                    $('.issued_' + id).val(data);

                })
                .catch(function(error) {})
            // get issued amount end

        }

        function alreadyApprovedAmount(id) {

            const projectId = +$('#project_id option:selected').val();
            const unitId = +$('#unit_id option:selected').val();
            const towerId = +$('#tower option:selected').val();
            const budgetHeadId = $('.unitList_' + id + ' option:selected').val();

            // get issued amount start
            axios.get(route('budgetHeadWiseTotalApproved', {
                    projectId,
                    unitId,
                    budgetHeadId,
                    towerId
                }))
                .then(function(response) {

                    let data = response.data;

                    $('.approved_amount_' + id).val(data);

                })
                .catch(function(error) {})
            // get issued amount end

        }

        function alreadyUsedAmount(id) {
            const projectId = +$('#project_id option:selected').val();
            const unitId = +$('#unit_id option:selected').val();
            const towerId = +$('#tower option:selected').val();
            const budgetHeadId = $('.unitList_' + id + ' option:selected').val();

            // get issued amount start
            axios.get(route('budgetHeadWiseTotalUsed', {
                    projectId,
                    unitId,
                    budgetHeadId,
                    towerId
                }))
                .then(function(response) {

                    let data = response.data;

                    $('.approved_due_' + id).val(data);
                    $('.amount_' + id).val(data);

                })
                .catch(function(error) {})
            // get issued amount end

        }

        async function updateItemRow(e, id) {

            const budget_head_id = $('.unitList_' + id + ' option:selected').val();

            if (!budget_head_id) {
                return false;
            }

            budgetHeadWiseTotalEstimated(id);
            alreadyApprovedAmount(id);
            alreadyIssuedAmount(id);
            alreadyUsedAmount(id);


        }
    </script>
    {{-- projectwise unit end --}}


    {{-- table start --}}

    <script type="text/javascript">
        function addItem() {

            let vendorUser = false;
            let vendorUserId = 0;

            @if (auth()->user()->hasRole('Vendor'))
                vendorUser = true;
                vendorUserId = {{ auth()->user()->id }};
            @endif

            var row_count = $('.row_count').val();
            var total = parseInt(row_count) + 1;

            let rate_attr = '';
            let liftingType = $('#lifting_type').val();

            if (['Project wise Company Provide', 'Central Company Provide'].includes(liftingType)) {
                rate_attr = 'readonly'
            }

            $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
                '<td>' +
                '<select name="vendor[]" onchange="updateItemRow(event, ' + total +
                ')" class="form-control chosen-select itemList itemList_' + total + '">' +
                '</select>' +
                '</td>' +
                '<td>' +
                '<select name="budget_head[]" onchange="updateItemRow(event, ' + total +
                ')" class="form-control chosen-select unitList unitList_' + total + '" required>' +
                '</select>' +
                '</td>' +
                '<td><input style="text-align: right;" class="text-center form-control estimated_' + total +
                '" type="number" step="any" name="estimated[]" value="0" required readonly></td>' +
                '<td><input style="text-align: right;" class="text-center form-control approved_amount_' + total +
                '" type="number" step="any" name="approved_amount[]" value="0" required readonly></td>' +
                '<td><input style="text-align: right;" class="text-center form-control issued_' + total +
                '" type="number" step="any" name="issued[]" value="0" required ' + rate_attr + ' readonly></td>' +
                '<td><input style="text-align: right;" class="text-center form-control approved_due_' + total +
                '" type="number" step="any" name="approved_due[]" value="0" required ' + rate_attr + ' readonly></td>' +
                '<td><input style="text-align: right;" class="text-center form-control amount amount_' + total +
                '" type="number" step="any" name="amount[]" value="0" onkeyup="row_sum()" required></td>' +
                '<td><input class="text-center form-control remarks remarks_' + total +
                '" type="text" name="item_remarks[]"></td>' +
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


            // @if (auth()->user()->hasRole('Vendor'))
            //     console.log($('.itemList_'+total));
            //     $('.itemList_'+total).prop('disabled', true).trigger("chosen:updated");
            // @endif

        }

        $(".add_item").click(function() {
            addItem();
        });

        function itemRemove(i) {
            var total_amount = $('.total_amount').val();

            var amount = $('.amount_' + i).val();

            total_amount = total_amount - amount;

            $('.total_amount').val(total_amount.toFixed(2));

            $("#itemRow_" + i).remove();
        }

        function row_sum() {
            var total_amount = 0;

            $(".amount").each(function() {
                var stvalAmount = parseFloat($(this).val());
                total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
            });

            $('.total_amount').val(total_amount.toFixed(2));
        }
    </script>

    {{-- table end --}}
@endsection

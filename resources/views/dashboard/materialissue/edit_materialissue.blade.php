@extends('dashboard.layouts.app')

@section('content')
    @include('dashboard.layouts.partials.error')

    <form action="{{ route('materialissue.update', $data->materialissue->id) }}" method="POST">
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
                <div class="row">

                    @include('dashboard.layouts.partials.company_dropdown', [
                        'columnClass' => 'col-md-4',
                        'company_id' => $data->materialissue->company_id,
                    ])

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="system_serial">System Serial</label>
                            <input type="text" id="system_serial" class="form-control"
                                value="{{ $data->materialissue->system_serial }}" name="system_serial" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Issue Date</label>
                            <input type="text" id="date" name="issue_date" class="form-control datepicker"
                                value="{{ date('d-m-Y', strtotime($data->materialissue->issue_date)) }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="source_project">Source Project</label>
                            <select name="source_project" id="source_project" class="select2" required>
                                <option value="">Select Project</option>
                                <option value="999999" @if ($data->materialissue->source_project_id == 999999) selected @endif>Central Store
                                </option>
                                @foreach ($data->projects as $project)
                                    <option value="{{ $project->id }}" @if ($project->id == $data->materialissue->source_project_id) selected @endif>
                                        {{ $project->project_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="project">Destination Project</label>
                            <select name="project" id="project" class="select2" required>
                                @foreach ($data->projects as $project)
                                    <option value="{{ $project->id }}" @if ($project->id == $data->materialissue->project_id) selected @endif>
                                        {{ $project->project_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="overflow-y: auto">
                        <div style="overflow-x: auto;height: 500px">
                            <table class="table table-striped gridTable mobile-changes">
                                <thead>
                                    <tr>
                                        <th width="50%">Material Name & UOM</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Stock Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <?php
                                    $i = 0;
                                    $countItem = count($data->materialIssueItems);
                                    foreach ($data->materialIssueItems as $item)
                                    {
                                        $i++;
                                    ?>
                                    <tr id="itemRow_{{ $i }}">
                                        <td class="pl-0">
                                            <select
                                                class="form-control form-control-danger chosen-select materialD_{{ $i }}"
                                                name="material_id[]" required=""
                                                onchange="updateItemRow(event, '{{ $i }}')">
                                                <option value=" ">Select Item</option>
                                                <?php
                                                    foreach ($data->materials as $material)
                                                    {

                                                        if($item->material_id == $material->id)
                                                        {
                                                            $selected = "selected";
                                                        }
                                                        else
                                                        {
                                                            $selected = "";
                                                        }
                                                ?>
                                                <option {{ $selected }} value="{{ $material->id }}">
                                                    {{ $material->name }}
                                                </option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control qty qty_{{ $i }}" type="number"
                                                step="any" name="qty[]" value="{{ $item->material_qty }}"
                                                oninput="totalAmount({{ $i }})" required>
                                        </td>

                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control stock stock_{{ $i }}" type="number"
                                                step="any" name="stock_balance[]" value="0" readonly>
                                        </td>

                                        {{-- <td>
                                            <input style="text-align: right;" class="form-control amount amount_{{$i}}"
                                                type="number" step="any" name="amount[]"
                                                value="{{$item->material_qty * $item->material_rate}}" required
                                                readonly>
                                        </td> --}}

                                        <td align="center">
                                            @if ($i > 1)
                                                <span class="btn btn-block btn-danger item_remove"
                                                    onclick="itemRemove('{{ $i }}')"><i
                                                        class="fa fa-trash"></i></span>
                                            @endif
                                        </td>

                                    </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th class="text-right">Total Quantity</th>
                                        <th>
                                            <input class="form-control total_qty text-center" type="number" step="any"
                                                name="total_qty" value="{{ $data->materialissue->totalQty() }}" readonly>
                                        </th>
                                        {{-- <th colspan="2">Total Amount</th> --}}
                                        {{-- <td>
                                            <input class="form-control total_amount text-right" type="number" step="any"
                                                name="total_amount" value="{{$data->materialissue->totalAmount()}}"
                                                readonly>
                                        </td> --}}

                                        <th></th>
                                        <th align="center">
                                            <input type="hidden" class="row_count" value="{{ $i }}">
                                            <span class="btn btn-block btn-success add_item">
                                                <i class="fa fa-plus-circle"></i>
                                            </span>
                                        </th>
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
    <script type="text/javascript">
        $(".add_item").click(function() {
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

                })
                .catch(function(error) {})
            // get budget info end

        }
    </script>

    <script>
        // auto update item row start
        $(document).ready(function() {

            // get row count
            let rowCount = $('.row_count').val();

            // loop through each row
            for (let i = 1; i <= rowCount; i++) {

                // get material id
                let materialId = $('.materialD_' + i).val();

                // get budget info start
                axios.get(route('getProjectMaterialStock'), {
                        params: {
                            project_id: $('#source_project').val(),
                            material_id: materialId,
                        }
                    })
                    .then(function(response) {

                        let data = response.data;

                        $('.budget_' + i).val(data.budget_balance);
                        $('.stock_' + i).val(data.stock_balance);

                    })
                    .catch(function(error) {})
                // get budget info end

            }
        });
    </script>
@endsection

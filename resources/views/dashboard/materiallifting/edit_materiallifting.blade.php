@extends('dashboard.layouts.app')

@section('content')
    @include('dashboard.layouts.partials.error')

    <form action="{{ route('materiallifting.update', $data->materiallifting->id) }}" method="POST">
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
                        'company_id' => $data->materiallifting->company_id,
                    ])

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="system_serial">System Serial</label>
                            <input type="text" id="system_serial" class="form-control"
                                value="{{ $data->materiallifting->system_serial }}" name="system_serial" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lifting_type">Lifting Type</label>
                            <select name="lifting_type" id="lifting_type" class="select2" disabled>

                                <option value="Client Provide To Project" @if ($data->materiallifting->lifting_type == 'Client Provide To Project') selected @endif>
                                    Client Provide To Project</option>

                                <option value="Local Lifting To Project" @if ($data->materiallifting->lifting_type == 'Local Lifting To Project') selected @endif>
                                    Local Lifting To Project</option>

                                <option value="Product Lifting To Central Store"
                                    @if ($data->materiallifting->lifting_type == 'Product Lifting To Central Store') selected @endif>Product Lifting To Central Store
                                </option>

                                <option value="Client Provide To Central Store"
                                    @if ($data->materiallifting->lifting_type == 'Client Provide To Central Store') selected @endif>Client Provide To Central Store
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Voucher Date</label>
                            <input type="text" id="date" name="voucher_date" class="form-control datepicker"
                                value="{{ date('d-m-Y', strtotime($data->materiallifting->vouchar_date)) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <input type="text" class="form-control" value="{{ $data?->projects?->project_name }}"
                                disabled>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit">Unit</label>
                            <input type="text" id="unit" name="unit" value="{{ $data?->unit?->name }}"
                                class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <input type="text" id="unit" name="unit" value="{{ $data?->tower?->name }}"
                                class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select name="vendor" id="vendor" class="select2" readonly="true">
                                <option value="">Select Vendor</option>
                                @foreach ($data->vendors as $vendor)
                                    <option value="{{ $vendor->id }}" @if ($vendor->id == $data->materiallifting->vendor_id) selected @endif>
                                        {{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="voucher_no">Voucher No</label>
                            <input type="text" id="voucher_no" name="voucher"
                                value="{{ $data->materiallifting->voucher }}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="logistics_associate">Logistics Associate</label>
                            <input type="text" id="unit" name="unit"
                                value="{{ $data?->logistics_vendor?->name }}" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="truck_no">Truck No</label>
                            <input type="text" id="truck_no" name="truck_no"
                                value="{{ $data->materiallifting->truck_no }}" class="form-control">
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12" style="overflow-y: auto">
                        <div style="overflow-x: auto;height: 500px">
                            <table class="table table-striped gridTable mobile-changes">
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
                                    <?php
                                    $i = 0;
                                    $countItem = count($data->materialliftingMaterials);
                                    foreach ($data->materialliftingMaterials as $item)
                                    {
                                        $i++;
                                    ?>
                                    <tr id="itemRow_{{ $i }}">
                                        <td class="pl-0">
                                            <select class="form-control form-control-danger chosen-select"
                                                name="material_id[]" required="">
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
                                                    {{ $material->name }} ({{ $material->code }}) /
                                                    {{ $material->materialUnit->name }}
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
                                                class="form-control rate_{{ $i }}" type="number"
                                                step="any" name="rate[]" value="{{ $item->material_rate }}"
                                                oninput="totalAmount({{ $i }})" required>
                                        </td>

                                        <td>
                                            <input style="text-align: center;"
                                                class="form-control amount amount_{{ $i }}" type="number"
                                                step="any" name="amount[]"
                                                value="{{ $item->material_qty * $item->material_rate }}" required
                                                readonly>
                                        </td>

                                        <td><input class="form-control remarks remarks_{{ $i }}"
                                                type="text" name="remarks[]" value="{{ $item->remarks }}"></td>

                                        <td align="center">
                                            @if ($i > 1)
                                                <span class="btn btn-block btn-danger item_remove"
                                                    onclick="itemRemove('{{ $i }}')"><i
                                                        class="fa fa-trash"></i>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>
                                            <p class='text-right mb-0 mt-2'>Total Quantity</p>
                                        </th>
                                        <th>
                                            <input class="form-control total_qty text-center" type="number"
                                                step="any" name="total_qty"
                                                value="{{ $data->materiallifting->totalQty() }}" readonly>
                                        </th>
                                        <th>
                                            <p class='text-right mb-0 mt-2'>Total Amount</p>
                                        </th>
                                        <th>
                                            <input class="form-control total_amount text-center" type="number"
                                                step="any" name="total_amount"
                                                value="{{ $data->materiallifting->totalAmount() }}" readonly>
                                        </th>

                                        <th align="center">
                                            <input type="hidden" class="row_count" value="{{ $i }}">
                                            <span class="btn btn-block btn-success add_item">
                                                <i class="fa fa-plus-circle"></i> Add More
                                            </span>
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
                <option value="{{ $material->id }}">{{ $material->name }} ({{ $material->code }}) /
                    {{ $material->materialUnit->name }}</option>
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
                '<td class="pl-0">' +
                '<select name="material_id[]" class="form-control chosen-select itemList_' + total + '">' +
                '</select>' +
                '</td>' +
                '<td><input style="text-align: center;" class="form-control qty qty_' + total +
                '" type="number" step="any" name="qty[]" value="1" required oninput="totalAmount(' + total +
                ')"></td>' +
                '<td><input style="text-align: center;" class="form-control rate_' + total +
                '" type="number" step="any" name="rate[]" value="0" required oninput="totalAmount(' + total +
                ')"></td>' +
                '<td><input style="text-align: center;" class="form-control amount amount_' + total +
                '" type="number" step="any" name="amount[]" value="0" required readonly></td>' +
                '<td align="center"><span class="btn btn-danger btn-block item_remove" onclick="itemRemove(' +
                total + ')"><i class="fa fa-trash"></i></span></td>' +
                '</tr>');
            $('.row_count').val(total);

            var itemList = $("#itemList div select").html();
            $('.itemList_' + total).html(itemList);
            $('.chosen-select').chosen();
            $('.chosen-select').trigger("chosen:updated");

            // var unitList = $("#unitList div select").html();
            // $('.unitList_'+total).html(unitList);
            // $('.chosen-select').chosen();
            // $('.chosen-select').trigger("chosen:updated");

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
@endsection

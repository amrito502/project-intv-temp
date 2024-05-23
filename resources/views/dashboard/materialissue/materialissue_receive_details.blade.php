@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('material.receive', $data->materialissue->id) }}" method="POST">
    @csrf

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Edit Material Issue</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Edit Material Issue</h3>
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
                    'company_id' => $data->materialissue->company_id,
                    ])

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="system_serial">System Serial</label>
                            <input type="text" id="system_serial" class="form-control"
                                value="{{ $data->materialissue->system_serial }}" name="system_serial" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="source_project">Source Project</label>
                            <select name="source_project" id="source_project" class="select2" disabled>
                                <option value="">Select Project</option>

                                <option value="999999" @if (999999==$data->materialissue->source_project_id)
                                    selected
                                    @endif
                                    >Central Store</option>

                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}" @if ($project->id ==
                                    $data->materialissue->source_project_id)
                                    selected
                                    @endif
                                    >{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select name="project" id="project" class="select2" disabled>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}" @if ($project->id ==
                                    $data->materialissue->project_id)
                                    selected
                                    @endif>{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date">Issue Date</label>
                            <input type="text" id="date" name="issue_date" class="form-control datepicker"
                                value="{{ date('d-m-Y', strtotime($data->materialissue->issue_date)) }}" disabled>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="receive_by">Receive By</label>
                            <input type="text" id="receive_by" name="receive_by" class="form-control" required>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12" style="overflow-y: auto">
                        <div style="overflow-x: auto;height: 500px">
                            <table class="table table-striped gridTable mobile-changes">
                                <thead>
                                    <tr>
                                        <th width="40%">Material Name & Code</th>
                                        <th width="16%">Quantity</th>
                                        <th>UOM</th>
                                        <th>Receive</th>
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
                                    <tr id="itemRow_{{$i}}">
                                        <td style="padding-left: 0;">
                                            <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                            <select class="form-control form-control-danger select2"
                                                name="material_id_old[]" required="" disabled>
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
                                                <option {{$selected}} value="{{$material->id}}">
                                                    {{$material->name}}
                                                </option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input style="text-align: right;" class="form-control qty qty_{{$i}}"
                                                type="number" step="any" name="qty[]" value="{{$item->material_qty}}"
                                                oninput="totalAmount({{$i}})" required readonly>
                                        </td>

                                        {{-- <td>
                                            <input style="text-align: right;" class="form-control rate_{{$i}}"
                                                type="number" step="any" name="rate[]" value="{{$item->material_rate}}"
                                                oninput="totalAmount({{$i}})" required>
                                        </td> --}}

                                        <td>
                                            <input type="hidden" name="unit_id[]" value="{{ $item->unit_id }}">
                                            <select class="form-control form-control-danger select2"
                                                name="unit_id_old[]" required="" disabled>
                                                {{-- <option value=" ">Select UOM</option> --}}
                                                <?php
                                                foreach ($data->units as $unit)
                                                {
                                                    if($item->material->materialUnit->id == $unit->id)
                                                    {
                                                        $selected = "selected";
                                                    }
                                                    else
                                                    {
                                                        $selected = "";
                                                    }
                                                ?>
                                                <option {{$selected}} value="{{$unit->id}}">{{$unit->name}}</option>
                                                <?php
                                                }
                                            ?>
                                            </select>
                                        </td>

                                        {{-- <td>
                                            <input style="text-align: right;" class="form-control amount amount_{{$i}}"
                                                type="number" step="any" name="amount[]"
                                                value="{{$item->material_qty * $item->material_rate}}" required
                                                readonly>
                                        </td> --}}

                                        <td align="center" style="padding-right: 0;">
                                            {{-- @if ($i > 1)
                                            <span class="btn btn-block btn-danger item_remove"
                                                onclick="itemRemove('{{ $i }}')"><i class="fa fa-trash"></i>
                                                Delete</span>
                                            @endif --}}
                                            <input style="text-align: right;"
                                                class="form-control receive_qty receive_qty_{{$i}}" type="number"
                                                step="any" name="receive_qty[{{ $item->id }}]"
                                                value="{{$item->material_qty}}" oninput="totalAmount({{$i}})" required>
                                        </td>

                                    </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>Total Quantity</th>
                                        <th>
                                            <input class="form-control total_qty text-right" type="number" step="any"
                                                name="total_qty" value="{{$data->materialissue->totalQty()}}" readonly>
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
            <option value="{{$material->id}}">{{$material->name}} ({{$material->code}})</option>
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
            <option value="{{$unit->id}}">{{$unit->name}}</option>
            <?php
                }
            ?>
        </select>
    </div>
</div>

@endsection

@section('custom-script')
<script type="text/javascript">
    $(".add_item").click(function () {
        var row_count = $('.row_count').val();
        var total = parseInt(row_count) + 1;
        $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
            '<td>'+
            '<select name="material_id[]" class="form-control chosen-select itemList_'+total+'">'+
            '</select>'+
            '</td>'+
            '<td><input style="text-align: right;" class="form-control qty qty_'+total+'" type="number" step="any" name="qty[]" value="1" required oninput="totalAmount('+total+')"></td>'+
            // '<td><input style="text-align: right;" class="form-control rate_'+total+'" type="number" step="any" name="rate[]" value="0" required oninput="totalAmount('+total+')"></td>'+
            '<td>'+
            '<select name="unit_id[]" class="form-control chosen-select unitList_'+total+'">'+
            '</select>'+
            '</td>'+
            // '<td><input style="text-align: right;" class="form-control amount amount_'+total+'" type="number" step="any" name="amount[]" value="0" required readonly></td>'+
            '<td align="center"><span class="btn btn-danger btn-block item_remove" onclick="itemRemove(' + total + ')"><i class="fa fa-trash"></i> Delete</span></td>'+
            '</tr>');
        $('.row_count').val(total);

        var itemList = $("#itemList div select").html();
        $('.itemList_'+total).html(itemList);
        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        var unitList = $("#unitList div select").html();
        $('.unitList_'+total).html(unitList);
        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        row_sum();
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
        var qty = $(".qty_" + i).val();
        var rate = $(".rate_" + i).val();
        var sum_total = parseFloat(qty) *parseFloat(rate);
        $(".amount_" + i).val(sum_total.toFixed(4));
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

        $('.total_qty').val(total_qty.toFixed(4));
        $('.total_amount').val(total_amount.toFixed(4));
    }
</script>
@endsection

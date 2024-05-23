<div class="row">
    <div class="col-md-12 budgethead-table-here">
        <div style="overflow-x: auto; max-height: 500px;">
            <table class="table gridTable mobile-changes">
                <thead>
                    <tr>
                        <th>Material Name & Code</th>
                        <th width="150px" class="text-center">Stock Qty</th>
                        <th width="150px" class="text-center">Design Qty</th>
                        <th class="text-center" width="150px">Use Quantity</th>
                        <th width="150px" class="text-center">Design Diff</th>
                        <th width="380px" class="">Remarks</th>
                        <th width="200px" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody id="tbody">
                    @php
                        $rowCount = 0;
                    @endphp
                    @foreach ($dailyconsumptionItems as $dailyconsumptionItem)
                        @php
                            $rowCount++;
                        @endphp
                        <tr id="itemRow_{{ $dailyconsumptionItem->id + 1000 }}">

                            <td class="pl-0">
                                <select name="budgetHeadIds[]"
                                    onchange="updateItemRow(event, '{{ $dailyconsumptionItem->id + 1000 }}')"
                                    class="form-control chosen-select itemList itemList_{{ $dailyconsumptionItem->id + 1000 }}"
                                    item-id="{{ $dailyconsumptionItem->id + 1000 }}" row-count="{{ $rowCount }}">
                                    <?php
                                foreach ($data->budgetHeads as $budgetHead)
                                {
                                    if($budgetHead->id == $dailyconsumptionItem->budget_head_id)
                                    {
                                        $selected = "selected";
                                    }
                                    else
                                    {
                                        $selected = "";
                                    }
                            ?>
                                    <option value="{{ $budgetHead->id }}"
                                        material-id="{{ $budgetHead->materialInfo()->id }}" {{ $selected }}>
                                        {{ $budgetHead->name }}
                                        ({{ $budgetHead->materialInfo()->code }})
                                    </option>

                                    <?php
                                }
                            ?>
                                </select>
                            </td>

                            <td>
                                <input
                                    class="text-center form-control stock stock_{{ $dailyconsumptionItem->id + 1000 }}"
                                    type="number" step="any" name="stock_balance[]" value="0" readonly>
                            </td>
                            <td>
                                <input
                                    class="text-center form-control design_stock design_stock_{{ $dailyconsumptionItem->id + 1000 }}"
                                    iteration="{{ $dailyconsumptionItem->id + 1000 }}" type="number" step="any"
                                    name="design_stock_balance[]" value="" readonly>

                                <input type="hidden" class="original_design_stock"
                                    id="original_design_stock_{{ $dailyconsumptionItem->id + 1000 }}" value="">
                            </td>


                            <td>
                                <input style="text-align: center;"
                                    class="form-control qty qty_{{ $dailyconsumptionItem->id + 1000 }}" type="number"
                                    step="any" name="consumption_qty[]"
                                    oninput="totalAmount('{{ $dailyconsumptionItem->id + 1000 }}')"
                                    value="{{ $dailyconsumptionItem->use_qty }}" required>
                            </td>

                            <td>
                                <input
                                    class="text-center form-control design_balance design_balance_{{ $dailyconsumptionItem->id + 1000 }}"
                                    type="number" step="any" name="design_balance[]" value="0" disabled>

                            </td>

                            <td>
                                <input class="form-control remarks remarks_{{ $dailyconsumptionItem->id + 1000 }}"
                                    type="text" step="any" name="remarks[]"
                                    value="{{ $dailyconsumptionItem->remarks }}">
                            </td>


                            <td align="center">
                                <span class="btn btn-success" onclick="addItem()">
                                    <i class="fa fa-plus" aria-hidden="true" style="font-size: 20px"></i>
                                </span>
                                <span class="btn btn-danger item_remove"
                                    onclick="itemRemove('{{ $dailyconsumptionItem->id + 1000 }}')">
                                    <i class="fa fa-trash" style="font-size: 20px"></i>
                                </span>
                            </td>

                        </tr>
                    @endforeach
                    <input type="hidden" class="row_count" value="{{ $rowCount }}">
                </tbody>

                {{-- <tfoot>
                    <tr>
                        <th></th>

                        <th>
                            <input type="hidden" class="row_count" value="1">
                            <p class='text-right mb-0 mt-1'>Total Quantity</p>
                        </th>
                        <th>
                            <input class="total_qty form-control text-right" type="number" step="any" name="total_qty"
                                value="0" readonly>
                        </th>

                        <th align="center">
                        </th>

                    </tr>
                </tfoot> --}}

            </table>

        </div>

    </div>
</div>

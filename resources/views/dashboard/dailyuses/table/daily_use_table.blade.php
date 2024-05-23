<div class="row">
    <div class="col-md-12 budgethead-table-here" style="overflow-y: auto">

        <table class="table gridTable mobile-changes">
            <thead>
                <tr>
                    <th>Material Name & Code</th>
                    <th width="300px">UOM</th>
                    <th width="300px">Quantity</th>
                    <th width="200px">Used Qty</th>
                </tr>
            </thead>

            <tbody id="tbody">

                @foreach ($dailyconsumptionItems as $dailyconsumptionItem)

                <tr id="itemRow_{{ $dailyconsumptionItem->id + 1000 }}">

                    <td>
                        <select name="budgetHeadIds[]"
                            onchange="updateItemRow(event, '{{ $dailyconsumptionItem->id + 1000 }}')"
                            class="form-control chosen-select itemList itemList_{{ $dailyconsumptionItem->id + 1000 }}" disabled>
                            <?php
                                foreach ($budgetHeads as $budgetHead)
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
                            <option value="{{ $budgetHead->id }}" {{ $selected }}>{{ $budgetHead->name }}</option>

                            <?php
                                }
                            ?>
                        </select>
                    </td>

                    <td>
                        <select name="unit_id[]"
                            class="form-control chosen-select unitList_{{ $dailyconsumptionItem->id + 1000 }}" disabled>

                            <?php
                            foreach ($data->units as $unit)
                            {
                                // ->materialInfo()->unit
                            if($unit->id == $dailyconsumptionItem->budgetHead->materialInfo()->unit)
                            {
                                $selected = "selected";
                            }
                            else
                            {
                                $selected = "";
                            }


                        ?>
                            <option value="{{$unit->id}}" {{ $selected }}>{{$unit->name}}</option>
                            <?php
                            }
                        ?>
                        </select>
                    </td>

                    <td>
                        <input style="text-align: right;"
                            class="form-control qty qty_{{ $dailyconsumptionItem->id + 1000 }}" type="number" step="any"
                            name="consumption_qty[]" oninput="totalAmount('{{ $dailyconsumptionItem->id + 1000 }}')"
                            value="{{ $dailyconsumptionItem->consumption_qty }}" disabled>
                    </td>

                    <td align="center">
                        <input style="text-align: right;"
                            class="form-control used_qty used_qty_{{ $dailyconsumptionItem->id + 1000 }}" type="number" step="any"
                            name="consumption_used_qty[{{ $dailyconsumptionItem->id }}]" value="{{ $dailyconsumptionItem->consumption_used_qty }}" required>
                    </td>

                </tr>

                @endforeach

            </tbody>

            <tfoot>
                <tr>
                    <th></th>

                    <th>
                        <input type="hidden" class="row_count" value="1">
                        <p class='text-right mb-0 mt-1'>Total Quantity</p>
                    </th>
                    <th>
                        <input class="total_qty form-control text-right" type="number" step="any" name="total_qty" value="0"
                            readonly>
                    </th>

                    <th align="center">
                    </th>

                </tr>
            </tfoot>
        </table>

    </div>
</div>

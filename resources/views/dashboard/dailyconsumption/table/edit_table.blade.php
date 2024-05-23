<div class="row">
    <div class="col-md-12 budgethead-table-here">

        <div style="overflow-x: auto;height: 500px">

            <table class="table gridTable mobile-changes">
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
                                class="form-control chosen-select itemList item_count_{{ $rowCount }} itemList_{{ $dailyconsumptionItem->id + 1000 }}">
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
                                <option value="{{ $budgetHead->id }}"
                                    material-id="{{ $budgetHead->materialInfo()->id }}" {{ $selected }}>{{
                                    $budgetHead->name }}</option>

                                <?php
                                }
                            ?>
                            </select>
                        </td>

                        <td class="d-none">
                            <select name="unit_id[]"
                                class="form-control chosen-select unitList_{{ $dailyconsumptionItem->id + 1000 }}"
                                disabled>

                                <?php
                            foreach ($data->units as $unit)
                            {
                            if(@$unit->id == @$dailyconsumptionItem->budgetHead->materialInfo()->unit)
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
                            <input style="text-align: center;"
                                class="form-control qty qty_{{ $dailyconsumptionItem->id + 1000 }}" type="number"
                                step="any" name="consumption_qty[]"
                                oninput="totalAmount('{{ $dailyconsumptionItem->id + 1000 }}')"
                                value="{{ $dailyconsumptionItem->issue_qty }}" required>
                        </td>

                        <td>
                            <input style="text-align: center;"
                                class="form-control budget budget_count_{{ $rowCount }} budget_{{ $dailyconsumptionItem->id + 1000 }}" type="text"
                                step="any" name="budget_balance[]" value="0" readonly>
                        </td>
                        <td>
                            <input style="text-align: center;"
                                class="form-control stock stock_count_{{ $rowCount }} stock_{{ $dailyconsumptionItem->id + 1000 }}" type="text"
                                step="any" name="stock_balance[]" value="0" readonly>
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

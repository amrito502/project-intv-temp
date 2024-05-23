@php
$grandTotalBudgetQty = 0;
$grandTotalTableLiftingQty = 0;
// $grandTotalTableIssueQty = 0;
$grandTotalInStockQty = 0;
$grandTotalUsedQty = 0;
$grandTotalBudgetValue = 0;
$grandTotalBudgetUsedValue = 0;
@endphp

@foreach ($data->report as $table)
@php
    if(!(count($table['table_data']['self_define_cost']['items']) || count($table['table_data']['material_data']['items']))){
        continue;
    }
@endphp

@php
$totalTableBudgetQty = 0;
$totalTableLiftingQty = 0;
// $totalTableIssueQty = 0;
$totalInStockQty = 0;
$totalTableUsedQty = 0;
$totalTableBudgetValue = 0;
$totalTableBudgetUsedValue = 0;
@endphp


<table class="table table-hover table-bordered mt-2">

    <thead>
        <tr style="font-size: 17px;">
            <th colspan="4" style="text-align: center;">Unit Name: {{ $table['table_title']['unit_name'] }}</th>
            {{-- <th colspan="5" style="text-align: center;">By Quantity</th> --}}
            {{-- <th colspan="3" style="text-align: center;">By Value</th> --}}
        </tr>
        <tr class="heading-color-two">
            <th></th>
            <th class="vertical-center-text">
                <p class="mb-0">Material Name</p>
            </th>
            <th>Budget Qty</th>
            {{-- <th>Project Issue</th> --}}
            {{-- <th>Issue Qty</th> --}}
            {{-- <th>Project Uses</th> --}}
            {{-- <th>Project Stock</th> --}}
            {{-- <th>Pending Budget</th> --}}
            <th>Budget Value</th>
            {{-- <th>Used Value</th> --}}
            {{-- <th>Pending</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($table['table_data']['material_data']['items'] as $item)

        @php
        $totalTableBudgetQty += $item['budget_qty'];
        $totalTableLiftingQty += $item['project_issue'];
        // $totalTableIssueQty += $item['issue_qty'];
        $totalInStockQty += $item['in_stock'];
        $totalTableUsedQty += $item['used_qty'];
        $totalTableBudgetValue += $item['budget_value'];
        $totalTableBudgetUsedValue += $item['used_value'];
        @endphp

        @php
        $grandTotalBudgetQty += $item['budget_qty'];
        $grandTotalTableLiftingQty += $item['project_issue'];
        // $grandTotalTableIssueQty += $item['issue_qty'];
        $grandTotalInStockQty += $item['in_stock'];
        $grandTotalUsedQty += $item['used_qty'];
        $grandTotalBudgetValue += $item['budget_value'];
        $grandTotalBudgetUsedValue += $item['used_value'];
        @endphp

        <tr>
            @if ($loop->first)
            <td rowspan="{{ count($table['table_data']['material_data']['items']) }}"
                style="vertical-align: middle;text-align: center;">
                {{ $table['table_data']['material_data']['column_type_data']['title'] }}
            </td>
            @endif

            <td>{{ $item['material_name'] }}</td>
            <td>{{ $item['budget_qty'] }}</td>
            {{-- <td>{{ $item['project_issue'] }}</td> --}}
            {{-- <td>{{ $item['issue_qty'] }}</td> --}}
            {{-- <td>{{ $item['used_qty'] }}</td> --}}
            {{-- <td>{{ $item['in_stock'] }}</td> --}}
            {{-- <td>{{ $item['budget_pending'] }}</td> --}}
            <td>{{ $item['budget_value'] }}</td>
            {{-- <td>{{ $item['used_value'] }}</td> --}}
            {{-- <td>{{ $item['pending_value'] }}</td> --}}
        </tr>
        @endforeach
    </tbody>

    <thead>
        <tr class="heading-color-four">
            <th></th>
            <th>Cost Name</th>
            <th>Budget Qty</th>
            {{-- <th>Project Issue</th> --}}
            {{-- <th>Issue Qty</th> --}}
            {{-- <th>Rate</th> --}}
            {{-- <th>Project Stock</th> --}}
            {{-- <th>Pending Budget</th> --}}
            <th>Budget Value</th>
            {{-- <th>Expense</th> --}}
            {{-- <th>Pending</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($table['table_data']['self_define_cost']['items'] as $item)

        @php
        $totalTableBudgetQty += $item['budget_qty'];
        $totalTableLiftingQty += $item['project_issue'];
        // $totalTableIssueQty += $item['issue_qty'];
        $totalInStockQty += $item['in_stock'];
        $totalTableUsedQty += $item['used_qty'];
        $totalTableBudgetValue += $item['budget_value'];
        $totalTableBudgetUsedValue += $item['used_value'];
        @endphp

        @php
        $grandTotalBudgetQty += $item['budget_qty'];
        $grandTotalTableLiftingQty += $item['project_issue'];
        // $grandTotalTableIssueQty += $item['issue_qty'];
        $grandTotalInStockQty += $item['in_stock'];
        $grandTotalUsedQty += $item['used_qty'];
        $grandTotalBudgetValue += $item['budget_value'];
        $grandTotalBudgetUsedValue += $item['used_value'];
        @endphp

        <tr>
            @if ($loop->first)
            <td rowspan="{{ count($table['table_data']['self_define_cost']['items']) }}"
                style="vertical-align: middle;text-align: center;">
                {{ $table['table_data']['self_define_cost']['column_type_data']['title'] }}
            </td>
            @endif

            <td>{{ $item['material_name'] }}</td>
            <td>{{ $item['budget_qty'] }}</td>
            {{-- <td>{{ $item['project_issue'] }}</td> --}}
            {{-- <td>{{ $item['issue_qty'] }}</td> --}}
            {{-- <td>{{ $item['used_qty'] }}</td> --}}
            {{-- <td>{{ $item['in_stock'] }}</td> --}}
            {{-- <td>{{ $item['budget_pending'] }}</td> --}}
            <td>{{ $item['budget_value'] }}</td>
            {{-- <td>{{ $item['used_value'] }}</td> --}}
            {{-- <td>{{ $item['pending_value'] }}</td> --}}
        </tr>
        @endforeach
    </tbody>

    <tfoot>

        <tr>
            <th colspan="2" class="text-right">Unit Cost</th>
            <th>{{ $totalTableBudgetQty }}</th>
            {{-- <th>{{ $totalTableLiftingQty }}</th> --}}
            {{-- <th>{{ $totalTableIssueQty }}</th> --}}
            {{-- <th>{{ $totalTableUsedQty }}</th> --}}
            {{-- <th>{{ $totalInStockQty }}</th> --}}
            {{-- <th>{{ $totalTableBudgetQty - $totalTableUsedQty }}</th> --}}
            <th>{{ $totalTableBudgetValue }}</th>
            {{-- <th>{{ $totalTableBudgetUsedValue }}</th> --}}
            {{-- <th>{{ $totalTableBudgetValue - $totalTableBudgetUsedValue }}</th> --}}
        </tr>

        @if ($loop->last)
        <tr class="footer-heading">
            <th colspan="2" class="text-right">Grand Total</th>
            <th>{{ $grandTotalBudgetQty }}</th>
            {{-- <th>{{ $grandTotalTableLiftingQty }}</th> --}}
            {{-- <th>{{ $grandTotalTableIssueQty }}</th> --}}
            {{-- <th>{{ $grandTotalUsedQty }}</th> --}}
            {{-- <th>{{ $grandTotalInStockQty }}</th> --}}
            {{-- <th>{{ $grandTotalBudgetQty - $grandTotalUsedQty }}</th> --}}
            <th>{{ $grandTotalBudgetValue }}</th>
            {{-- <th>{{ $grandTotalBudgetValue - $grandTotalBudgetUsedValue }}</th> --}}
            {{-- <th>{{ $grandTotalBudgetValue - $grandTotalBudgetUsedValue }}</th> --}}
        </tr>
        @endif

    </tfoot>

</table>

@endforeach

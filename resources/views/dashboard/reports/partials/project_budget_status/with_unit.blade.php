@php
$grandTotalBudgetQty = 0;
$grandTotalTableLiftingQty = 0;
$grandTotalTableLocalIssueQty = 0;
$grandTotalTableConsumedQty = 0;
// $grandTotalTableIssueQty = 0;
$grandTotalInStockQty = 0;
$grandTotalUsedQty = 0;
$grandTotalTableBudgetPendingValue = 0;
$grandTotalBudgetValue = 0;
$grandTotalBudgetUsedValue = 0;
@endphp

@foreach ($data->report as $table)
@php
if(!(count($table['table_data']['self_define_cost']['items']) &&
count($table['table_data']['material_data']['items']))){
continue;
}
@endphp

@php
$totalTableBudgetQty = 0;
$totalTableLiftingQty = 0;
$totalTableLocalIssueQty = 0;
$totalTableConsumedQty = 0;
// $totalTableIssueQty = 0;
$totalInStockQty = 0;
$totalTableUsedQty = 0;
$totalTableBudgetValue = 0;
$totalTableBudgetPendingValue = 0;
$totalTableBudgetUsedValue = 0;
@endphp


<table class="table table-hover table-bordered mt-2">

    <tbody>
        <tr class="heading-color-one" style="font-size: 17px;">
            <th colspan="2" style="text-align: center;">Unit Name: {{ $table['table_title']['unit_name'] }}</th>
            <th colspan="6" style="text-align: center;">By Quantity</th>
            <th colspan="3" style="text-align: center;">By Value</th>
        </tr>
        <tr class="heading-color-two">
            <th></th>
            <th>
                Material Name
            </th>
            <th>Allocate Budget</th>
            <th>Project Issue</th>
            <th>Local Issue</th>
            <th>Consumed</th>
            <th>Project Stock</th>
            <th>Pending Budget</th>
            <th>Estimated Budget</th>
            <th>Used Value</th>
            <th>Pending</th>
        </tr>
        @foreach ($table['table_data']['material_data']['items'] as $item)

        @php
        $totalTableBudgetQty += $item['budget_qty'];
        $totalTableLiftingQty += $item['project_issue'];
        $totalTableLocalIssueQty += $item['local_issue'];
        $totalInStockQty += $item['in_stock'];
        $totalTableUsedQty += $item['used_qty'];
        $totalTableBudgetValue += $item['budget_value'];
        $totalTableBudgetUsedValue += $item['used_value'];
        $totalTableBudgetPendingValue += $item['budget_pending'];

        $grandTotalTableBudgetPendingValue += $item['budget_pending'];
        $grandTotalBudgetQty += $item['budget_qty'];
        $grandTotalTableLocalIssueQty += $item['local_issue'];
        $grandTotalTableLiftingQty += $item['project_issue'];
        $grandTotalInStockQty += $item['in_stock'];
        $grandTotalUsedQty += $item['used_qty'];
        $grandTotalBudgetValue += $item['budget_value'];
        $grandTotalBudgetUsedValue += $item['used_value'];

        $trClass = "";

        if($item['used_qty'] > $item['budget_qty']){
        $trClass = "text-danger";
        }

        // dd($item['used_qty']);
        @endphp

        <tr class={{ $trClass }}>
            @if ($loop->first)
            <td rowspan="{{ count($table['table_data']['material_data']['items']) }}"
                style="vertical-align: middle;text-align: center;">
                {{ $table['table_data']['material_data']['column_type_data']['title'] }}
            </td>
            @endif

            <td>{{ $item['material_name'] }}</td>
            <td>
                <a target="_blank"
                    href="{{ route('budget.material.details', [$table['table_title']['project_id'], $table['table_title']['unit_id'], $item['material_id']]) }}">
                    {{ $item['budget_qty'] }}
                </a>
            </td>
            <td>
                <a target="_blank"
                    href="{{ route('issueMaterialDetails', [$table['table_title']['project_id'], $table['table_title']['unit_id'], $item['material_id']]) }}">
                    {{ $item['project_issue'] }}
                </a>
            </td>
            <td>
                <a target="_blank"
                    href="{{ route('consumptionMaterialDetails', [$table['table_title']['project_id'], $table['table_title']['unit_id'], $item['material_id']]) }}">
                    {{ $item['local_issue'] }}
                </a>
            </td>
            <td>
                {{ $item['used_qty'] }}
            </td>
            <td>{{ $item['in_stock'] }}</td>
            <td>{{ $item['budget_pending'] }}</td>
            <td>{{ $item['budget_value'] }}</td>
            <td>{{ $item['used_value'] }}</td>
            <td>{{ $item['pending_value'] }}</td>
        </tr>
        @endforeach
    </tbody>

    <tbody>
        <tr class="heading-color-four">
            <th></th>
            <th>Cost Name</th>
            <th>Estimated Qty</th>
            {{-- <th>Project Issue</th> --}}
            <th colspan="2"></th>
            <th>Rate</th>
            <th colspan="2"></th>
            {{-- <th>Project Stock</th>
            <th>Pending Budget</th> --}}
            <th>Estimated Budget</th>
            <th>Expense</th>
            <th>Pending</th>
        </tr>
        @foreach ($table['table_data']['self_define_cost']['items'] as $item)

        @php
        $totalTableBudgetQty += $item['budget_qty'];
        $totalTableLiftingQty += $item['project_issue'];
        // $totalTableIssueQty += $item['issue_qty'];
        $totalInStockQty += $item['in_stock'];
        $totalTableUsedQty += $item['used_qty'];
        $totalTableBudgetValue += $item['budget_value'];
        $totalTableBudgetUsedValue += $item['used_value'];
        $totalTableBudgetPendingValue += $item['budget_pending'];

        $grandTotalTableBudgetPendingValue += $item['budget_pending'];
        $grandTotalBudgetQty += $item['budget_qty'];
        $grandTotalTableLiftingQty += $item['project_issue'];
        $grandTotalInStockQty += $item['in_stock'];
        $grandTotalUsedQty += $item['used_qty'];
        $grandTotalBudgetValue += $item['budget_value'];
        $grandTotalBudgetUsedValue += $item['used_value'];

        $trClass = "";

        if($item['used_value'] > $item['budget_value']){
        $trClass = "text-danger";
        }
        @endphp

        <tr class="{{ $trClass }}">
            @if ($loop->first)
            <td rowspan="{{ count($table['table_data']['self_define_cost']['items']) }}"
                style="vertical-align: middle;text-align: center;">
                {{ $table['table_data']['self_define_cost']['column_type_data']['title'] }}
            </td>
            @endif

            <td>{{ $item['material_name'] }}</td>
            <td>
                <a target="_blank"
                    href="{{ route('budget.material.details', [$table['table_title']['project_id'], $table['table_title']['unit_id'], $item['material_id']]) }}">
                    {{ $item['budget_qty'] }}
                </a>
            </td>
            {{-- <td>
                <a target="_blank"
                    href="{{ route('issueMaterialDetails', [$table['table_title']['project_id'], $table['table_title']['unit_id'], $item['material_id']]) }}">
                    {{ $item['project_issue'] }}
                </a>
            </td> --}}
            <td colspan="2"></td>
            <td>{{ $item['used_qty'] }}</td>
            <td colspan="2"></td>
            {{-- <td>{{ $item['in_stock'] }}</td>
            <td>{{ $item['budget_pending'] }}</td> --}}
            <td>{{ $item['budget_value'] }}</td>
            <td>{{ $item['used_value'] }}</td>
            <td>{{ $item['pending_value'] }}</td>
        </tr>
        @endforeach
    </tbody>

    <tbody>
        <tr class="heading-color-four">
            <th></th>
            <th>Owner Name</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Owner Demand</th>
            <th>Total</th>
            <th>Advance Paid</th>
            <th>Pending</th>
        </tr>
        @foreach ($table['table_data']['roa_cost']['items'] as $item)

        @php
        $totalTableBudgetQty += $item['budget_qty'];
        $totalTableLiftingQty += $item['project_issue'];
        $totalInStockQty += $item['in_stock'];
        $totalTableUsedQty += $item['used_qty'];
        // $totalTableBudgetValue += $item['budget_value'];
        // $totalTableBudgetUsedValue += $item['used_value'];

        $grandTotalBudgetQty += $item['budget_qty'];
        $grandTotalTableLiftingQty += $item['project_issue'];
        $grandTotalInStockQty += $item['in_stock'];
        $grandTotalUsedQty += $item['used_qty'];
        // $grandTotalBudgetValue += $item['budget_value'];
        // $grandTotalBudgetUsedValue += $item['used_value'];
        @endphp

        <tr>
            @if ($loop->first)
            <td rowspan="{{ count($table['table_data']['roa_cost']['items']) }}"
                style="vertical-align: middle;text-align: center;">
                {{ $table['table_data']['roa_cost']['column_type_data']['title'] }}
            </td>
            @endif

            <td>{{ $item['material_name'] }}</td>
            <td>{{ $item['budget_qty'] }}</td>
            <td>{{ $item['project_issue'] }}</td>
            <td></td>
            <td>{{ $item['used_qty'] }}</td>
            <td>{{ $item['in_stock'] }}</td>
            <td>0</td>
            <td>{{ $item['budget_value'] }}</td>
            <td>{{ $item['used_value'] }}</td>
            <td>{{ $item['pending_value'] }}</td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>

        {{-- <tr>
            <th colspan="2" class="text-right">Unit Cost</th>
            <th>{{ $totalTableBudgetQty }}</th>
            <th>{{ $totalTableLiftingQty }}</th>
            <th></th>
            <th>{{ $totalTableUsedQty }}</th>
            <th>{{ $totalInStockQty }}</th>
            <th>{{ $totalTableBudgetPendingValue }}</th>
            <th>{{ $totalTableBudgetValue }}</th>
            <th>{{ $totalTableBudgetUsedValue }}</th>
            <th>{{ $totalTableBudgetValue - $totalTableBudgetUsedValue }}</th>
        </tr> --}}

        {{-- @if ($loop->last)
        <tr class="footer-heading">
            <th colspan="2" class="text-right">Grand Total</th>
            <th>{{ $grandTotalBudgetQty }}</th>
            <th>{{ $grandTotalTableLiftingQty }}</th>
            <th></th>
            <th>{{ $grandTotalUsedQty }}</th>
            <th>{{ $grandTotalInStockQty }}</th>
            <th>{{ $grandTotalTableBudgetPendingValue }}</th>
            <th>{{ $grandTotalBudgetValue }}</th>
            <th>{{ $grandTotalBudgetValue }}</th>
            <th>{{ $grandTotalBudgetValue - $grandTotalBudgetUsedValue }}</th>
        </tr>
        @endif --}}

    </tfoot>

</table>

@endforeach


<table class="table table-hover table-bordered mt-2 no-padding">

    @php
        $statusColor = "bg-success";

        if($grandTotalBudgetUsedValue > $grandTotalBudgetValue){
            $statusColor = "bg-danger";
        }

    @endphp

    <thead>
        <th colspan="4" class="text-center">Project Summary</th>
    </thead>
    <tr>
        <td>Total Budget Qty</td>
        <td>{{ $grandTotalBudgetQty }}</td>
        <td>Pending Budget</td>
        <td>{{ $grandTotalTableBudgetPendingValue }}</td>
    </tr>
    <tr>
        <td>Project Issue</td>
        <td>{{ $grandTotalTableLiftingQty }}</td>
        <td>Estimated Budget</td>
        <td>{{ $grandTotalBudgetValue }}</td>
    </tr>
    <tr>
        <td>Local Issue</td>
        <td>{{ $grandTotalTableLocalIssueQty }}</td>
        <td>Expense</td>
        <td>{{ $grandTotalBudgetUsedValue }}</td>
    </tr>
    <tr>
        <td>Consumed</td>
        <td>{{ $grandTotalUsedQty }}</td>
        <td>Pending</td>
        <td>{{ $grandTotalBudgetValue - $grandTotalBudgetUsedValue }}</td>
    </tr>
    <tr>
        <td>Stock</td>
        <td>{{ $grandTotalInStockQty }}</td>
        <td>Status</td>
        <td class="{{ $statusColor }}"></td>
    </tr>

    {{-- <tr>
        <td>Pending Budget</td>
        <td>{{ $grandTotalTableBudgetPendingValue }}</td>
    </tr> --}}

    {{-- <tr>
        <td>Estimated Budget</td>
        <td>{{ $grandTotalBudgetValue }}</td>
    </tr> --}}

    {{-- <tr>
        <td>Expense</td>
        <td>{{ $grandTotalBudgetUsedValue }}</td>
    </tr> --}}

    {{-- <tr>
        <td>Pending</td>
        <td>{{ $grandTotalBudgetValue - $grandTotalBudgetUsedValue }}</td>
    </tr> --}}

</table>

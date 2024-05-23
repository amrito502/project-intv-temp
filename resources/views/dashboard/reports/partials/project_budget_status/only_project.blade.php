@php
use App\Models\Material;
use App\Models\CashRequisition;
use App\Models\MaterialLifting;
use App\Models\MaterialLiftingMaterial;

$selfDefineUsagesTotal = 0;
$selfDefineUsagesGrandTotal = 0;

$selfDefinePendingTotal = 0;
$selfDefinePendingGrandTotal = 0;

$materialCount = [];
$selfDefinedCount = [];

foreach ($data->planFollowUpReport->projectitems as $item) {

if($item[0]->budgetHead->type == 'Material'){
// $materialCount++;
array_push($materialCount, $item[0]->id);
}else{
// $selfDefinedCount++;
array_push($selfDefinedCount, $item[0]->id);

}

}
@endphp

<table class="table table-hover table-bordered mt-2">

    <thead>
        <tr>
            <th colspan="8">Project Name: {{ $data->planFollowUpReport->project->project_name }}</th>
        </tr>
        <tr class="heading-color-two">
            <th></th>
            <th>Material / Self Define Cost</th>
            <th>Budget Qty</th>
            <th>Usage Qty</th>
            <th>Pending Qty</th>
            <th>Budget Value</th>
            <th>Usage Value</th>
            <th>Pending Value</th>
        </tr>
    </thead>

    <tbody>

        @php
        $grandTotalQty = 0;
        $grandTotalAmount = 0;

        $materialTotalQty = 0;
        $materialTotalAmount = 0;

        $totalUsedQty = 0;

        $liftingIds = MaterialLifting::where('project_id',
        $data->planFollowUpReport->project->id)->select(['id'])->get()->pluck('id')->toArray();

        @endphp
        @foreach ($data->planFollowUpReport->projectitems as $item)

        @php
        if($item[0]->budgetHead->type != 'Material'){
        continue;
        }
        @endphp

        <tr>
            @if ($loop->first)
            <td rowspan="{{ count($materialCount) }}" style="vertical-align: middle;text-align: center;">Material Cost
            </td>
            @endif
            <td>{{ $item[0]->budgetHead->name }}( {{ $item[0]?->unit_of_measurement?->name }} )</td>
            <td>{{ $item->sum('qty') }}</td>
            <td>
                @php
                $material_name = $item[0]->budgetHead->name;
                $materialId = Material::where('name', 'LIKE', "%$material_name%")->select('id')->first()->id;

                $usedQty = MaterialLiftingMaterial::whereIn('material_lifting_id', $liftingIds)->where('material_id',
                $materialId)->sum('material_qty');

                $totalUsedQty += $usedQty;
                @endphp

                {{ $usedQty }}
            </td>
            <td>
                @php
                    $pendingQty = $item->sum('qty') - $usedQty;
                @endphp

                {{ $pendingQty }}
            </td>
            <td>{{ $item->sum('amount') }}</td>
            <td>0</td>
            <td>0</td>
        </tr>

        @php
        $grandTotalQty += $item->sum('qty');
        $grandTotalAmount += $item->sum('amount');

        $materialTotalQty += $item->sum('qty');
        $materialTotalAmount += $item->sum('amount');
        @endphp

        @endforeach

        {{-- <tr class="heading-color-two">
            <th colspan="2">Material Cost Subtotal</th>
            <th>{{ $materialTotalQty }}</th>
            <th>
                {{ $totalUsedQty }}
            </th>
            <th></th>
            <th>{{ $materialTotalAmount }}</th>
            <th></th>
            <th></th>
        </tr> --}}

    </tbody>

    <tbody>
        @php
        $selfDefineTotalQty = 0;
        $selfDefineTotalAmount = 0;
        $showSelfDefineLabelColumn = 1;
        @endphp
        @foreach ($data->planFollowUpReport->projectitems as $item)

        @php

        if($item[0]->budgetHead->type == 'Material'){
        continue;
        }
        // dd($item);
        @endphp

        <tr>
            @if ($showSelfDefineLabelColumn)
            <td rowspan="{{ count($selfDefinedCount) }}" style="vertical-align: middle;text-align: center;">Self Define
                Cost</td>

            @php
            $showSelfDefineLabelColumn = 0;
            @endphp
            @endif
            <td>{{ $item[0]->budgetHead->name }} {{ ($item[0]?->unit_of_measurement?->name) }}</td>
            <td>{{ $item->sum('qty') }}</td>
            <td>0</td>
            <td>0</td>
            <td>{{ $item->sum('amount') }}</td>
            <td>
                {{-- query start --}}
                @php
                $usage_amount = CashRequisition::where('project_id', request()->project)->where('budgethead_id',
                $item[0]->budgetHead->id )->sum('payment_amount');
                $selfDefineUsagesTotal += $usage_amount;
                $selfDefineUsagesGrandTotal += $usage_amount;
                @endphp
                {{-- query end --}}

                {{ $usage_amount }}
            </td>
            <td>
                @php
                $pending_amount =$item->sum('amount') - $usage_amount;
                @endphp

                {{ $pending_amount }}
            </td>
        </tr>

        @php
        $grandTotalQty += $item->sum('qty');
        $grandTotalAmount += $item->sum('amount');

        $selfDefineTotalQty += $item->sum('qty');
        $selfDefineTotalAmount += $item->sum('amount');

        $selfDefinePendingTotal += $pending_amount;
        $selfDefinePendingGrandTotal += $pending_amount;

        @endphp

        @endforeach

        {{-- <tr>
            <td colspan="2">Self Define Cost Subtotal</td>
            <td>{{ $selfDefineTotalQty }}</td>
            <td></td>
            <td></td>
            <td>{{ $selfDefineTotalAmount }}</td>
            <td>{{ $selfDefineUsagesTotal }}</td>
            <td>{{ $selfDefinePendingTotal }}</td>
        </tr> --}}

    </tbody>

    <tfoot>

        <tr>
            <th colspan="2">Cost GrandTotal</th>
            <th>{{ $grandTotalQty }}</th>
            <th>{{ $totalUsedQty }}</th>
            <th>{{ $grandTotalQty - $totalUsedQty }}</th>
            <th>{{ $grandTotalAmount }}</th>
            <th>{{ $selfDefineUsagesGrandTotal }}</th>
            <th>{{ $selfDefinePendingGrandTotal }}</th>
        </tr>

    </tfoot>
</table>


{{-- <table class="table table-hover table-bordered mt-2">
    <thead>
        <tr>
            <th colspan="2">Grand Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Total Qty: </td>
            <td>{{ $grandTotalQty }}</td>
        </tr>
        <tr>
            <td>Total Amount: </td>
            <td>{{ $grandTotalAmount }}</td>
        </tr>
    </tbody>
</table> --}}

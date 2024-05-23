<table class="table table-hover table-bordered mt-2">

    <thead>
        <tr>
            <th colspan="4">Project Name: {{ $data->planFollowUpReport->project->project_name }}</th>
        </tr>
        <tr class="heading-color-two">
            <th></th>
            <th>Material Name</th>
            <th>Qty</th>
            <th>Value</th>
        </tr>
    </thead>

    <tbody>

        @php
        $grandTotalQty = 0;
        $grandTotalAmount = 0;
        @endphp


        @php
        $materialTotalQty = 0;
        $materialTotalAmount = 0;
        @endphp
        @foreach ($data->planFollowUpReport->projectitems as $item)

        @php
        if($item[0]->budgetHead->type != 'Material'){
        continue;
        }
        @endphp

        <tr>
            <td>{{ $item[0]->budgetHead->type }}</td>
            <td>{{ $item[0]->budgetHead->name }} ({{ $item[0]?->unit_of_measurement?->name }})</td>
            <td>{{ $item->sum('qty') }}</td>
            <td>{{ $item->sum('amount') }}</td>
        </tr>

        @php
        $grandTotalQty += $item->sum('qty');
        $grandTotalAmount += $item->sum('amount');

        $materialTotalQty += $item->sum('qty');
        $materialTotalAmount += $item->sum('amount');
        @endphp

        @endforeach

        <tr class="heading-color-two">
            <th colspan="2" class="text-right">Material Cost Subtotal</th>
            <th>{{ $materialTotalQty }}</th>
            <th>{{ $materialTotalAmount }}</th>
        </tr>

    </tbody>

    <thead>
        <tr class="heading-color-four">
            <th></th>
            <th>Cost Name</th>
            <th>Quantity</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        @php
        $selfDefineTotalQty = 0;
        $selfDefineTotalAmount = 0;
        @endphp
        @foreach ($data->planFollowUpReport->projectitems as $item)

        @php
        if($item[0]->budgetHead->type == 'Material'){
        continue;
        }
        @endphp

        <tr>
            <td>{{ $item[0]->budgetHead->type }}</td>
            <td>{{ $item[0]->budgetHead->name }}({{ $item[0]?->unit_of_measurement?->name }})</td>
            <td>{{ $item->sum('qty') }}</td>
            <td>{{ $item->sum('amount') }}</td>
        </tr>

        @php
        $grandTotalQty += $item->sum('qty');
        $grandTotalAmount += $item->sum('amount');

        $selfDefineTotalQty += $item->sum('qty');
        $selfDefineTotalAmount += $item->sum('amount');
        @endphp

        @endforeach

        <tr class="heading-color-four">
            <th colspan="2" class="text-right">Self Define Cost Subtotal</th>
            <th>{{ $selfDefineTotalQty }}</th>
            <th>{{ $selfDefineTotalAmount }}</th>
        </tr>

    </tbody>


    <tfoot>

        <tr  class="footer-heading">
            <th colspan="2" class="text-right">Cost GrandTotal</th>
            <th>{{ $grandTotalQty }}</th>
            <th>{{ $grandTotalAmount }}</th>
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

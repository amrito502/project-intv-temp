@if (request()->searched == "summary")
    <table class="table table-bordered" id="report-table">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Code</th>
                <th class="text-center">Product</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Purchase_Point</th>
            </tr>
        </thead>
        <tbody>
            @php
            $totalQty = 0;
            $totalAmount = 0;
            $totalPurchasePoint = 0;
            @endphp
            @foreach ($data->reports as $ld)
            @php
            if(request()->products){
            if (!in_array($ld['product']->id, request()->products)){
            continue;
            }
            }

            $totalQty += $ld['stockIn'];
            $totalAmount += $ld['amount'];
            $totalPurchasePoint += $ld['pp'];
            @endphp
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $ld['product']->deal_code }}</td>
                <td class="text-center">{{ $ld['product']->name }}</td>
                <td class="text-right">{{ $ld['stockIn'] }}</td>
                <td class="text-right">{{ $ld['amount'] }}</td>
                <td class="text-right">{{ number_format($ld['pp'], 2, '.', '') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center" colspan="3">Total</th>
                <th class="text-right">{{ $totalQty }}</th>
                <th class="text-right">{{ number_format($totalAmount, 2, '.', '') }}</th>
                <th class="text-right">{{ number_format($totalPurchasePoint, 2, '.', '') }}</th>
            </tr>
        </tfoot>
    </table>
@endif

@if (request()->searched == "details")
    <table class="table table-bordered" id="report-table">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Date</th>
                <th class="text-center">Invoice No.</th>
                <th class="text-center">Product (Code)</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Purchase Point</th>
            </tr>
        </thead>
        <tbody>
            @php
            $sl = 1;
            $totalQty = 0;
            $totalAmount = 0;
            $totalPurchasePoint = 0;
            @endphp
            @foreach ($data->reports as $cashSale)
            @foreach ($cashSale->items as $item)

            @php
            if(request()->products){
            if (!in_array($item->item_id, request()->products)){
            continue;
            }
            }

            $totalQty += $item->item_quantity;
            $totalAmount += $item->item_quantity * $item->item_rate;
            $totalPurchasePoint += $item->item_quantity * $item->pp;
            @endphp

            <tr>
                <td class="text-center">{{ $sl++ }}</td>
                <td class="text-center">
                    {{ date('d-m-Y', strtotime($cashSale->invoice_date))}}
                </td>
                <td class="text-center">{{ $cashSale->invoice_no }}</td>
                <td class="text-center">
                    {{ $item->product->name }} ({{ $item->product->deal_code}})
                </td>
                <td class="text-right">{{ $item->item_quantity }}</td>
                <td class="text-right">{{ number_format($item->item_quantity * $item->item_rate, 2, '.', '') }}</td>
                <td class="text-right">{{ number_format($item->item_quantity * $item->pp, 2, '.', '') }}</td>
            </tr>

            @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center" colspan="4">Total</th>
                <th class="text-right">{{ $totalQty }}</th>
                <th class="text-right">{{ number_format($totalAmount, 2, '.', '') }}</th>
                <th class="text-right">{{ number_format($totalPurchasePoint, 2, '.', '') }}</th>
            </tr>
        </tfoot>
    </table>
@endif

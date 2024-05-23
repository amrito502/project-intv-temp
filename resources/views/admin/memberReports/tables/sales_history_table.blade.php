<table class="table table-bordered" id="report-table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Date</th>
            <th class="text-center">Dealer</th>
            <th class="text-center">Member</th>
            <th class="text-center">Category</th>
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
        @foreach ($data->reports as $memberSale)
        @foreach ($memberSale->items as $item)

        @php
        if(request()->products){
        if (!in_array($item->item_id, request()->products)){
        continue;
        }
        }

        if(request()->categories){
        if (!in_array($item->product->category->id, request()->categories)){
        continue;
        }
        }

        $totalQty += $item->item_quantity;
        $totalAmount += $item->item_quantity * $item->item_rate;
        $totalPurchasePoint += $item->pp;
        @endphp

        <tr>
            <td class="text-center">{{ $sl++ }}</td>
            <td class="text-center">
                {{ date('d-m-Y', strtotime($memberSale->invoice_date)) }}
            </td>
            <td class="text-center">{{ $memberSale->dealer->name }} ({{ $memberSale->dealer->username }})</td>
            <td class="text-center">{{ $memberSale->customer->name }} ({{ $memberSale->customer->username }})</td>
            <td class="text-center">{{ $item->product->category->categoryName }}</td>
            <td class="text-center">
                {{ $item->product->name }} ({{ $item->product->deal_code }})
            </td>
            <td class="text-right">{{ $item->item_quantity }}</td>
            <td class="text-right">{{ $item->item_quantity * $item->item_rate }}</td>
            <td class="text-right">{{ $item->pp }}</td>
        </tr>

        @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-center" colspan="6">Total</th>
            <th class="text-right">{{ $totalQty }}</th>
            <th class="text-right">{{ $totalAmount }}</th>
            <th class="text-right">{{ $totalPurchasePoint }}</th>
        </tr>
    </tfoot>
</table>

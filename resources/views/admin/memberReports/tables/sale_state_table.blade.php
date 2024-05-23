<table class="table table-bordered" id="report-table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Category</th>
            <th class="text-center">Name</th>
            <th class="text-right">Sales Qty</th>
            <th class="text-right">Point</th>
            <th class="text-right">Sales Amount</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalSalesQty = 0;
            $totalPoint = 0;
            $totalSalesAmount = 0;
        @endphp
        @foreach ($data->reports as $ld)
        @php
            $totalSalesQty += $ld['salesQty'];
            $totalPoint += $ld['salesPoint'];
            $totalSalesAmount += $ld['salesAmount'];
        @endphp
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $ld['product']->category->categoryName }}</td>
            <td class="text-center">{{ $ld['product']->name }}</td>
            <td class="text-right">{{ $ld['salesQty'] }}</td>
            <td class="text-right">{{ $ld['salesPoint'] }}</td>
            <td class="text-right">{{ $ld['salesAmount'] }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-center" colspan="3">Total</th>
            <th class="text-right">{{ $totalSalesQty }}</th>
            <th class="text-right">{{ $totalPoint }}</th>
            <th class="text-right">{{ $totalSalesAmount }}</th>
        </tr>
    </tfoot>
</table>

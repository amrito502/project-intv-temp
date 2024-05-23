<table class="table table-bordered" id="report-table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-left">Product</th>
            <th class="text-right">Total Purchase</th>
            <th class="text-right">Primary Sale</th>
            <th class="text-right">Secondary Sale</th>
            <th class="text-right">Dealer Stock</th>
            <th class="text-right">Stock</th>
            <th class="text-right">Total Stock</th>
        </tr>
    </thead>
    <tbody>
        @php
        $totalPurchase = 0;
        $totalPrimarySale = 0;
        $totalSecondarySale = 0;
        $totalDealerStock = 0;
        $totalStock = 0;
        $totalBalance = 0;
        @endphp
        @foreach ($data->reports as $ld)
        @php
        $totalPurchase += $ld['totalPurchase'];
        $totalPrimarySale += $ld['totalPrimarySale'];
        $totalSecondarySale += $ld['totalSecondarySale'];
        $totalDealerStock += $ld['dealerBalance'];
        $totalStock += $ld['stockBalance'];
        $totalBalance += $ld['totalBalance'];
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="text-center">{{ $ld['name'] }} ({{ $ld['code'] }})</td>
            <td class="text-right">{{ $ld['totalPurchase'] }}</td>
            <td class="text-right">{{ $ld['totalPrimarySale'] }}</td>
            <td class="text-right">{{ $ld['totalSecondarySale'] }}</td>
            <td class="text-right">
                <a target="_blank" href="{{ route('dealerWiseProductDealerStock', $ld['id']) }}">
                    {{ $ld['dealerBalance'] }}
                </a>
            </td>
            <td class="text-right">{{ $ld['stockBalance'] }}</td>
            <td class="text-right">{{ $ld['totalBalance'] }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="2">Total</th>
            <th class="text-right">{{ $totalPurchase }}</th>
            <th class="text-right">{{ $totalPrimarySale }}</th>
            <th class="text-right">{{ $totalSecondarySale }}</th>
            <th class="text-right">{{ $totalDealerStock }}</th>
            <th class="text-right">{{ $totalStock }}</th>
            <th class="text-right">{{ $totalBalance }}</th>
        </tr>
    </tfoot>
</table>

@if (request()->type == "categoryWise")
<table class="table table-bordered" id="report-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Category</th>
            <th class="text-center" style="width: 100px;">Qty</th>
            <th class="text-center" style="width: 100px;">Qty Contribution</th>
            <th class="text-center" style="width: 100px;">Amount</th>
            <th class="text-center" style="width: 100px;">Amount Contribution</th>
            <th class="text-center" style="width: 100px;">Point</th>
            <th class="text-center" style="width: 100px;">Point Contribution</th>
        </tr>
    </thead>

    <tbody>
        @php
        $total = [
        'qty' => 0,
        'qtyContribution' => 0,
        'amount' => 0,
        'amountContribution' => 0,
        'point' => 0,
        'pointContribution' => 0,
        ];
        @endphp
        @foreach ($data->reports['perCat'] as $item)
        @php
        $qtyContribution = (100 / $data->reports['total']['qty']) * $item['qty'];
        $amountContribution = (100 / $data->reports['total']['amount']) *
        $item['amount'];
        $pointContribution = (100 / $data->reports['total']['pp']) * $item['pp'];


        $total['qty'] += $item['qty'];
        $total['qtyContribution'] += $qtyContribution;
        $total['amount'] += $item['amount'];
        $total['amountContribution'] += $amountContribution;
        $total['point'] += $item['pp'];
        $total['pointContribution'] += $pointContribution;
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item['category']->categoryName }}</td>
            <td class="text-center">{{ $item['qty'] }}</td>
            <td class="text-center">{{ number_format($qtyContribution, 2, ".", "") }} %
            </td>
            <td class="text-center">{{ number_format($item['amount'], 2, ".", "") }}
            </td>
            <td class="text-center">{{ number_format($amountContribution, 2, ".", "") }}
                %</td>
            <td class="text-center">{{ number_format($item['pp'], 2, ".", "") }}</td>
            <td class="text-center">{{ number_format($pointContribution, 2, ".", "") }}
                %</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="2">Total</th>
            <th class="text-center">{{ $total['qty'] }}</th>
            <th class="text-center">{{ number_format($total['qtyContribution'], 2, ".",
                "") }} %</th>
            <th class="text-center">{{ number_format($total['amount'], 2, ".", "") }}
            </th>
            <th class="text-center">{{ number_format($total['amountContribution'], 2,
                ".", "") }} %</th>
            <th class="text-center">{{ number_format($total['point'], 2, ".", "") }}
            </th>
            <th class="text-center">{{ number_format($total['pointContribution'], 2,
                ".", "") }} %</th>
        </tr>
    </tfoot>
</table>
@endif

@if (request()->type == "productWise")
<table class="table table-bordered" id="report-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Product</th>
            <th class="text-center" style="width: 100px;">Qty</th>
            <th class="text-center" style="width: 100px;">Qty Contribution</th>
            <th class="text-center" style="width: 100px;">Amount</th>
            <th class="text-center" style="width: 100px;">Amount Contribution</th>
            <th class="text-center" style="width: 100px;">Point</th>
            <th class="text-center" style="width: 100px;">Point Contribution</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total = [
        'qty' => 0,
        'qtyContribution' => 0,
        'amount' => 0,
        'amountContribution' => 0,
        'point' => 0,
        'pointContribution' => 0,
        ];
        @endphp
        @foreach ($data->reports['perProduct'] as $item)
        @php
        $qtyContribution = (100 / $data->reports['total']['qty']) * $item['qty'];
        $amountContribution = (100 / $data->reports['total']['amount']) *
        $item['amount'];
        $pointContribution = (100 / $data->reports['total']['pp']) * $item['pp'];


        $total['qty'] += $item['qty'];
        $total['qtyContribution'] += $qtyContribution;
        $total['amount'] += $item['amount'];
        $total['amountContribution'] += $amountContribution;
        $total['point'] += $item['pp'];
        $total['pointContribution'] += $pointContribution;
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item['product']->category->categoryName }}</td>
            <td>{{ $item['product']->name }}</td>
            <td class="text-center">{{ $item['qty'] }}</td>
            <td class="text-center">{{ number_format($qtyContribution, 2, ".", "") }} %
            </td>
            <td class="text-center">{{ number_format($item['amount'], 2, ".", "") }}
            </td>
            <td class="text-center">{{ number_format($amountContribution, 2, ".", "") }}
                %</td>
            <td class="text-center">{{ number_format($item['pp'], 2, ".", "") }}</td>
            <td class="text-center">{{ number_format($pointContribution, 2, ".", "") }}
                %</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="3">Total</th>
            <th class="text-center">{{ $total['qty'] }}</th>
            <th class="text-center">{{ number_format($total['qtyContribution'], 2, ".",
                "") }} %</th>
            <th class="text-center">{{ number_format($total['amount'], 2, ".", "") }}
            </th>
            <th class="text-center">{{ number_format($total['amountContribution'], 2,
                ".", "") }} %</th>
            <th class="text-center">{{ number_format($total['point'], 2, ".", "") }}
            </th>
            <th class="text-center">{{ number_format($total['pointContribution'], 2,
                ".", "") }} %</th>
        </tr>
    </tfoot>
</table>
@endif

@if (request()->type == "dealerWise")
<table class="table table-bordered" id="report-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Dealer</th>
            <th class="text-center" style="width: 100px;">Qty</th>
            <th class="text-center" style="width: 100px;">Qty Contribution</th>
            <th class="text-center" style="width: 100px;">Amount</th>
            <th class="text-center" style="width: 100px;">Amount Contribution</th>
            <th class="text-center" style="width: 100px;">Point</th>
            <th class="text-center" style="width: 100px;">Point Contribution</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total = [
        'qty' => 0,
        'qtyContribution' => 0,
        'amount' => 0,
        'amountContribution' => 0,
        'point' => 0,
        'pointContribution' => 0,
        ];
        @endphp
        @foreach ($data->reports['perDealer'] as $item)
        @php
        $qtyContribution = (100 / $data->reports['total']['qty']) * $item['qty'];
        $amountContribution = (100 / $data->reports['total']['amount']) *
        $item['amount'];
        $pointContribution = (100 / $data->reports['total']['pp']) * $item['pp'];


        $total['qty'] += $item['qty'];
        $total['qtyContribution'] += $qtyContribution;
        $total['amount'] += $item['amount'];
        $total['amountContribution'] += $amountContribution;
        $total['point'] += $item['pp'];
        $total['pointContribution'] += $pointContribution;
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item['dealer']->name }} ({{ $item['dealer']->username }})</td>
            <td class="text-center">{{ $item['qty'] }}</td>
            <td class="text-center">{{ number_format($qtyContribution, 2, ".", "") }} %
            </td>
            <td class="text-center">{{ number_format($item['amount'], 2, ".", "") }}
            </td>
            <td class="text-center">{{ number_format($amountContribution, 2, ".", "") }}
                %</td>
            <td class="text-center">{{ number_format($item['pp'], 2, ".", "") }}</td>
            <td class="text-center">{{ number_format($pointContribution, 2, ".", "") }}
                %</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="2">Total</th>
            <th class="text-center">{{ $total['qty'] }}</th>
            <th class="text-center">{{ number_format($total['qtyContribution'], 2, ".",
                "") }} %</th>
            <th class="text-center">{{ number_format($total['amount'], 2, ".", "") }}
            </th>
            <th class="text-center">{{ number_format($total['amountContribution'], 2,
                ".", "") }} %</th>
            <th class="text-center">{{ number_format($total['point'], 2, ".", "") }}
            </th>
            <th class="text-center">{{ number_format($total['pointContribution'], 2,
                ".", "") }} %</th>
        </tr>
    </tfoot>
</table>
@endif

<table id="{{ $id }}" name="dataTable" class="table table-bordered">
    <thead>
        <tr>
            <th width="20px">Sl</th>
            <th>Category</th>
            <th>Name</th>
            <th class="text-right" width="60px">Qty</th>
            <th class="text-right" width="80px">Rate</th>
            <th class="text-right" width="80px">Total</th>
            <th class="text-right" width="80px">Costing</th>
            <th class="text-right" width="80px">Profit</th>
            <th class="text-right" width="75px">Profit %</th>
        </tr>
    </thead>

    <tbody id="tbody">
        @php
        $grandTotalQty = 0;
        $grandTotalTotal = 0;
        $grandTotalCosting = 0;
        $grandTotalProfit = 0;
        @endphp
        @foreach ($productWiseProfits as $productWiseProfit)
        @php
        $total = $productWiseProfit->qty * $productWiseProfit->dpPrice;
        $avgPrice = DB::table('stock_valuation_report')
        ->select(DB::raw('((SUM(stock_valuation_report.cashPurchaseAmount) +
        SUM(stock_valuation_report.creditPurchaseAmount)) -
        SUM(stock_valuation_report.purchaseReturnAmount)) /
        ((SUM(stock_valuation_report.cashPurchaseQty) +
        SUM(stock_valuation_report.creditPurchaseQty)) -
        SUM(stock_valuation_report.purchaseReturnQty)) as avgPrice'))
        ->where('productId',$productWiseProfit->productId)
        ->first();
        $costing = $avgPrice->avgPrice * $productWiseProfit->qty;
        $profit = $total - $costing;
        $percentageProfit = ($profit * 100)/$total;
        @endphp

        @php
        $grandTotalQty += $productWiseProfit->qty;
        $grandTotalTotal += $productWiseProfit->qty * $productWiseProfit->dpPrice;
        $grandTotalCosting += $costing;
        $grandTotalProfit += $profit;
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $productWiseProfit->categoryName }}</td>
            <td>{{ $productWiseProfit->productName }} ({{ $productWiseProfit->productCode }})</td>
            <td style="text-align: right;">{{ $productWiseProfit->qty }}</td>
            <td style="text-align: right;">{{ number_format($productWiseProfit->dpPrice,'2','.','') }}</td>
            <td style="text-align: right;">{{ number_format($productWiseProfit->qty *
                $productWiseProfit->dpPrice,'2','.','') }}</td>
            <td style="text-align: right;">{{ number_format($costing,'2','.','') }}</td>
            <td style="text-align: right;">{{ number_format($profit,'2','.','') }}</td>
            <td style="text-align: right;">{{ number_format($percentageProfit,'2','.','') }} %</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        @php

        $grandTotalProfitPercent = 0;

        if($grandTotalTotal){
        $grandTotalProfitPercent = ($grandTotalProfit * 100)/$grandTotalTotal;
        }
        @endphp
        <tr>
            <th colspan="3" style="text-align: right;">Total</th>
            <th style="text-align: right;">{{ $grandTotalQty }}</th>
            <th></th>
            <th style="text-align: right;">{{ number_format($grandTotalTotal,'2','.','') }}</th>
            <th style="text-align: right;">{{ number_format($grandTotalCosting,'2','.','') }}</th>
            <th style="text-align: right;">{{ number_format($grandTotalProfit,'2','.','') }}</th>
            <th style="text-align: right;">{{ number_format($grandTotalProfitPercent,'2','.','') }} %</th>
        </tr>
    </tfoot>
</table>

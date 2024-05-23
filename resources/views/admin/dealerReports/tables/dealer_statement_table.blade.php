@php
$text1 = "Purchase";
$text2 = "Payment";

if(in_array(auth::user()->role, [1, 2, 6, 7])){
$text1 = "Sale";
$text2 = "Collection";
}
@endphp


<table class="table table-bordered table-striped" id="report-table">
    <thead>
        <tr>
            <th colspan="4" class="text-right">Previous Balance</th>
            <th class="text-center">{{ number_format($data->previousBalance, 2, ".", "") }}</th>
        </tr>
        <tr>
            <th class="text-center">Date</th>
            <th class="text-left">Remarks</th>
            <th class="text-center">{{ $text1 }}</th>
            <th class="text-center">{{ $text2 }}</th>
            <th class="text-center">Balance</th>
        </tr>
    </thead>
    <tbody>
        @php
        $totalPurchase = 0;
        $totalPayment = 0;
        @endphp
        @foreach ($data->reports as $ld)
        @php
        $totalPurchase += $ld['purchase'];
        $totalPayment += $ld['payment'];
        @endphp
        <tr>
            <td class="text-center">{{ $ld['date'] }}</td>
            <td class="text-left">{{ $ld['remarks'] }}</td>
            <td class="text-center">{{ number_format($ld['purchase'], 2, ".", "") }}</td>
            <td class="text-center">{{ number_format($ld['payment'], 2, ".", "") }}</td>
            <td class="text-center">{{ number_format($ld['balance'], 2, ".", "") }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-right">Total</th>
            <th class="text-center">{{ number_format($totalPurchase, 2, ".", "") }}</th>
            <th class="text-center">{{ number_format($totalPayment, 2, ".", "") }}</th>
            <th class="text-center"></th>
        </tr>
    </tfoot>
</table>

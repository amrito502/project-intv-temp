@if (request()->searched)
<div class="table-responsive">
    <table class="table table-bordered" id="report-table">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Name (Username)</th>
                <th class="text-right">Previous Balance</th>
                <th class="text-right">Achieve</th>
                <th class="text-right">Receive</th>
                <th class="text-right">Transfer</th>
                <th class="text-right">Payment</th>
                <th class="text-right">Charge</th>
                <th class="text-right">Balance</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPreviousBalance = 0;
                $totalAchieve = 0;
                $totalReceive = 0;
                $totalTransfer = 0;
                $totalPayment = 0;
                $totalCharge = 0;
            @endphp
            @foreach ($data->reports as $ld)
            @php
                $totalPreviousBalance += $ld['previousBalance'];
                $totalAchieve += $ld['achieve'];
                $totalReceive += $ld['receive'];
                $totalTransfer += $ld['transfer'];
                $totalPayment += $ld['payment'];
                $totalCharge += $ld['charge'];
            @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $ld['user']->name }} ({{ $ld['user']->username }})</td>
                    <td class="text-right">{{ $ld['previousBalance'] }}</td>
                    <td class="text-right">{{ $ld['achieve'] }}</td>
                    <td class="text-right">{{ $ld['receive'] }}</td>
                    <td class="text-right">{{ $ld['transfer'] }}</td>
                    <td class="text-right">{{ $ld['payment'] }}</td>
                    <td class="text-right">{{ $ld['charge'] }}</td>
                    <td class="text-right">{{ $ld['balance'] }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">Total</th>
                <th class="text-right">{{ number_format($totalPreviousBalance, 2, ".", "") }}</th>
                <th class="text-right">{{ number_format($totalAchieve, 2, ".", "") }}</th>
                <th class="text-right">{{ number_format($totalReceive, 2, ".", "") }}</th>
                <th class="text-right">{{ number_format($totalTransfer, 2, ".", "") }}</th>
                <th class="text-right">{{ number_format($totalPayment, 2, ".", "") }}</th>
                <th class="text-right">{{ number_format($totalCharge, 2, ".", "") }}</th>
                <th class="text-right">{{ number_format($totalPreviousBalance + $totalAchieve + $totalReceive - $totalTransfer - $totalPayment - $totalCharge, 2, ".", "") }}</th>
            </tr>
        </tfoot>
    </table>
</div>
@endif

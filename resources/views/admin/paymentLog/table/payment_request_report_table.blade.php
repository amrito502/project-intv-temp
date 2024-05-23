<table class="table table-bordered table-striped" id="report-table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-left">Request By</th>
            <th class="text-center">Request Amount</th>
            <th class="text-center">Charge Deduct</th>
            <th class="text-center">Payable Amount</th>
            <th>
                @php
                    $dateLabel = "Request Date";

                    if (request()->payment_status == 'paid') {
                        $dateLabel = "Payment Date";
                    }
                @endphp

                {{ $dateLabel }}
            </th>
            <th>User Type</th>
            <th>Payment Mode</th>
            <th>Transaction No.</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalRequestAmount = 0;
            $totalChargeDeduct = 0;
            $totalPayableAmount = 0;
        @endphp
        @foreach ($data->reports as $report)
        @php
            $totalRequestAmount += $report['withdraw_amount'];
            $totalChargeDeduct += $report['withdraw_charge'];
            $totalPayableAmount += $report['final_amount'];
        @endphp
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $report['withdraw_by']->name }} ({{ $report['withdraw_by']->username
                }})</td>
            <td class="text-center">{{ $report['withdraw_amount'] }}</td>
            <td class="text-center">{{ $report['withdraw_charge'] }}</td>
            <td class="text-center">{{ $report['final_amount'] }}</td>
            <td>
                {{ $report['date'] }}
            </td>
            <td>{{ $report['type'] }}</td>
            <td>{{ $report['payment_gateway'] }}
                @if ($report['payment_gateway'] != 'cash')
                - {{ $report['payment_gateway_no'] }}</td>
                @endif
            <td>{{ $report['transaction_no'] }}</td>
            @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-right">Total</th>
            <th class="text-center">{{ $totalRequestAmount }}</th>
            <th class="text-center">{{ $totalChargeDeduct }}</th>
            <th class="text-center">{{ $totalPayableAmount }}</th>
            <th colspan="4"></th>
        </tr>
    </tfoot>
</table>

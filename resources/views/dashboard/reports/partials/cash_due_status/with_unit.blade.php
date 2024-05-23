<table class="table table-hover table-bordered mt-2">
    <thead>
        <tr class="heading-color-four">
            <th>#</th>
            <th>Cost Head</th>
            <th class="text-center">Budget</th>
            <th class="text-center">Additional Budget</th>
            <th class="text-center">Approved</th>
            <th class="text-center">Payment</th>
            <th class="text-center">Pending</th>
            <th class="text-center">Expense</th>
            <th class="text-center">Site Balance</th>
        </tr>
    </thead>
    <tbody>
        @php
        $totalBudget = 0;
        $totalAdditionalBudget = 0;
        $totalApproved = 0;
        $totalPayment = 0;
        $totalPending = 0;
        $totalExpense = 0;
        $totalBalance = 0;
        @endphp

        @foreach ($data->report as $item)
        @php
        $totalBudget += $item['budget'];
        $totalAdditionalBudget += $item['additional_budget'];
        $totalApproved += $item['approved'];
        $totalPayment += $item['issued'];
        $totalPending += $item['issue_due'];
        $totalExpense += $item['usage'];
        $totalBalance += $item['field_hand'];

        $trClass = $item['usage'] > $item['usage'] ? 'text-danger' : '';
        @endphp
        <tr class="{{ $trClass }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item['head'] }}</td>
            <td class="text-center">{{ $item['budget'] }}</td>
            <td class="text-center">{{ $item['additional_budget'] }}</td>
            <td class="text-center">{{ $item['approved'] }}</td>
            <td class="text-center">{{ $item['issued'] }}</td>
            <td class="text-center">{{ $item['issue_due'] }}</td>
            <td class="text-center">{{ $item['usage'] }}</td>
            <td class="text-center">{{ $item['field_hand'] }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-right">Total Summary</th>
            <th class="text-center">{{ $totalBudget }}</th>
            <th class="text-center">{{ $totalAdditionalBudget }}</th>
            <th class="text-center">{{ $totalApproved }}</th>
            <th class="text-center">{{ $totalPayment }}</th>
            <th class="text-center">{{ $totalPending }}</th>
            <th class="text-center">{{ $totalExpense }}</th>
            <th class="text-center">{{ $totalBalance }}</th>
        </tr>
    </tfoot>

</table>

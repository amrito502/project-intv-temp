<table class="table table-bordered" id="report-table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Name</th>
            <th class="text-right">Sales Bonus</th>
            <th class="text-right">Team Bonus</th>
            <th class="text-right">Repurchase Bonus</th>
            <th class="text-right">Rank Bonus</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalSalesBonus = 0;
            $totalTeamBonus = 0;
            $totalRePurchaseBonus = 0;
            $totalRankBonus = 0;
            $grandTotal = 0;
        @endphp
        @foreach ($data->reports as $ld)
        @php
            $totalSalesBonus += $ld['sales_bonus'];
            $totalTeamBonus += $ld['team_bonus'];
            $totalRePurchaseBonus += $ld['repurchase_bonus'];
            $totalRankBonus += $ld['rank_bonus'];
            $grandTotal += $ld['total'];
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['user']->name }} ({{ $ld['user']->username }})</td>
            <td class="text-right">{{ number_format($ld['sales_bonus'], 2, ".", "") }}</td>
            <td class="text-right">{{ number_format($ld['team_bonus'], 2, ".", "") }}</td>
            <td class="text-right">{{ number_format($ld['repurchase_bonus'], 2, ".", "") }}</td>
            <td class="text-right">{{ number_format($ld['rank_bonus'], 2, ".", "") }}</td>
            <td class="text-right">{{ number_format($ld['total'], 2, ".", "") }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-center" colspan="2">Total</th>
            <th class="text-right">{{ number_format($totalSalesBonus, 2, ".", "") }}</th>
            <th class="text-right">{{ number_format($totalTeamBonus, 2, ".", "") }}</th>
            <th class="text-right">{{ number_format($totalRePurchaseBonus, 2, ".", "") }}</th>
            <th class="text-right">{{ number_format($totalRankBonus, 2, ".", "") }}</th>
            <th class="text-right">{{ number_format($grandTotal, 2, ".", "") }}</th>
        </tr>
    </tfoot>
</table>

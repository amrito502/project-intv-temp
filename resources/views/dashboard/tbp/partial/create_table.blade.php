@foreach ($issues as $issue)
@php
$issueColSpan = $issueItems->where('daily_consumption_id', $issue->id)->count();
@endphp
@foreach ($issueItems->where('daily_consumption_id', $issue->id) as $issueItem)
@php

if(!$logisticsCharge->items){
continue;
}

$material = $issueItem->budgetHead->materialInfo();

$lcMat = $logisticsCharge->items->where('material_id', $material->id)->first();

if($lcMat){
    $materialRate = $logisticsCharge->items->where('material_id', $material->id)->first()->material_rate;
}else{
    $materialRate = $logisticsCharge->general_transportation_charge;
}

@endphp
<tr>
    <td>{{ date('d-m-Y', strtotime($issue->date)) }}</td>
    @if ($loop->first)
    <td rowspan="{{ $issueColSpan }}" style="vertical-align: middle;">
        <p>{{ $issue->system_serial }}</p>
    </td>
    <td rowspan="{{ $issueColSpan }}" style="vertical-align: middle;">
        {{ $issue?->tower?->name }}
    </td>
    @endif
    <td>{{ $issueItem->budgetHead->name }} ({{ $material->materialUnit->name }})</td>
    <td>
        <input type="text" name="rates[{{ $issueItem->id }}]" class="form-control" id="rate_{{ $issueItem->id }}" onkeyup="updateChargeAmount('{{ $issueItem->id }}')" value="{{ $materialRate }}">
    </td>
    <td>
        {{ $issueItem->consumption_qty }}

        <input type="hidden" id="consumption_qty_{{ $issueItem->id }}" value="{{ $issueItem->consumption_qty }}">

    </td>
    <td>
        <input type="number" id="charge_{{ $issueItem->id }}" class="form-control" step="any" max="{{ $materialRate * $issueItem->consumption_qty }}"
            value="{{ $materialRate * $issueItem->consumption_qty }}" name="payment_amount[{{ $issueItem->id }}]">
    </td>
    <td>
        <input type="checkbox" charge="{{ $materialRate * $issueItem->consumption_qty }}" name="items[]"
            value="{{ $issueItem->id }}" class="item_{{ $issueItem->id }}">
        <input type="hidden" name="materials[{{ $issueItem->id }}]" value="{{ $material->id }}">
        {{-- <input type="hidden" name="rates[{{ $issueItem->id }}]" value="{{ $materialRate }}"> --}}
        <input type="hidden" name="qtys[{{ $issueItem->id }}]" value="{{ $issueItem->consumption_qty }}">
    </td>
</tr>
@endforeach
@endforeach

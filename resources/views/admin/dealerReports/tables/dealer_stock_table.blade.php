<table class="table table-bordered table-striped" id="report-table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Category</th>
            <th class="text-center">Product</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Value</th>
            <th class="text-center">Point</th>
        </tr>
    </thead>
    <tbody>
        @php
        $type = request()->type;
        $i = 0;

        $total_qty = 0;
        $total_value = 0;
        $total_point = 0;
        @endphp
        @foreach ($data->reports as $ld)
        @php
        if($type == 'in_stock'){

            if($ld['stockIn'] < 1){
                continue;
            }
        }

            if($type=='out_of_stock' ){
                if($ld['stockIn']>0){
                    continue;
                }
            }

            if(request()->products){
                if (!in_array($ld['product']->id, request()->products)){
                    continue;
                }
            }

            $i = $i + 1;
            $total_qty += $ld['stockIn'];
            $total_value += $ld['amount'];
            $total_point += $ld['product']->pp * $ld['stockIn'];
            @endphp
            <tr>
                <td class="text-center">{{ $i }}</td>
                <td class="text-center">{{ $ld['product']->category->categoryName }}
                </td>
                <td class="text-center">{{ $ld['product']->name }} ({{
                    $ld['product']->deal_code }})</td>
                <td class="text-center">{{ $ld['stockIn'] }}</td>
                <td class="text-center">{{ number_format($ld['amount'], 2, '.', '') }}</td>
                <td class="text-center">{{ number_format($ld['product']->pp * $ld['stockIn'], 2, '.', '') }}</td>
            </tr>
            @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="3">Total</th>
            <th class="text-center">{{ $total_qty }}</th>
            <th class="text-center">{{ number_format($total_value, 2, '.', '') }}</th>
            <th class="text-center">{{ number_format($total_point, 2, '.', '') }}</th>
        </tr>
    </tfoot>
</table>

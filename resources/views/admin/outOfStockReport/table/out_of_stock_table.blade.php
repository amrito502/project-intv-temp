<table id="{{ $id }}" name="dataTable" class="table table-bordered">
    <thead>
        <tr>
            <th width="20px">Sl</th>
            <th>Category</th>
            <th>Product</th>
            <th width="105px" class="text-right">Stock Qty</th>
        </tr>
    </thead>

    <tbody id="tbody">
        @php
            $sl = 0;
        @endphp

        @foreach ($stockOutReports as $stockOutReport)
            @php
                $sl++;
            @endphp
            @if ($stockOutReport->remainingQty <= $stockOutReport->reorderQty)
                <tr>
                    <td>{{ $sl }}</td>
                    <td>{{ $stockOutReport->category->categoryName }}</td>
                    <td>{{ $stockOutReport->name }} ({{ $stockOutReport->deal_code }})</td>
                    <td style="text-align: right;">0</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

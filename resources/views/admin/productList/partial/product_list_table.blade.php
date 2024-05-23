<table id="report-table" class="table table-bordered">
    <thead>
        <tr>
            <th width="20px">Sl</th>
            <th>Category</th>
            <th>Product Name</th>
            <th width="60px">MRP</th>
            <th width="60px">DP</th>
            <th width="60px">PP</th>
        </tr>
    </thead>

    <tbody id="tbody">
        @php $sl = 0; @endphp

        @foreach ($productLists as $productList)
            @php $sl++; @endphp
            <tr>
                <td>{{ $sl }}</td>
                <td>{{ $productList->categoryName }}</td>
                <td>{{ $productList->productName }} ({{ $productList->productCode }})</td>
                <td style="text-align: right;">{{ $productList->unitPrice }}</td>
                <td style="text-align: right;">{{ $productList->dp }}</td>
                <td style="text-align: right;">{{ $productList->pp }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

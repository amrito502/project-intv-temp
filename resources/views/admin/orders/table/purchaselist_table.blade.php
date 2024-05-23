<table id="{{ $id }}" name="dataTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Purchase No</th>
            <th class="text-center">Purchase Date</th>
            <th>Item Description</th>
            <th class="text-right">Amount</th>
            <th class="text-right">Point</th>
            {{-- <th>Status</th> --}}
        </tr>
    </thead>

    <tbody id="tbody">
        @php $sl = 0; @endphp

        @foreach ($memberSales as $memberSale)
        @php $sl++; @endphp
        <tr class="text-right">
            <td class="text-center">{{ $sl }}</td>
            <td class="text-center">{{ $memberSale->invoice_no }}</td>
            <td class="text-center">{{ date('d-m-Y', strtotime($memberSale->invoice_date)) }}</td>
            <td class="text-left">
                <ul>
                    @foreach ($memberSale->items as $item)
                    <li>{{ $item->product->name }} - {{ $item->item_quantity }}Pcs - {{
                        $item->item_price }}</li>
                    @endforeach
                </ul>
            </td>
            <td>{{ $memberSale->invoice_amount }}</td>
            <td>{{ $memberSale->invoiceTotalPP() }}</td>
            {{-- <td>
                @php
                $status = "Pending";
                if($memberSale->status == 1){
                $status = "Approved";
                }

                if($memberSale->status == 2){
                $status = "Rejected";
                }
                @endphp

                {{ $status }}
            </td> --}}

        </tr>
        @endforeach
    </tbody>
</table>

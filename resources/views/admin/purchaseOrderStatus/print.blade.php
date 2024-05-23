<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    {{-- <link href="{{ asset('admin-elite/dist/css/prints.css') }}" rel="stylesheet"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        @font-face {
            font-family: Nikosh;
            src: url('{{ asset('public/admin-elite/fonts/Nikosh.tff') }}');
        }

        body {
            font-family: 'Nikosh', sans-serif;
        }

        .companyTable {
            text-align: center;
            margin-bottom: 20px;
            /*margin-top: -60px;*/
            /*padding-bottom: -20px;
                    border-bottom:: 2px solid #333;*/
        }

        .title {
            border-bottom: 2px solid #000000;

        }

        .header {
            border: 1px solid black;
            box-shadow: 5px 5px #888888;
            padding: 5px;
            margin-bottom: 10px;
            text-align: center;
        }

        .footer {
            border: 1px solid black;
            box-shadow: 5px 5px #888888;
            padding: 5px;
            margin-top: 10px;
            text-align: center;
        }

        .print-table {
            border-collapse: collapse;
            width: 100%;
        }

        .print-table th {
            padding: 3px 3px;
            font-size: 13px;
            text-align: center;
            border-top: 1px solid black;
            border: 1px solid black;
            color: black;
        }

        .print-table td {
            padding: 3px 3px;
            font-size: 12px;
            border-bottom: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-bottom: 1px dotted;
        }

        .print-table tfoot th {
            border-left: none;
            border-right: none;
        }

        .total-table {
            border-collapse: collapse;
            width: 100%;
        }

        .total-table td {
            font-size: 12px;
            font-weight: bold;
            border-bottom: 1px solid black;
            border-style: dotted;
            padding: 3px 3px;
        }

        /* .print-table tr:nth-child(even){background-color: #f2f2f2;}

                    .print-table tr:hover {background-color: #ddd;}*/
    </style>
</head>

<body>
    <div style="margin-bottom: 0px; text-align: center;">
        <p>Techno Park Bangladesh</p>
        <p style="font-size: 10px;">DIT Project, Badda, Dhaka</p>
        <p style="font-size: 10px;">Email:technoparkbd@gmail.com</p>
    </div>
    <div
        style="border: 1px solid black; box-shadow: 5px 5px #888888; padding: 0px; margin-bottom: 10px; text-align: center;">
        Purchase Order Status On Date {{ Date('d-M-Y',strtotime($fromDate)) }} To {{ Date('d-M-Y',strtotime($toDate)) }}
    </div>
    <table class="print-table">
        <thead>
            <tr>
                <th width="25px">Sl</th>
                <th width="80px">PO No</th>
                <th>Product Name</th>
                <th width="100px">Order Qty</th>
                <th width="100px">Receive Qty</th>
                <th width="110px">Remaining Qty</th>
            </tr>
        </thead>

        <tbody>
            @php
            $sl = 0;
            $row = 0;
            $remainingQty = 0;
            $currentOrderNo = 0;

            $totalOrderQty = 0;
            $totalReceiveQty = 0;
            $totalRemainingQty = 0;
            @endphp

            @foreach ($poStatus as $pos)
            @php
            $sl++;
            $remainingQty = $pos->orderQty - $pos->receiveQty;

            $totalOrderQty = $totalOrderQty + $pos->orderQty;
            $totalReceiveQty = $totalReceiveQty + $pos->receiveQty;
            $totalRemainingQty = $totalRemainingQty + $remainingQty;
            if ($currentOrderNo == $pos->orderNo)
            {
            $row++;
            }
            else
            {
            $currentOrderNo = $pos->orderNo;
            $rowSpan = DB::table('purchase_order_status')
            ->where('supplierId',$pos->supplierId)
            ->where('orderNo',$pos->orderNo)
            ->where('orderQty','>',0)
            ->distinct('productId')
            ->count('productId');
            $row = 1;
            }
            @endphp
            <tr>
                <td>{{ $sl }}</td>
                @if ($row == 1)
                <td rowspan="{{ $rowSpan }}">{{ $pos->orderNo }}</td>
                <td>{{ $pos->productName }}</td>
                <td style="text-align: right;">{{ $pos->orderQty }}</td>
                <td style="text-align: right;">{{ $pos->receiveQty }}</td>
                <td style="text-align: right;">{{ $remainingQty }}</td>
                @else
                <td>{{ $pos->productName }}</td>
                <td style="text-align: right;">{{ $pos->orderQty }}</td>
                <td style="text-align: right;">{{ $pos->receiveQty }}</td>
                <td style="text-align: right;">{{ $remainingQty }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Grand Total</th>
                <th style="text-align: right;">{{ $totalOrderQty }}</th>
                <th style="text-align: right;">{{ $totalReceiveQty }}</th>
                <th style="text-align: right;">{{ $totalRemainingQty }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>

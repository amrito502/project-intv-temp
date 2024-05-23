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
    <div style="border: 1px solid black; box-shadow: 5px 5px #888888; padding: 0px; margin-bottom: 10px;">
        Client Wise Sales On Date {{ Date('d-M-Y',strtotime($fromDate)) }} To {{ Date('d-M-Y',strtotime($toDate)) }}
        Company Name:
    </div>

    <table class="print-table">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Client Name</th>
                <th>Owner Name</th>
                <th>Payment Type</th>
                <th>Total Sales Amount</th>
            </tr>
        </thead>

        <tbody>
            @php
            $sl = 0;
            $itemId = 0;
            $creditClientId = 0;

            $cashTotalNetAmount = 0;
            $cashClient = "";
            $cashpaymentType = "";

            $creditGrandTotal = 0;
            @endphp

            @foreach ($cashSales as $cashSale)
            @php
            $cashTotalNetAmount = $cashTotalNetAmount + $cashSale->net_amount;
            @endphp
            @endforeach

            <tr>
                <td>{{ ++$sl }}</td>
                <td>{{ @$cashSale->payment_type }}</td>
                <td></td>
                <td>{{ @$cashSale->payment_type }}</td>
                <td>{{ @$cashTotalNetAmount }}</td>
            </tr>

            @foreach ($creditSales as $creditSaleClientId)
            @if ($creditSaleClientId->clientId != $creditClientId)
            @php
            $sl++;
            $l = 0;
            $arrayCount = count($creditSales);
            $creditClient = "";
            $totalNetAmount = 0;
            @endphp
            @foreach ($creditSales as $creditSale)
            @php
            if ($creditSale->clientId == $creditSaleClientId->clientId)
            {
            $totalNetAmount = $totalNetAmount + $creditSale->net_amount;
            $creditClient = $creditSale->clientName;
            $creditClientId = $creditSale->clientId;
            $creditGrandTotal = $creditGrandTotal + $creditSale->net_amount;
            }
            $l++;
            @endphp

            @if ($arrayCount == $l)
            <tr>
                <td>{{ $sl }}</td>
                <td>{{ $creditClient }}</td>
                <td></td>
                <td>{{ $creditSale->payment_type }}</td>
                <td>{{ $totalNetAmount }}</td>
            </tr>
            @endif
            @endforeach
            @endif
            @endforeach
        </tbody>
    </table>


    <div style="border: 1px solid black; padding: 0px; margin-top: 20px;">
        <table class="total-table">
            <tr>
                <td>Total Cash Sales Amount</td>
                <td>{{ $cashTotalNetAmount }}</td>
            </tr>

            <tr>
                <td>Total Credit Sales Amount</td>
                <td>{{ $creditGrandTotal }}</td>
            </tr>

            <tr>
                <td>Grand Total Amount</td>
                <td>{{ $cashTotalNetAmount + $creditGrandTotal }}</td>
            </tr>
        </table>
    </div>
</body>

</html>

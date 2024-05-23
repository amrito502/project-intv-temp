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
        Client Statement History On Date {{ Date('d-M-Y',strtotime($fromDate)) }} To
        {{ Date('d-M-Y',strtotime($toDate)) }}
    </div>
    <table class="print-table">
        <thead>
            <tr>
                @php
                if ($previousBalances)
                {
                $previousBalance = $previousBalances->sales - ($previousBalances->collection +
                $previousBalances->others);
                }
                else
                {
                $previousBalance = 0;
                }

                @endphp
                <th colspan="6" style="text-align: right; font-weight: bold;">Previous Balance</th>
                <th style="text-align: right;">{{ $previousBalance }}</th>
            </tr>
            <tr>
                <th width="20px">Sl</th>
                <th width="100px">Date</th>
                <th>Description</th>
                <th width="90px">sales</th>
                <th width="90px">collection</th>
                <th width="90px">Others</th>
                <th width="90px">Balance</th>
            </tr>
        </thead>

        <tbody>
            @php
            $sl = 0;
            $balance = 0;
            $totalSales = 0;
            $totalCollection = 0;
            $totalOthers = 0;
            $totalBalance = 0;
            @endphp

            @foreach ($clientStatements as $clientStatement)
            @php
            $sl++;
            if ($sl == 1)
            {
            $balance = $previousBalance + ($clientStatement->sales - $clientStatement->collection -
            $clientStatement->others);
            }
            else
            {
            $balance = $balance + ($clientStatement->sales - $clientStatement->collection - $clientStatement->others);
            }
            $totalSales = $totalSales + $clientStatement->sales;
            $totalCollection = $totalCollection + $clientStatement->collection;
            $totalOthers = $totalOthers + $clientStatement->others;
            $totalBalance = $totalBalance + $balance;
            @endphp
            <tr>
                <td>{{ $sl }}</td>
                <td>{{ Date('d-m-Y',strtotime($clientStatement->date)) }}</td>
                <td>{{ $clientStatement->customerName }}</td>
                <td style="text-align: right;">{{ $clientStatement->sales }}</td>
                <td style="text-align: right;">{{ $clientStatement->collection }}</td>
                <td style="text-align: right;">{{ $clientStatement->others }}</td>
                <td style="text-align: right;">{{ $balance }}</td>
            </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Grand Total</th>
                <th style="text-align: right;">{{ $totalSales }}</th>
                <th style="text-align: right;">{{ $totalCollection }}</th>
                <th style="text-align: right;">{{ $totalOthers }}</th>
                <th style="text-align: right;">{{ $totalBalance }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
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
            /* text-align: center; */
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
    </style>
    <style>
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
    </style>

    @yield('custom-css')
</head>


<body>

    @include('admin.layouts.print.headInfo')


    @yield('content')


    @yield('custom-script')

</body>

</html>

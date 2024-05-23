@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;margin: 0 auto;">{{ $title }}</h2>
<hr>

@include('admin.productWiseProfit.table.product_wise_profit_table', ['id' => "report-table"])

@endsection

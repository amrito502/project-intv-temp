@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;">{{ $title }}</h2>

@include('admin.outOfStockReport.table.out_of_stock_table', ['id' => 'report-table'])

@endsection

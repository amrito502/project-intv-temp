@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;">{{ $title }}</h2>

@include('admin.dealerReports.tables.product_status_table')

@endsection

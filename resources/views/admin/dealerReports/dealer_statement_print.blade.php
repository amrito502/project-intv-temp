@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;">{{ $title }}</h2>

@include('admin.dealerReports.tables.dealer_statement_table')

@endsection

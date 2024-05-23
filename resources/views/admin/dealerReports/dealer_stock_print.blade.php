@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;">{{ $title }} - {{ $data->selectedUser->name }} ({{ $data->selectedUser->username }})</h2>

@include('admin.dealerReports.tables.dealer_stock_table')

@endsection

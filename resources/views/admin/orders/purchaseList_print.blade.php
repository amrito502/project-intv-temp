@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;margin: 0 auto;">{{ $title }}</h2>
<hr>

@include('admin.orders.table.purchaselist_table', ['id' => 'report-table'])

@endsection

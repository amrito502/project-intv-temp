@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;">{{ $title }}</h2>

@include('admin.memberReports.tables.sale_state_table')

@endsection

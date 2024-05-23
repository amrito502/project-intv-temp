@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;margin: 0 auto;">{{ $title }}</h2>
<hr>


@include('admin.memberReports.tables.sales_contribution_table')


@endsection

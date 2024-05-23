@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;">{{ $title }}</h2>

@include('admin.mlm.dashboard.income_statement_table', ['id' => 'report-table'])

@endsection

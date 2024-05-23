@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;margin: 0 auto;">Statement of {{ $data->selectedUser->username }}</h2>

<hr>

@include('admin.mlm.dashboard.my_statement_table')

@endsection

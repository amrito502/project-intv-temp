@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;margin: 0 auto;">{{ $title }}</h2>

<hr>

@include('admin.productList.partial.product_list_table')

@endsection

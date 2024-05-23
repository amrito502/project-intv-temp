@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;">{{ $title }}</h2>

@include('admin.salesCollectionOutstanding.patrial.dealer_outstanding_table')

@endsection

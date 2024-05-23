@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;margin: 0 auto;">{{ $title }}</h2>
<hr>


@include('admin.paymentLog.table.payment_request_report_table')


@endsection

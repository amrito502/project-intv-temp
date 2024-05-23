@extends('admin.layouts.master')

@section('custom_css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 200px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }} - {{ $data->product->name }}</h4>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div style="overflow-x:auto;">
                                <table class="table table-bordered" id="report-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Dealer</th>
                                            <th class="text-right">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalQty = 0;
                                        @endphp
                                        @foreach ($data->reports as $ld)
                                        @php
                                            $totalQty += $ld['dealerStock'];
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $ld['dealer']->name }}</td>
                                            <td class="text-right">{{ $ld['dealerStock'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-right" colspan="2">Total</th>
                                            <th class="text-right">{{ $totalQty }}</th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection


@section('custom-js')

<script>
</script>

@endsection

@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('tbp.pay') }}">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Transportation Bill Payment</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Transportation Bill Payment</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="">

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_mode">Payment Mode</label>
                            <input type="text" class="form-control" value="{{ $data->tbp->payment_type }}" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <input type="text" class="form-control" value="{{ $data->tbp->remarks }}" disabled>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" class="form-control" id="totalCheckedAmount" disabled>
                        </div>
                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-md-12">

                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Issue Number</th>
                                    <th>Material & UOM</th>
                                    <th>Rate Per UOM</th>
                                    <th>Qty</th>
                                    <th>Charge</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @php
                                $totalQty = 0;
                                $totalCharge = 0;
                                @endphp
                                @foreach ($data->tbp_items as $tbp_item)
                                @php
                                $totalQty += $tbp_item->material_qty;
                                $totalCharge += $tbp_item->charge();
                                @endphp
                                <tr>
                                    <td>{{ $tbp_item->consumptionItem->consumption->system_serial }}</td>
                                    <td>{{ $tbp_item->material->name }} ({{ $tbp_item->material->materialUnit->name }})
                                    </td>
                                    <td alight="right">{{ $tbp_item->material_rate }}</td>
                                    <td alight="right">{{ $tbp_item->material_qty }}</td>
                                    <td alight="right">
                                        {{ $tbp_item->payment_amount }}
                                        <input type="hidden" class="amount amount_{{ $tbp_item->id }}"
                                            value="{{ $tbp_item->payment_amount }}">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="items[{{ $tbp_item->id }}]"
                                            class="checkbox item_{{ $tbp_item->id }}" value="{{ $tbp_item->id }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success mt-2 float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>
@endsection

@section('custom-script')
<script>
    function totalCheckedSum(){

        let total = 0;

        $('.checkbox').each(function (i, el){

            let isChanged = $(el).is(':checked');

            if(isChanged){

                let rowId = $(el).val();

                let amount = +$('.amount_'+rowId).val();

                total += amount;
            }

        });

        return total;
    }

    $(function () {

        $('.checkbox').change(function (e) {
            e.preventDefault();

            let totalSum = totalCheckedSum();

            $('#totalCheckedAmount').val(totalSum);

        });

    });


</script>
@endsection

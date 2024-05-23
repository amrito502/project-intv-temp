@extends('dashboard.layouts.app')

@section('custom-css')
    <style>
        .box-bg:nth-child(odd){
            background-color: #ebe8ff;
        }
    </style>
@endsection

@section('content')
@include('dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="">
            <div class="row">
                <div class="col-md-2">
                    <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
                </div>
                <div class="col-md-8">
                    <h2 class="h2 text-center text-uppercase">ROA List ({{
                        $data->projectWiseBudget->project->project_name }})</h2>
                </div>
                <div class="col-md-2 text-right">
                    <button class="btn btn-primary" onclick="addRow();">
                        {{-- <i class="fa fa-plus-circle" aria-hidden="true"></i> --}}
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Add List
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('projectwiseroa.update', $data->projectWiseBudget->id) }}" method="post">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class="">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        @php
                        $totalRow = 0;
                        @endphp
                        @foreach ($data->projecBudgettWiseRoa as $projecBudgettWiseRoa)
                        @php
                        $totalRow++;
                        @endphp
                        <div class="row box-bg mt-3 p-2" id="row_{{ $projecBudgettWiseRoa->id }}">

                            <div class="col-md-2 pr-0">
                                <div class="form-group">
                                    <label for="">Survey Date</label>
                                    <input class="form-control datepicker" type="text" name="survery_date[]"
                                        value="{{ date('d-m-Y', strtotime($projecBudgettWiseRoa->survery_date))}}"
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2 pr-0">
                                <div class="form-group">
                                    <label for="">Access Type</label>
                                    <select name="access_type[]" class="form-control select2">
                                        <option value="Land" @if ($projecBudgettWiseRoa->access_type == "Land")
                                            selected
                                            @endif
                                            >Land</option>
                                        <option value="Road" @if ($projecBudgettWiseRoa->access_type == "Road")
                                            selected
                                            @endif
                                            >Road</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 pr-0">
                                <div class="form-group">
                                    <label for="">Owner Name</label>
                                    <input class="form-control" type="text" name="owner_name[]"
                                        value="{{ $projecBudgettWiseRoa->owner_name }}">
                                </div>
                            </div>

                            <div class="col-md-4 pr-0">
                                <div class="form-group">
                                    <label for="">Mobile</label>
                                    <input class="form-control" type="text" name="phone[]"
                                        value="{{ $projecBudgettWiseRoa->phone }}">
                                </div>
                            </div>

                            <div class="col-md-2 pr-0">
                                <div class="form-group">
                                    <label for="">Crops</label>
                                    <input class="form-control" type="text" name="crops[]"
                                        value="{{ $projecBudgettWiseRoa->crops }}">
                                </div>
                            </div>

                            <div class="col-md-2 pr-0">
                                <div class="form-group">
                                    <label for="">Area</label>
                                    <input class="form-control" type="text" name="area[]"
                                        value="{{ $projecBudgettWiseRoa->area }}">
                                </div>
                            </div>

                            <div class="col-md-2 pr-0">
                                <div class="form-group">
                                    <label for="">Per Area</label>
                                    <input class="form-control" type="text" name="per_area[]"
                                        value="{{ $projecBudgettWiseRoa->per_area }}">
                                </div>
                            </div>

                            <div class="col-md-2 pr-0">
                                <div class="form-group">
                                    <label for="">Rate Per Area</label>
                                    <input class="form-control" type="text" name="rate_per_kg[]"
                                        value="{{ $projecBudgettWiseRoa->rate_per_kg }}">
                                </div>
                            </div>

                            <div class="col-md-2 pr-0">
                                <div class="form-group">
                                    <label for="">Total</label>
                                    <input class="form-control" type="number" step="any" name="total[]"
                                        value="{{ $projecBudgettWiseRoa->total }}">
                                </div>
                            </div>

                            <div class="col-md-2 pr-0">
                                <div class="form-group">
                                    <label for="">Payment Date</label>
                                    <input class="form-control datepicker" type="text" name="payment_date[]"
                                        value="{{ date('d-m-Y', strtotime($projecBudgettWiseRoa->payment_date))}}">
                                </div>
                            </div>

                            <div class="col-md-2 pr-0">
                                <div class="form-group">
                                    <label for="">Total Advance</label>
                                    <input class="form-control" type="number" step="any" name="advance_paid[]"
                                        value="{{ $projecBudgettWiseRoa->advance_paid }}">
                                </div>
                            </div>

                            <div class="col-md-2 pr-0">
                                <div class="form-group">
                                    <label for="">Owner Demand</label>
                                    <input class="form-control" type="number" step="any" name="owner_demand[]"
                                        value="{{ $projecBudgettWiseRoa->owner_demand }}">
                                </div>
                            </div>

                            <div class="col-md-2 pr-0 offset-md-4">
                                <div class="" style="margin-top: 29px;">
                                    <button type="button" class="btn btn-block btn-primary" onclick="addRow()">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-2 pr-0">
                                <div class="" style="margin-top: 29px;">
                                    <button type="button" class="btn btn-block btn-danger"
                                        onclick="removeRow({{ $projecBudgettWiseRoa->id }})">
                                        Remove
                                    </button>
                                </div>
                            </div>

                        </div>
                        @endforeach

                        <div id="newRows"></div>

                        <input type="hidden" id="totalRow" value="{{ $totalRow }}">

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body text-right">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>

</form>
@endsection


@section('custom-script')
<script>
    function removeRow(id){
        $('#row_' + id).remove();
    }

    function addRow() {

        let totalRow = +$('#totalRow').val();
        let newTotalRow = totalRow + 1;
        $('#totalRow').val(newTotalRow);

        addRoaRow(newTotalRow);

    }

    function addRoaRow(rowId) {
        let form = `
            <div class="row  box-bg mt-3 p-2" id="row_${rowId}">

                <div class="col-md-2 pr-0">
                    <div class="form-group">
                        <label for="">Survey Date</label>
                        <input class="form-control datepicker" type="text" name="survery_date[]" autocomplete="off">
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group">
                        <label for="">Owner Name</label>
                        <input class="form-control" type="text" name="owner_name[]">
                    </div>
                </div>

                <div class="col-md-4 pr-0">
                    <div class="form-group">
                        <label for="">Access Type</label>
                        <select name="access_type[]" class="form-control select2">
                            <option value="Land">Land</option>
                            <option value="Road">Road</option>
                        </select>

                    </div>
                </div>

                <div class="col-md-4 pr-0">
                    <div class="form-group">
                        <label for="">Mobile</label>
                        <input class="form-control" type="text" name="phone[]">
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group">
                        <label for="">Crops</label>
                        <input class="form-control" type="text" name="crops[]">
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group">
                        <label for="">Area</label>
                        <input class="form-control" type="text" name="area[]">
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group">
                        <label for="">Per Area</label>
                        <input class="form-control" type="text" name="per_area[]">
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group">
                        <label for="">Rate Per Area</label>
                        <input class="form-control" type="text" name="rate_per_kg[]">
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group">
                        <label for="">Total</label>
                        <input class="form-control" type="number" step="any" name="total[]">
                    </div>
                </div>


                <div class="col-md-2 pr-0">
                    <div class="form-group">
                        <label for="">Payment Date</label>
                        <input class="form-control datepicker" type="text" name="payment_date[]">
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group">
                        <label for="">Advance Total</label>
                        <input class="form-control" type="number" step="any" name="advance_paid[]">
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="form-group">
                        <label for="">Owner Demand</label>
                        <input class="form-control" type="number" step="any" name="owner_demand[]">
                    </div>
                </div>

                <div class="col-md-2 offset-md-4 pr-0">
                    <div class="" style="margin-top: 29px;">
                        <button type="button" class="btn btn-block btn-primary" onclick="addRow()">
                            Add
                        </button>
                    </div>
                </div>

                <div class="col-md-2 pr-0">
                    <div class="" style="margin-top: 29px;">
                        <button type="button" class="btn btn-block btn-danger"
                            onclick="removeRow(${rowId})">
                            Remove
                        </button>
                    </div>
                </div>

            </div>
        `;

        $('#newRows').append(form);


        $('.select2').select2();

        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
        });

    }
</script>
@endsection

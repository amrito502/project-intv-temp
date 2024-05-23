@extends('dashboard.layouts.app')

@section('content')
    <form method="POST" action="{{ route('tbp.store') }}">
        @csrf

        <div class="tile">
            <div class="tile-body">
                <div class="">
                    <div class="row">
                        <div class="col-md-3">
                            <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                            </button>
                        </div>
                        <div class="col-md-6">
                            <h3 class="text-center my-3 d-md-none d-block text-uppercase">{{ $data->title }}</h3>
                            <h3 class="text-center d-md-block d-none text-uppercase">{{ $data->title }}</h3>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success float-right">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tile">
            <div class="tile-body">
                <div class="row">
                    @include('dashboard.layouts.partials.company_dropdown', [
                        'columnClass' => 'col-md-4',
                        'company_id' => 0,
                    ])

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="system_serial">System Serial</label>
                            <input type="text" id="system_serial" class="form-control" value="{{ $data->system_serial }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input name="date" type="text" id="date" class="form-control datepicker"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select name="project" id="project" class="select2" required>
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select name="vendor" id="vendor" class="select2" required>
                                <option value="">Select Vendor</option>
                                @foreach ($data->vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_mode">Payment Mode</label>
                            <select name="payment_mode" id="payment_mode" class="select2" required>
                                <option value="">Select Payment Mode</option>
                                <option value="Cash">Cash</option>
                                <option value="Check">Check</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cost_head">Cost Head</label>
                            <select name="cost_head" id="cost_head" class="select2" required>
                                <option value="">Select Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <input type="text" class="form-control" name="remarks" required autofocus>
                        </div>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Issue Number</th>
                                    <th>Tower</th>
                                    <th>Material & UOM</th>
                                    <th style="width: 150px;">Rate Per UOM</th>
                                    <th style="width: 150px;">Qty</th>
                                    <th style="width: 150px;">Charge</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table>

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
        function fetchTransPortTable() {


            let projectId = $('#project').val();
            let vendorId = $('#vendor').val();

            if (!projectId) {
                return false;
            }

            if (!vendorId) {
                return false;
            }

            $('#tbody').html('');

            axios.get(route('projectWiseLogisticsBillTable'), {
                    params: {
                        projectId: projectId,
                        vendorId: vendorId,
                    }
                })
                .then(function(response) {
                    let table = response.data;
                    $('#tbody').html(table);
                })
                .catch(function(error) {})
        }

        function updateChargeAmount(rowId) {
            let rate = $('#rate_' + rowId).val();
            let qty = $('#consumption_qty_' + rowId).val();
            let charge = rate * qty;
            $('#charge_' + rowId).val(charge);
        }

        $(function() {

            $('#project').add('#vendor').change(function(e) {
                e.preventDefault();
                fetchTransPortTable();
            });

            $('#project').change(function(e) {
                e.preventDefault();

                let projectId = $(this).val();

                if (!projectId) {
                    return false;
                }

                axios.get(route('projectWiseCostHead', projectId))
                    .then(function(response) {
                        let costHeads = response.data;

                        // loop through and append to select
                        $('#cost_head').html('');

                        $('#cost_head').append('<option value="">Select Cost Head</option>');

                        $.each(costHeads, function(key, value) {
                            $('#cost_head').append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });
                    }).catch(function(error) {})

            });

        });
    </script>
@endsection

@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('dailyconsumption.receiveSave', $data->dailyConsumption->id) }}">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-10">
                        <a href="{{ route('dailyconsumption.receiveList') }}" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </a>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Local Receive</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Local Receive</h3>
                    </div>
                    {{-- <div class="col-md-2">
                        <a target="_blank" href="{{ route('dailyconsumption.print', $data->dailyConsumption->id) }}"
                            class="btn btn-info float-right">
                            <i class="fa fa-print" aria-hidden="true"></i> Print
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="">

                <div class="row">

                    @include('dashboard.layouts.partials.company_dropdown', [
                    'columnClass'=> 'col-md-2',
                    'company_id' => $data->dailyConsumption->company_id,
                    ])

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="system_serial">System Serial</label>
                            <input type="text" id="system_serial" class="form-control"
                                value="{{ $data->dailyConsumption->system_serial }}" name="system_serial" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control"
                                value="{{ $data->dailyConsumption->date }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <input type="text" class="form-control" name="project"
                                value="{{ $data->dailyConsumption->project->project_name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="unit">Unit</label>

                            <input type="text" class="form-control" name="unit"
                                value="{{ $data->dailyConsumption->unit->name }}" readonly>

                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <input type="text" class="form-control" name="tower"
                                value="{{ $data->dailyConsumption?->tower?->name }}" readonly>
                        </div>
                    </div>



                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="logistics_associate">Logistics Associate</label>
                            <input type="text" class="form-control"
                                value="{{ $data->dailyConsumption?->logisticsAssociate?->name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="truck_no">Truck No</label>
                            <input type="text" id="truck_no" name="truck_no" class="form-control"
                                value="{{ $data->dailyConsumption->truck_no }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="issue_by">Issue By</label>
                            <input type="text" id="issue_by" name="issue_by" class="form-control"
                                value="{{ $data->dailyConsumption->issue_by_name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="receive_by">Receive By</label>
                            <input type="text" id="receive_by" name="receive_by" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 budgethead-table-here">

                        <div class="row">
                            <div class="col-md-12 budgethead-table-here">

                                <div style="overflow-x: auto;height: 500px">

                                    <table class="table gridTable mobile-changes">
                                        <thead>
                                            <tr>
                                                <th>Material Name & UOM</th>
                                                <th width="300px">Quantity</th>
                                            </tr>
                                        </thead>

                                        <tbody id="tbody">

                                            @foreach ($data->dailyconsumptionItems as $dailyconsumptionItem)

                                            <tr id="itemRow_{{ $dailyconsumptionItem->id + 1000 }}">

                                                <td class="pl-0">
                                                    <input class="form-control" type="text" value="{{ $dailyconsumptionItem->budgetHead->name }}" readonly>
                                                </td>

                                                <td>
                                                    <input style="text-align: right;"
                                                        class="form-control qty qty_{{ $dailyconsumptionItem->id + 1000 }}" type="number" step="any"
                                                        name="consumption_qty[{{ $dailyconsumptionItem->id }}]" oninput="totalAmount('{{ $dailyconsumptionItem->id + 1000 }}')"
                                                        value="{{ $dailyconsumptionItem->issue_qty }}" required>
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

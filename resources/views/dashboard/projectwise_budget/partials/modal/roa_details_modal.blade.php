<div class="modal fade" id="RoaDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  mw-100" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ROA Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Owner Name</th>
                                <th>Access Type</th>
                                <th>Mobile</th>
                                <th>Crops</th>
                                <th>Area</th>
                                <th>Per Area</th>
                                <th>Rate Per Area</th>
                                <th>Total</th>
                                <th>Advance Total</th>
                                <th>Owner Demand</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->projectBudgetWiseRoa as $roa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime($roa->date)) }}</td>
                                <td>{{ $roa->owner_name }}</td>
                                <td>{{ $roa->access_type }}</td>
                                <td>{{ $roa->phone }}</td>
                                <td>{{ $roa->crops }}</td>
                                <td>{{ $roa->area }}</td>
                                <td>{{ $roa->per_area }}</td>
                                <td>{{ $roa->rate_per_kg }}</td>
                                <td>{{ $roa->total }}</td>
                                <td>{{ $roa->advance_paid }}</td>
                                <td>{{ $roa->owner_demand }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="modal-footer">
                <a href="{{ route('projectwiseroa.index', $data->projectwisebudget->id) }}" class="btn btn-primary">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                    Edit
                </a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

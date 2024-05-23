@extends('dashboard.layouts.app')

@section('custom-css')
<style>
    #dailyconsumption-table_length {
        display: flex;
    }

    div.dataTables_wrapper div.dataTables_filter {
        margin-top: 30px;
    }

    #dailyconsumption-table_length>label {
        margin-top: 30px;
        margin-right: 30px;
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
                    <h2 class="h2 text-center text-uppercase">Local Receive</h2>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body">

        <div class="" style="overflow-y: auto">

            <div class="row justify-content-center">
                <div class="col-md-12">

                    <table class="table table-hover table-bordered dtb" id="dailyconsumption-table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>#</th>
                                <th>Date</th>
                                <th>Project</th>
                                <th>Unit</th>
                                <th>Tower</th>
                                <th>Materials</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->localIssues as $localIssue)

                            <tr>
                                <td>
                                    <a href="{{ route('dailyconsumption.receiveView', $localIssue->id) }}" class="btn btn-primary">Receive</a>
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime($localIssue->date)) }}</td>
                                <td>{{ $localIssue->project->project_name }}</td>
                                <td>{{ $localIssue->unit->name }}</td>
                                <td>{{ $localIssue->tower->name }}</td>
                                <td>
                                    @foreach ($localIssue->items as $item)
                                    <p>{{ $item->budgetHead->name }} ({{ $item->budgetHead->materialInfo()->materialUnit->name }}) - {{ $item->issue_qty }} </p>
                                    @endforeach
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



@endsection



@section('custom-script')


@endsection

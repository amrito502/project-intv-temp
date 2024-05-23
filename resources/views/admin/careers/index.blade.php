@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">All submitted career cv's</h4>
                    <table id="careerTable" class="table table-bordered table-striped"  name="contactUsesTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>CV link</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        	@foreach($careers as $career)                        	
                        	<tr>
                                <td>{{ $career->name }}</td>
                                <td><a href="{{ asset('/').'/'.$career->cv }}" target="_blank"> CV Link - {{ $career->name }}</a></td>
                            </tr>
                        	@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->


@endsection

@section('custom-js')
<script src="{{ asset('/admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#careerTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );
         });

        table.on('order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    </script>
@endsection
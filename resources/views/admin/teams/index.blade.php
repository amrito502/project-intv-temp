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
                <h4 class="card-title">Manage teams</h4>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addNewTeam" aria-hidden="true" style="float: right;">Add new</button>
                <div class="table-responsive" style="margin-top: 5rem;">
                    <table id="teamsTable" class="table table-bordered table-striped"  name="teamsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Picture</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        	@foreach($teams as $team)                        	
                        	<tr>
                                <td>{{ $team->name }}</td>
                                <td>{{ $team->designation }}</td>
                                <td><img src="{{ asset('/').$team->photo }}" style="height: 75px"></td>
                                <td class="text-nowrap">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Show" data-id="{{ $team->id }}"> <i class="fa fa-eye text-success m-r-10"></i> </a>
                                    <!-- <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Edit" data-id="{{ $team->id }}"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a> -->
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="{{$team->id}}"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
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
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->
<!-- sample modal content for add new team-->
<div id="addNewTeam" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" action="javascript:void(0)" method="POST" enctype="multipart/form-data" name="newTeam">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Add New Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Customer name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger" placeholder="Customer name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                            @foreach($errors->get('name') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('designation') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Customer designation</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger" placeholder="Customer designation" name="designation" value="{{ old('designation') }}">
                            @if ($errors->has('designation'))
                            @foreach($errors->get('designation') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    
                    <div class="form-group row {{ $errors->has('photo') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Customer photo</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="photo" aria-describedby="fileHelp" name="photo" value="{{ old('photo') }}">
                            @if ($errors->has('photo'))
                            @foreach($errors->get('photo') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 m-b-20 text-right">    
                        <button type="submit" class="btn btn-info waves-effect">Save member</button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- sample modal content for edit and update team-->
<div id="editTeam" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" action="javascript:void(0)" method="POST" enctype="multipart/form-data" name="updateTeam">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <input type="hidden" id="team_id" name="team_id" value="{{ old('team_id') }}">      

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Edit team member</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Customer name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger" placeholder="Customer name" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                            @foreach($errors->get('name') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('designation') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Customer designation</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger" placeholder="Customer designation"  id="designation" name="designation" value="{{ old('designation')? old('designation') : '15' }}">
                            @if ($errors->has('designation'))
                            @foreach($errors->get('designation') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('photo') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Customer photo</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="photo" aria-describedby="fileHelp" name="photo" value="{{ old('photo') }}">
                            @if ($errors->has('photo'))
                            @foreach($errors->get('photo') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 m-b-20 text-right">    
                        <button type="submit" class="btn btn-info waves-effect">Update member</button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- sample modal content for show member-->
<div id="showTeam" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show team member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container" id="showContent">
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



@endsection

@section('custom-js')

    <!-- This is data table -->
    <script src="{{ asset('/admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var updateThis ;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#teamsTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );

            table.on('order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            //ajax
            //ajax insert code
            $( "form[name='newTeam']" ).on( "submit", function( event ) {
                $('.has-danger').removeClass('has-danger');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('teams.store') }}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var team = response.team;
                        $('#addNewTeam').modal('hide');

                        var rowNode = table.row.add([ 
                            team.name,
                            team.designation,
                            `<img src="{{ asset('/') }}/`+team.photo+`" style="height: 75px">`,
                            `<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Show" data-id="`+team.id+`"> <i class="fa fa-eye text-success m-r-10"></i> </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="`+team.id+`"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
                            `] ).draw().node();
                        swal({
                            title: "<small class='text-success'>Success!</small>", 
                            type: "success",
                            text: "Customer successfully added!",
                            timer: 2000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        data = JSON.parse(response.responseText);
                        error = "<div class='container'><ol class='text-center' style='padding:2rem;'>";
                        i=1;
                        if(data.errors.name) {
                            $( "input[name='name']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.name +"</li>";
                        }
                        if(data.errors.position){
                            $( "input[name='designation']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.designation +"</li>";
                        }
                        if(data.errors.photo){
                            $( "input[name='designation']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.photo +"</li>";
                        }
                        error = error + "</ol></div>";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 5000,
                            html: true,
                        });
                    }
                });
            });

            //ajax show code
            $('#teamsTable tbody').on( 'click', 'i.fa-eye', function () { 
                updateThis = this;
                team_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('teams.index') }}" + "/" + team_id + "/edit",
                    data: "team_id=" + team_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {                        
                        team = response.team;
                        showFunction(team);
                    },
                    error: function(response) {
                        error = "Something wrong.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 1000,
                            html: true,
                        });
                    }
                });              
            });

            //seperate the show function to understand
            function showFunction(team){
                var content =   `<div class="form-group row">
                                    <label class="col-sm-4 col-form-label form-control"><b>Customer name</b></label>
                                    <div class="col-sm-8 form-control">`+team.name+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label form-control"><b>Customer designation</b></label>
                                    <div class="col-sm-8 form-control">`+team.designation+`</div>
                                </div>`+status;

                $('#showContent').html(content);
                $("#showTeam").modal(); 
            }

            //ajax edit code
            $('#teamsTable tbody').on( 'click', 'i.fa-pencil', function () { 
                $('.has-danger').removeClass('has-danger');
                updateThis = this;
                team_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('teams.index') }}" + "/" + team_id + "/edit",
                    data: "team_id=" + team_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {                        
                        team = response.team;
                        editFunction(team);
                    },
                    error: function(response) {
                        error = "Something wrong.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 1000,
                            html: true,
                        });
                    }
                });              
            });
            
            //seperate the edit function to understand
            function editFunction(team){
                $('#editedPublished').prop('checked', false);
                $('#editedUnpublished').prop('checked', false);

                $('#name').val(team.name); 
                $('#designation').val(team.designation); 
                $("#editTeam").modal(); 
            }

            //ajax update code
            $( "form[name='updateTeam']" ).on( "submit", function( event ) {
                $('.has-danger').removeClass('has-danger');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('teams.index') }}" + "/" + $('#team_id').val(),
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var team = response.team;
                        $('#editTeam').modal('hide');  
                        //hide the row.                      
                        table
                            .row( $(updateThis).parents('tr'))
                            .remove()
                            .draw();


                        //insert new row.
                        var rowNode = table.row.add([ 
                            team.name,
                            team.designation,
                            team.designation,
                            `<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Show" data-id="`+team.id+`"> <i class="fa fa-eye text-success m-r-10"></i> </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Edit" data-id="`+team.id+`"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="`+team.id+`"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
                            `] ).draw().node();

                        swal({
                            title: "<small class='text-success'>Success!</small>", 
                            type: "success",
                            text: "Customer updated successfully!",
                            timer: 2000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        data = JSON.parse(response.responseText);
                        error = "<div class='container'><ol class='text-center' style='padding:2rem;'>";
                        i=1;
                        if(data.errors.name) {
                            $( "input[name='name']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.name +"</li>";
                        }
                        if(data.errors.position){
                            $( "input[name='position']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.position +"</li>";
                        }
                        error = error + "</ol></div>";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 5000,
                            html: true,
                        });
                    }
                });
            });

            //ajax delete code
            $('#teamsTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                team_id = $(this).parent().data('id');
                var team = this;
                swal({   
                    title: "Are you sure?",   
                    text: "You will not be able to recover this imaginary file!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Yes, delete it!",   
                    cancelButtonText: "No, cancel plx!",   
                    closeOnConfirm: false,   
                    closeOnCancel: false 
                }, function(isConfirm){   
                    if (isConfirm) {     
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('teams.index') }}" + "/" + team_id,
                            dataType: "JSON",
                            data: {
                                id:team_id
                            },
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>", 
                                    type: "success",
                                    text: "Customer deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(team).parents('tr'))
                                    .remove()
                                    .draw();
                            },
                            error: function(response) {
                                error = "Failed.";
                                swal({
                                    title: "<small class='text-danger'>Error!</small>", 
                                    type: "error",
                                    text: error,
                                    timer: 1000,
                                    html: true,
                                });
                            }
                        });   
                    } else { 
                        swal({
                            title: "Cancelled", 
                            type: "error",
                            text: "Your team member is safe :)",
                            timer: 1000,
                            html: true,
                        });    
                    } 
                });
            }); 
        });
    </script>
@endsection

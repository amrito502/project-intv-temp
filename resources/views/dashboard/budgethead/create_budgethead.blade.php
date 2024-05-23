@extends('dashboard.layouts.app')

@section('content')
    <form method="POST" action="{{ route('budgethead.store') }}">
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
                        'columnClass' => 'col-md-6',
                        'company_id' => 0,
                    ])
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Budget Head Name</label>
                            <input class="form-control" name="name" id="name" type="text"
                                placeholder="Enter name">
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
        $(document).ready(function() {

            $('#action_menu').hide();

            $('#parent_id').change(function(e) {
                e.preventDefault();

                let parentValue = $(this).val();

                if (parentValue != '') {
                    $('#action_menu').show();
                } else {
                    $('#action_menu').hide();
                }

            });

        });
    </script>
@endsection

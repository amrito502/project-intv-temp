@extends('admin.layouts.master')

@section('content')


<div class="card" style="margin-bottom: 200px;">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">Withdraw Setting</h4>
            </div>
        </div>
    </div>

    <div class="card-body">

        <form action="{{ route('withdraw.settings') }}" method="POST" enctype="multipart/form-data">
            @csrf


            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bKash_no">bKash Number</label>
                        <input class="form-control" name="bKash_no" id="bKash_no" value="{{ Auth::user()->bKash_no }}"
                            type="text" placeholder="Type Bkash Number">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="rocket_no">Rocket Number</label>
                        <input class="form-control" name="rocket_no" id="rocket_no"
                            value="{{ Auth::user()->rocket_no }}" type="text" placeholder="Type Rocket Number">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nagad_no">Nagad Number</label>
                        <input class="form-control" name="nagad_no" id="nagad_no" value="{{ Auth::user()->nagad_no }}"
                            type="text" placeholder="Type Nagad Number">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bank_info">Bank Information</label>
                        <textarea class="form-control" name="bank_info" id="bank_info" rows="10">{{
                            Auth::user()->bank_info }}</textarea>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>

        </form>

    </div>

    {{-- <div class="card-footer">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div> --}}

</div>



@endsection

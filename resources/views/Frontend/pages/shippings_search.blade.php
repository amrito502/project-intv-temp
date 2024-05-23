@extends('frontend.master')

@section('mainContent')

<form action="{{url('/view-order')}}" method="post" class="register-form outer-top-xs" role="form">
    {{ csrf_field() }}


    <div class="container" style="margin-top: 20px;padding:20px;">
        <div class="row">
            <div class="col-md-12" style="text-align: center;">

                <h1 class="" font-size:20px; font-weight: bold>Email Address / Phone No</h1>

                <div class="form-group">
                    <input type="text" name="custemail" placeholder="Enter your email or phone no"
                        value="{{old('custemail')}}" class="form-control" style="width: 60%; display: inline"
                        id="exampleInputEmail2" required>
                </div>

                <button type="submit" class="btn-upper btn-lg btn btn-primary checkout-page-button">Search</button>

            </div>
        </div>
    </div>

</form>

@endsection

@section('custom-css')

<style>
    .lab-menu-vertical .menu-vertical,
    .laberMenu-top .menu-vertical {
        display: none !important;
    }

    .lab-menu-vertical .menu-vertical.lab-active,
    .laberMenu-top .menu-vertical.lab-active {
        display: block !important;
    }
</style>

@endsection

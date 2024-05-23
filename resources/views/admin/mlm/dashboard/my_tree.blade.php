@extends('admin.layouts.master')

@section('custom_css')
<style>
    .form-group {
        margin-bottom: 0px !important;
    }

    #tree {
        /* transform: rotate(180deg); */
        transform-origin: 50%;
    }

    #tree ul {
        position: relative;
        padding: 1em 0;
        white-space: nowrap;
        margin: 0 auto;
        text-align: center;
    }

    #tree ul::after {
        content: "";
        display: table;
        clear: both;
    }

    #tree li {
        display: inline-block;
        vertical-align: top;
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 1em 0.5em 0 0.5em;
    }

    #tree li::before,
    #tree li::after {
        content: "";
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 1px solid #ccc;
        width: 50%;
        height: 1em;
    }

    #tree li::after {
        right: auto;
        left: 50%;
        border-left: 1px solid #ccc;
    }

    #tree li:only-child::after,
    #tree li:only-child::before {
        display: none;
    }

    #tree li:only-child {
        padding-top: 0;
    }

    #tree li:first-child::before,
    #tree li:last-child::after {
        border: 0 none;
    }

    #tree li:last-child::before {
        border-right: 1px solid #ccc;
        border-radius: 0 5px 0 0;
    }

    #tree li:first-child::after {
        border-radius: 5px 0 0 0;
    }

    #tree ul ul::before {
        content: "";
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 1px solid #ccc;
        width: 0;
        height: 1em;
    }

    #tree li a {
        border: 1px solid #ccc;
        padding: 0.5em 0.75em;
        text-decoration: none;
        display: inline-block;
        border-radius: 5px;
        color: #333;
        position: relative;
        top: 1px;
        /* transform: rotate(180deg); */
    }

    #tree li a:hover,
    #tree li a:hover {
        background: #e9453f;
        color: #fff;
        border: 1px solid #e9453f;
    }

    #tree li a:hover+ul li::after,
    #tree li a:hover+ul li::before,
    #tree li a:hover+ul::before,
    #tree li a:hover+ul ul::before {
        border-color: #e9453f;
    }
</style>
@endsection

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">{{ @$title }}</h4>
            </div>

            <div class="col-md-3 offset-md-3">

                <div class="form-group">
                    <input type="text" name="uname" id="uname" class="form-control" placeholder="Search">
                </div>

            </div>

        </div>
    </div>

    <div class="card-body">
        <div class="">


            <div class="row justify-content-center" style="overflow-y: auto;">

                <div class="col-md-12">

                    <div id="tree">
                        <ul>
                            <li>
                                @include('admin.mlm.dashboard.layouts.tree.user_card', ['user'=> $data->user])
                                <ul>

                                    @foreach ($data->hands->sortBy('hand_id') as $levelTwoUser)
                                    <li>
                                        @include('admin.mlm.dashboard.layouts.tree.user_card', ['user'=> $levelTwoUser])

                                        <ul>
                                            @foreach ($levelTwoUser->hands()->sortBy('hand_id') as $levelThreeUser)
                                            <li>
                                                @include('admin.mlm.dashboard.layouts.tree.user_card', ['user'=> $levelThreeUser])
                                            </li>
                                            @endforeach
                                        </ul>

                                    </li>
                                    @endforeach

                                </ul>
                            </li>
                        </ul>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


@endsection


@section('custom-js')

<script>
    $(function() {

        $('#uname').keyup(function(e) {

            let uname = $(this).val();

            if (e.which == 13) {

                let url = "{{ route('my_tree') }}?uname=" + uname;

                window.location = url;

            }

        });

    });

</script>

@endsection

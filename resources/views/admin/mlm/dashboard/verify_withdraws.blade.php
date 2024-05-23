@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <button onclick="window.history.back()" type="button" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
                    <h3 class="text-center">Withdraw Request</h3>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="tile">
    <div class="tile-body" style="overflow-y: auto">
        <div class="">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="unverified" data-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="verified" data-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false">Paid</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="unverified">
                            <div class="mt-5">
                                @include('admin.mlm.dashboard.layouts.verifyWithdraws.unverified')
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="verified">
                            <div class="mt-5">
                                @include('admin.mlm.dashboard.layouts.verifyWithdraws.verified')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('custom-script')
<script>
    function toggleStatus(id){

        let transactionNo = $('#id_'+ id).val();

        console.log(transactionNo);

            axios.post(route('member.payment', {
                id,
                transactionNo,
            }))
            .then(function (response) {
            })
            .catch(function (error) {
            })
    }
</script>
@endsection

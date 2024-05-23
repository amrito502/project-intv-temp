@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')


<form action="{{ route('admin.balance.reduce.post') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" type="button"
                            class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center">Balance Reduce (Admin)</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="container">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>From</label>
                            <select name="from" id="from" class="select2"
                                onchange="showUserData('from','from-user-info')">
                                <option value="">Select An User</option>
                                @foreach ($data->members as $member)
                                <option value="{{ $member->id }}">{{ $member->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" placeholder="Enter Amount">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="from-user-info"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="to-user-info"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection


@section('custom-script')
<script>
    async function showUserData(changeInputId, outputClassName){

        let changeInputValue = $('#' + changeInputId).val();
        let outputClass = $('.' + outputClassName);

        if(changeInputValue == ''){
            return false;
        }

        let data = await axios.post(route('get.user.by.id', {id: changeInputValue}));

        let user = data.data.user;
        let balance = data.data.balance;

        let output = `
            <p>Name: ${user.name}</p>
            <p>Mobile: ${user.mobile}</p>
            <p>Balance: ${balance}</p>
        `;

        outputClass.html(output);

    }
</script>
@endsection

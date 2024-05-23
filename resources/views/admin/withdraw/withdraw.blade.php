@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $data->title }}</h4>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <form class="form-horizontal" action="{{ route('admin.withdraw.balance.save') }}" method="POST" enctype="multipart/form-data" id="newProduct"
                    name="newProduct">
                    {{ csrf_field() }}


                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">User</label>
                                <select name="user" id="user" required="required" class="form-control chosen-select">
                                    <option value="">Select User</option>
                                    @foreach ($data->users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->username }}</option>
                                    @endforeach
                                </select>
                                <span id="amount"></span>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="withdraw_amount">Withdraw Amount</label>
                                <input type="number" class="form-control" name="withdraw_amount" id="withdraw_amount" min="200" required="required">
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
@endsection


@section('custom-js')
<script>
    $(function () {

            $('#user').change(function (e) {
                e.preventDefault();

                let userId = $(this).val();


                axios.get(route('userWallet', userId))
                .then(function (response) {
                    let amount = response.data;
                    $('#amount').html('Wallet Amount: ' + amount);
                })
                .catch(function (error) {
                })

                console.log();

            });

        });
</script>
@endsection

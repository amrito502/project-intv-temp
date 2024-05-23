<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label for="transfer_account">Transfer Account</label>

            <select name="transfer_account" class="select2" id="transfer_account" required>
                <option value="">Select User</option>
                @foreach ($data->users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ( {{ $user->username }} )</option>
                @endforeach
            </select>

        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="transfer_amount">Transfer Amount</label>
            <input class="form-control" name="transfer_amount" id="transfer_amount" type="text" autocomplete="off"
                onfocus="this.removeAttribute('readonly');" readonly>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" name="password" id="password" type="password" autocomplete="off"
                onfocus="this.removeAttribute('readonly');" readonly>
        </div>
    </div>
</div>

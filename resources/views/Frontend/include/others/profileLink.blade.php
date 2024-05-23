<div style="padding: 15px 0px 25px 25px;">
    <h1 class="h3">Profile Link</h1>
    <?php
    use App\Customer;
        // $customerId = Session::get('customerId');
        // dd(Auth::user()->id);
        // $customers =Customer::where('id',Auth::user()->id)->first();
    ?>
    <ul class="nav nav-checkout-progress list-unstyled">
        @if (Auth::guard('customer')->user())
        <li><a href="{{route('customer.profile')}}">Profile</a></li>
        @endif
        <li><a href="{{route('customer.order')}}">Order</a></li>
        <li><a href="{{route('customer.logout')}}">Logout</a></li>
    </ul>
</div>
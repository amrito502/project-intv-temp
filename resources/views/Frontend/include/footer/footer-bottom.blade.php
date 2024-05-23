@php
  use App\ShippingCharges;
  use App\Product;
  use App\ProductSections;
@endphp
<div class="footer-bottom">
  <div class="container">
    <div class="row">
      <div class="tptncopyright col-xs-12 col-lg-7">
        © {{Date('Y')}} {{ Session('home_theme')['meta_info']->siteName }}. All Rights Reserved.
      </div>
      <div class="tptnpayment col-xs-12 col-lg-5">
        {{-- <img src="{{ asset('public/frontend/assets/image') }}/modules/tptncopyright/img/payment.png" alt="Payment Options"> --}}
        Developed By 
        <a href="http://technoparkbd.com/" target="_blank">
          Techno Park Bangladesh
        </a>
      </div>
    </div>
  </div>
</div>        


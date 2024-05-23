<?php
  $customerId = Session::get('customerId');
   if(!isset($customerId)){
      $orderHistory = url('/shipping-email');
   }else{
      $orderHistory = url('/customer/order');
   }
?>
<div class="footer-container">
  <div class="container">
    <div class="row">

      <div class="links col-xs-12 col-lg-3">
        <p class="h3">WHY CHOOSE US</p>
        <div class="title hidden-lg-up" data-target="#footer_sub_menu_85644" data-toggle="collapse">
          <span class="navbar-toggler collapse-icons">
          </span>
        </div>
        <div id="footer_sub_menu_85644" class="footer-toggle collapse">
          <ul>
            <li>
              <a class="cms-page-link" href="<?php echo url('/delivery-policy') ?>"
                title="Our terms and conditions of delivery">
                Delivery Policy
              </a>
            </li>
            <li>
              <a class="cms-page-link" href="<?php echo url('/payment-policy') ?>" title="Legal notice">
                Payment Policy
              </a>
            </li>
            <li>
              <a class="cms-page-link" href="<?php echo url('/refund-policy') ?>" title="Learn more about us">
                Refund Policy
              </a>
            </li>
            <li>
              <a class="cms-page-link" href="{{url('/blog')}}" title="Our secure payment method">
                Blog
              </a>
            </li>
            <li>
              <a class="cms-page-link" href="{{url('/terms-condition')}}" title="Use our form to contact us">
                Terms & Condition
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="links col-xs-12 col-lg-3">
        <p class="h3">CUSTOMER SERVICE</p>
        <div class="title hidden-lg-up" data-target="#footer_sub_menu_49452" data-toggle="collapse">
          <span class="navbar-toggler collapse-icons">
          </span>
        </div>
        <div id="footer_sub_menu_49452" class="footer-toggle collapse">
          <ul>

            @auth('customer')
            <li>
              <a class="custom-page-link" href="{{url('/customer/profile/'.$customerId)}}" title=""> My Account
              </a>
            </li>

            <li>
              <a class="custom-page-link" href="{{$orderHistory}}" title="">Order History
              </a>
            </li>
            @endauth

            <li>
              <a class="custom-page-link" href="{{route('faq')}}" title="">FAQ
              </a>
            </li>
            <li>
              <a class="custom-page-link" href="{{url('/about-us')}}" title="">About Us
              </a>
            </li>
            <li>
              <a class="custom-page-link" href="{{url('/contact-us')}}" title="">
                Contact Us
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div id="tptnsocial" class="links col-xs-12 col-lg-3">
        <p class="h3">CONTACT US</p>
        <div class="title hidden-lg-up" data-target="#footer_sub_menu_44829" data-toggle="collapse">
          <span class="navbar-toggler collapse-icons">
          </span>
        </div>
        <div id="footer_sub_menu_44829" class="footer-toggle collapse">
          <ul>
            <?php echo @$information->siteAddress1;  ?> <br>
            <?php echo @$information->siteAddress2;  ?>
          </ul>
          <ul>
            Email: &nbsp;<a
              href="mailto:<?php echo @$information->siteEmail1;  ?>"><?php echo @$information->siteEmail1;  ?></a> <br>
            Hotline: <a href="tel:<?php echo @$information->mobile1;  ?>"><?php echo @$information->mobile1;  ?></a>
          </ul>
          <?php
      if (@$socialLink->status == '1') {
    ?>
          <ul class="social-icons">
            <?php if($socialLink->facebook){ ?>
            <li class="facebook"><a href="{{$socialLink->facebook}}" title="Facebook"></a></li>
            <?php } ?>
            <?php if($socialLink->twitter){ ?>
            <li class="twitter"><a href="{{$socialLink->twitter}}" title="Twitter"></a></li>
            <?php } ?>
            <?php if($socialLink->google){ ?>
            <li class="googleplus"><a href="{{$socialLink->google}}" title="Google+"></a></li>
            <?php } ?>
            <li class="instagram"><a href="#" title="Instagram"></a></li>
            <?php if($socialLink->youtube){ ?>
            <li class="youtube"><a href="{{$socialLink->youtube}}" title="Youtube"></a></li>
            <?php } ?>
          </ul>
          <?php } ?>
        </div>
      </div>
      <div class="block_newsletter links col-xs-12 col-lg-3">
        <p class="h3">Newsletter</p>
        <div class="title hidden-lg-up" data-target="#footer_sub_menu_6080" data-toggle="collapse">
          <span class="navbar-toggler collapse-icons">
          </span>
        </div>
        <div id="footer_sub_menu_6080" class="footer-toggle collapse">
          <p id="block-newsletter-label">Get our latest news and special sales</p>
          <div class="input-wrapper">
            <form action="{{route('subscribe.save')}}" method="post">
              {{ csrf_field() }}
              <input name="subscribeEmail" type="email" value="" placeholder="Your email address"
                aria-labelledby="block-newsletter-label" required="1">
              <input type="hidden" name="action" value="0">
              <button name="submitNewsletter" type="submit"><i class="fa fa-check" aria-hidden="true"></i>
              </button>
              @if( count($errors) > 0 )
              <div style="display:inline-block;width: auto;" class="alert alert-danger">
                {{ $errors->first() }}
              </div>
              @endif
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
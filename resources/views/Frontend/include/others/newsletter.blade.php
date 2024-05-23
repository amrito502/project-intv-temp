<!-- Footer Top Container (Newsletter section) -->
<div class="container">
    <div class="row footer-top">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php
          if (@$socialLink->status == '1') {
            
        ?>
            <div class="socials-w">
              <h2>Follow socials</h2>
              <ul class="socials">
                <?php if($socialLink->facebook){ ?>
                <li class="facebook"><a href="{{$socialLink->facebook}}" target="_blank"><i class="fa fa-facebook"></i><span>Facebook</span></a></li>
                <?php } ?>

                <?php if($socialLink->twitter){ ?>
                <li class="twitter"><a href="{{$socialLink->twitter}}" target="_blank"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
                <?php } ?>
                <?php if($socialLink->google){ ?>
                <li class="google_plus"><a href="{{$socialLink->google}}" target="_blank"><i class="fa fa-google-plus"></i><span>Google Plus</span></a></li>
                <?php } ?>

                <?php if($socialLink->youtube){ ?>
                <li class="youtube"><a href="{{$socialLink->youtube}}" target="_blank"><i class="fa fa-youtube-play"></i><span>Youtube</span></a></li>
                <?php } ?>

                <?php if($socialLink->linkdin){ ?>
                <li class="linkedin"><a href="{{$socialLink->linkdin}}" target="_blank"><i class="fa fa-linkedin"></i><span>linkedin</span></a></li>
                <?php } ?>

                <li class="skype"><a href="https://www.instagram.com/piqood/" target="_blank"><i class="fa fa-instagram"></i><span>instagram</span></a></li>
              </ul>
            </div>
        <?php } ?>

        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="module newsletter-footer1">
                <div class="newsletter">

                    <div class="title-block">
                        <div class="page-heading font-title">
                            Signup for Newsletter
                        </div>
                        
                    </div>

                    <div class="block_content">
                        <form action="{{route('subscribe.save')}}" method="post" id="signup" name="signup" class="form-group form-inline signup send-mail">
                             {{ csrf_field() }}
                            <div class="form-group">
                                <div class="input-box">
                                    <input type="email" placeholder="Your email address..." value="" class="form-control" id="txtemail"name="subscribeEmail" size="55" required>
                                </div>
                                <div class="subcribe">
                                    <button class="btn btn-primary btn-default font-title" type="submit" name="submit">
                                Subscribe
                            </button>
                                </div>
                                @if( count($errors) > 0 )
                
                                <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>
                                
                            @endif
                            </div>
                        </form>


                    </div>
                    <!--/.modcontent-->

                </div>

            </div>
        </div>
    </div>
</div>

<!-- /Footer Top Container -->
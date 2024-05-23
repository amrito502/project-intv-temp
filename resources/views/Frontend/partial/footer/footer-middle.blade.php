<div class="laberFooter-center">
    <div class="laberFooter-center2">
        <div class="container">
            <div class="row">
                <div class="top-logo col-md-2 hidden-sm-down" id="_desktop_logo">
                    <h1>
                        <a href="{{ route('home.index') }}">
                            <img class="logo img-responsive"
                                src="{{ asset(Session('home_theme')['meta_info']->siteLogo) }}"
                                alt="Super Shop Responsive Prestashop 1.7 Theme">
                        </a>
                    </h1>
                </div>
                <div class="col-md-5">
                    <div class="block_newsletter">
                        <p class="h3 newsletter-title">Newsletter</p>
                        <div id="footer_sub_menu_newsletter" class="">
                            <div class="conditions">
                                <p class="conditions">You may unsubscribe at any moment. For that purpose, please find
                                    our contact info in the legal notice.</p>

                            </div>
                            <form action="{{ route('subscribe.save') }}" method="post">
                                {{ csrf_field() }}
                                <div class="input-wrapper">
                                    <input name="subscribeEmail" type="email" value="" placeholder="Your email address"
                                           aria-labelledby="block-newsletter-label">
                                </div>
                                <input class="btn btn-primary" name="submitNewsletter" type="submit" value="Ok">
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="offset-md-1 col-md-4">
                    <div class="laber-social">
                        <p class="h3 newsletter-title">Follow Us</p>
                        <ul>
                            <li class="laber-facebook">
                                <a href="{{ session('home_theme')['social_icons']->facebook }}" title="Facebook"
                                   target="_blank">
                                    <span><i class="fa fa-facebook"></i><span class="social-text">Facebook</span></span>
                                </a>
                            </li>
                            <li class="laber-twitter">
                                <a href="{{ session('home_theme')['social_icons']->twitter }}" title="Twitter"
                                   target="_blank"><span><i class="fa fa-twitter"></i><span
                                                class="social-text">Twitter</span></span></a></li>
                            <li class="laber-youtube">
                                <a href="{{ session('home_theme')['social_icons']->youtube }}" title="YouTube"
                                   target="_blank"><span><i class="fa fa-youtube"></i><span
                                                class="social-text">YouTube</span></span></a></li>
                            <li class="laber-googleplus">
                                <a href="{{ session('home_theme')['social_icons']->google }}" title="Google +"
                                   target="_blank"><span><i class="fa fa-google-plus"></i><span class="social-text">Google +</span></span></a>
                            </li>
                            {{--              <li class="laber-pinterest">--}}
                            {{--                <a href="#" title="Pinterest" target="_blank"><span><i class="fa fa-pinterest-p"></i><span class="social-text">Pinterest</span></span></a></li>--}}
                            {{--              <li class="laber-instagram">--}}
                            {{--                <a href="#" title="Instagram" target="_blank"><span><i class="fa fa-instagram"></i><span class="social-text">Instagram</span></span></a></li>--}}
                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="laberFooter-center3">
        <div class="container">
            <div class="row">
                <div id="tags_block_footer">
                    @php
                        $i = -1;
                        $colors = ['#a6cada', '#ffd549','#82a3cc','#c75347','#59c6bb','#f59fba','#a6cada', '#ffd549','#82a3cc','#c75347','#59c6bb','#f59fba','#a6cada', '#ffd549','#82a3cc','#c75347','#59c6bb','#f59fba','#a6cada', '#ffd549','#82a3cc','#c75347','#59c6bb','#f59fba',];
                    @endphp
                    @foreach(session('home_theme')['home_theme']['category_one']['banner_redirect_category'] as $catId)
                        @php
                            $footerCat = session('home_theme')['categories']->where('id', $catId)->first();

                            if(!$footerCat){
                                continue;
                            }

                            $i++;


                        @endphp
                        <p class="category-tags"><span class="tags-title bluemess"
                                                       style="background: {{ $colors[$i] }}; color: #fff;"> {{ @$footerCat->categoryName }} </span>
                            <span
                                    class="corner-icon bluemess" style="border-left-color: {{ $colors[$i] }};"></span>
                            <span
                                    class="inner-tags">

                                @php
                                    $subCats = session('home_theme')['categories']->where('parent', $catId)->where('showInFooter', 'yes');
                                @endphp
                                @foreach($subCats as $subCat)
                                    <a href="{{ route('product.productByCategory', [$subCat->id, $subCat->categoryName]) }}">{{ $subCat->categoryName }}</a>
                                @endforeach

                            </span>
                        </p>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
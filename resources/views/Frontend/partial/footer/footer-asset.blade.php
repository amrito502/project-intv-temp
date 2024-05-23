<script type="text/javascript" src="{{ asset('frontend/mak64/js/jquery.cookie.js') }}"></script>

<script>
    $('.laberBottom').click(function () {
        // $('#blockcart-modal').modal('show');
    });
</script>

<script type="text/javascript" src="{{ asset('frontend/mak64/js/bottom-d6a28929.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('public/frontend') }}/assets/js/owl.carousel.min.js" ></script> --}}
{{--<script type="text/javascript" src="{{ asset('public/frontend') }}/assets/js/bootstrap-slider.min.js"></script>--}}

<script type="text/javascript">
    $(document).ready(function () {
        var owl = $(".list_manufacturer");
        owl.owlCarousel({
            items: 7,
            itemsDesktop: [1199, 5],
            itemsDesktopSmall: [991, 4],
            itemsTablet: [767, 3],
            itemsMobile: [480, 2],
            navigation: false,
            slideSpeed: 2000,
            paginationSpeed: 2000,
            rewindSpeed: 2000,
            autoPlay: false,
            stopOnHover: false,
            pagination: false,
            addClassActive: true,
        });
        $(".next-manufacturer").click(function () {
            owl.trigger('owl.next');
        })
        $(".prev-manufacturer").click(function () {
            owl.trigger('owl.prev');
        })
    });
</script>

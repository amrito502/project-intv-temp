<div id="blockcart-modal" class="modal fade out" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     style="display: none; padding-left: 0px; top: 10%">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title h6 text-xs-center" id="myModalLabel">
{{--                    <i class="material-icons"></i>--}}
                    <i class="fa fa-check" aria-hidden="true"></i>
                    Product
                    successfully added to your shopping cart</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 divide-right">
                        <div class="row" id="popup-product">
                            <div class="col-md-6">
                                <img class="product-image"
                                     src=""
                                     alt="" title="" itemprop="image">
                            </div>
                            <div class="col-md-6">
                                <h6 class="h6 product-name" id="popup-product-name"></h6>
                                <p id="popup-main-product-price"></p>

{{--                                <span><strong>Paper Type</strong>: Ruled</span><br>--}}
                                <!--<p><strong id="popup-product-qty">Quantity:</strong>&nbsp;1</p>-->
                                <p>Quantity: <input type="number" min="1" id="popup-product-qty" value="1"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cart-content">
                            <p class="cart-products-count" id="popup-products-count">There are 4 items in your cart.</p>
                            <p id="popup-product-price"></p>
{{--                            <p><strong>Total shipping:</strong>&nbsp;$7.00 </p>--}}
                            <p id="popup-vat"><strong>Vat:</strong></p>
                            <p id="popup-grand-total"><strong>Total:</strong></p>
                            <button type="button" class="btn btn-secondary mt-1" data-dismiss="modal">Continue shopping
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-primary mt-1">
{{--                                <i class="material-icons"></i>--}}
                                <i class="fa fa-check" aria-hidden="true"></i>

                                proceed to
                                checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

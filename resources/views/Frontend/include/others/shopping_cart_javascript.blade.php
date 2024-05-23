{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var fadeTime = 0;

    window.onload = function () {
        minicartProduct();
        MainCartProduct();
        getCartData();
    }

    //add cart
    function addCart(productId) {
        $.ajax({
            type: 'get',
            url: '<?php echo url('/cart/addItem');?>/' + productId,
            dataType: "JSON",
            success: function (response) {

                // show popup data start
                $('#popup-product').html('');
                $('#popup-product').html(response.product);
                inPopUpCartDetail();
                // show popup data end


                itemcount();
                minicartProduct();
                getCartData();

                $('#blockcart-modal').modal('show');

            }

        });
    };


    function cartSingleProduct(rowId) {
        $.ajax({
            type: 'get',
            url: "{{route('cart.singleProduct')}}",
            data: {rowId:rowId},
            success: function (response) {

                // show popup data start
                $('#popup-product').html('');
                $('#popup-product').html(response);
                inPopUpCartDetail();
                // show popup data end

                itemcount();
                minicartProduct();
                getCartData();
                console.log(response);

                // $('#blockcart-modal').modal('show');

            }

        });
    };


    function getCartData(){

        $.ajax({
            type: "GET",
            url: '{{ route('cartData') }}',
            data: {},
            success: function (response) {

                updateMiniCart(response);
                mainCartPage(response);

            }
        });

    }


    function mainCartPage(response){

        let cartHtml = '';

        let totalItemCount = getTotalItemFromResponse(response);


        for(const p in response){

            let product = response[p];

            let cartProduct = `
            <li class="cart-item">
                <div class="product-line-grid">
                    <!--  product left content: image-->
                    <div class="product-line-grid-left col-md-3 col-xs-4">
                        <span class="product-image media-middle">
                            <img src="${product.attributes.image}"
                                alt="${product.name}" style="width: 50%">
                        </span>
                    </div>

                    <!--  product left body: description -->
                    <div class="product-line-grid-body col-md-4 col-xs-8">
                        <div class="product-line-info">
                            <a class="label" href="#" data-id_customization="0">${product.name}</a>
                        </div>

                         <div class="product-line-info product-price h5 has-discount d-none">
                             <div class="product-discount">
                                 <span class="price">BDT ${(product.price).toFixed(2)}</span>
                             </div>

                         </div>

                    </div>

                    <!--  product left body: description -->
                    <div
                        class="product-line-grid-right product-line-actions col-md-5 col-xs-12">
                        <div class="row">
                            <div class="col-xs-4 hidden-md-up"></div>
                            <div class="col-md-10 col-xs-6">
                                <div class="row">
                                    <div class="col-md-6 col-xs-6 qty">
                                        <div class="input-group bootstrap-touchspin">

                                            <input onchange="UpdateShoppingCart('${product.id}')" onkeyup="UpdateShoppingCart('${product.id}')"
                                                class="js-cart-line-product-quantity w-100 form-control"
                                                id="inputQty_${product.id}"
                                                type="number" value="${product.quantity}"
                                                name="product-quantity-spin" min="1"
                                                style="display: block;">

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-2 price">
                                        <span class="product-price">
                                            <strong>BDT ${(product.price * product.quantity).toFixed(2)}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-2 text-xs-right">
                                <div class="cart-line-product-actions">
                                    <a class="remove-from-cart" rel="nofollow" href="#" onclick="removeCartRow('${product.id}')"
                                        data-link-action="delete-from-cart" data-id-product="1"
                                        data-id-product-attribute="1" data-id-customization="">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                </li>
            `;

            cartHtml += cartProduct;

        }

        $('#cart-items').html('');
        $('#subtotal').html('');
        // $('#itemCount').html('');
        $('#totalVat').html('');
        $('#grandTotal').html('');

        var vat = (totalItemCount.price * 0.05);
        var grandTotal = totalItemCount.price + 60 + vat;

        $('#cart-items').html(cartHtml);
        $('#total').html(`BDT ${totalItemCount.originalPrice.toFixed(2)}`);
        $('#discount').html(`BDT ${(totalItemCount.originalPrice - totalItemCount.price).toFixed(2)}`);
        $('#subtotal').html(`BDT ${totalItemCount.price.toFixed(2)}`);
        $('#itemCount').html(`${totalItemCount.quantity} Items value`);

        $('#totalVat').html(`BDT ${vat.toFixed(2)}`);
        $('#grandTotal').html(`BDT ${grandTotal.toFixed(2)}`);

    }


    function updateMiniCart(response){

        let totalItemCount = getTotalItemFromResponse(response);
        $('#products_count_minicart').html(`Your Cart (${totalItemCount.quantity})`);

        $('#miniCartTotalAmount').html(`৳ ${totalItemCount.price}`);

        let miniCartProductsHtml = '';

        for(const p in response){
            let product = response[p];

            let miniCartProductSingle = `
                <div class="products">
                    <div class="img">

                        <a href="#"
                            class="thumbnail product-thumbnail">
                            <img src="${product.attributes.image}"
                                alt=""
                                data-full-size-image-url="${product.attributes.image}">
                        </a>

                    </div>
                    <div class="cart-info">
                        <h2 class="h2 productName" itemprop="name">
                            <a href="#">${product.name}</a>
                        </h2>
                        <div class="laberPrice">
                            <span class="quantity">${product.quantity}X</span>
                            <span class="price">৳ ${product.price}</span>
                        </div>
                    </div>
                    <p class="remove_link">
                        <a rel="nofollow" href="#" onclick="removeCartRow('${product.id}')">
                            <i class="fa fa-trash"></i>
                        </a>
                    </p>
                </div>
            `;

            miniCartProductsHtml += miniCartProductSingle;

            // console.log(product);
        }


        $('#productsParentDiv').html('');
        $('#productsParentDiv').html(miniCartProductsHtml);

        // console.log(response);
        // console.log(totalItemCount);

    }


    function inPopUpCartDetail(response) {
        $.ajax({
            type: "GET",
            url: '{{ route('cartData') }}',
            data: {},
            success: function (response) {

                let totalItemCount = getTotalItemFromResponse(response);
                let total = totalItemCount.price;
                var vat = total * 0.05;
                var grandTotal = total + vat;



                $('#popup-products-count').html('');
                $('#popup-product-price').html('');
                // $('#popup-product-tax').html('');
                $('#popup-grand-total').html('');

                $('#popup-products-count').html(`There are  ${totalItemCount.quantity} items in your cart.`);
                $('#popup-product-price').html(`Total products <input type="text" class="form-control" value="BDT ${(totalItemCount.price).toFixed(2)}" readonly  style="width:69%;">`);
                // $('#popup-product-tax').html(`<strong>Taxes</strong>&nbsp;৳ ${totalItemCount.tax}`);
                $('#popup-vat').html(`Vat<input type="text" class="form-control" value="BDT ${vat.toFixed(2)}" readonly  style="width:69%;">`);
                $('#popup-grand-total').html(`Total<input type="text" class="form-control" value="BDT ${grandTotal.toFixed(2)}" readonly style="width:69%;">`);

            }
        })
    }

    function getTotalItemFromResponse(products){
        let totalQty = {
            quantity: 0,
            price: 0,
            Mainprice: 0,
            originalPrice: 0,
        };

        for(const p in products){
            totalQty.quantity += +products[p].quantity;
            totalQty.price += +products[p].attributes.subtotal;
            totalQty.Mainprice = products[p].price;
            totalQty.originalPrice += +products[p].attributes.originalPrice * +products[p].quantity;
        }

        return totalQty;
    }


    //add cart from single product page
    function addCartFromSingleProduct(productId) {
        var quantity = $('#quantity_wanted').val();
        $.ajax({
            type: 'get',
            url: '<?php echo url('/cart/addItemFromSingleProduct');?>/' + productId + '/' + quantity,
            dataType: "JSON",
            success: function (response) {

                /*$("#blockcart-modal").modal();
                var product = response.product;
                $('#product').html(product);
                $('#popup_productSubtotal').text("৳ " + response.total);
                $('#pop_cart_count').text(response.cartCount);*/

                // show popup data start
                $('#popup-product').html('');
                $('#popup-product').html(response.product);
                inPopUpCartDetail();
                // show popup data end
                $('#blockcart-modal').modal('show');

                itemcount();
                minicartProduct();
                getCartData();

            }
        });
    };

    function UpdateShoppingCart(rowId) {
        var qty = $('#inputQty_' + rowId).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('carts.update') }}",
            dataType: "JSON",
            data: {
                rowId: rowId,
                qty: qty,
            },
            success: function (response) {
                minicartProduct();
                MainCartProduct();
                itemcount();
                getCartData();
                cartSingleProduct(rowId);
            },
        });
    }


    //remove from mini cart
    function removeCartRow(rowsId) {
        $.ajax({
            type: "GET",
            url: "{!! url('carts') !!}" + "/" + rowsId + "/remove",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                minicartProduct();
                MainCartProduct();
                itemcount();
                recalculateCart();
                getCartData();
            },
            error: function (response) {
            }
        });
    };

    function recalculateCart() {
        var subtotal = 0;
        var miniSubtotal = 0;
        /* Sum up row totals */
        $('.cart-product-subtotal').each(function () {
            subtotal += parseInt($(this).children('.cart-sub-total-price').text());
        });

        $('.miniProductTotal').each(function () {
            miniSubtotal += parseInt($(this).children('.miniSubTotalPrice').text());
            /*console.log(miniSubtotal);*/
        });
        if (subtotal == 0) {
            var shippingCharge = 0;
            $('#shippingCharge').text("0");
        } else {
            var shippingCharge = $('#shippingCharge').text();
        }

        if (miniSubtotal == 0) {
            var miniShippingCharge = 0;
            $('#miniShippingCharge').text("0");
        } else {
            var miniShippingCharge = $('#miniShippingCharge').text();
        }

        var grand_total = parseInt(subtotal) + parseInt(shippingCharge);
        var miniTotal = parseInt(miniSubtotal) + parseInt(miniShippingCharge);

        /* Update totals display */
        $('.total-value').fadeOut(fadeTime, function () {
            $('.cart-subtotal').text("BDT " + subtotal);
            $('.cart-total-amount').html(grand_total);
            /*$('.miniSubtotal').text("৳ " + miniSubtotal);*/
            $('.miniTotal').html(miniTotal);
            $('.total-value').fadeIn(fadeTime);
            itemcount();
        });

    }

    function minicartProduct() {
        $.ajax({
            type: "GET",
            url: '<?php echo url('/cart/minicartProduct');?>',
            data: {},
            success: function (response) {
                $('#minicartProduct').html(response);
            }
        })
    }

    function MainCartProduct() {
        $.ajax({
            type: "GET",
            url: '<?php echo url('/cart/mainCartProduct');?>',
            data: {},
            success: function (response) {
                // console.log(response);
                $('#cartProduct').html(response.cartProduct);
                $('#cartSummary').html(response.cartSummary);
            }
        })
    }

    //subtotal for cart item
    function itemcount() {
        $.ajax({
            type: "GET",
            url: '<?php echo url('/cart/item');?>',
            data: {},
            success: function (response) {
                // console.log(response);
                var data = response.carts + ` Item(s)`;
                /* $('#cart-item').html(data);*/
                $('.cart_count').html(data);
            }
        })
    }
</script>

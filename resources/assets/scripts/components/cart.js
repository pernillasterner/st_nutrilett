/* eslint-disable no-unused-vars */

import { stokpress } from '../util/helper';
/* eslint-disable no-undef */

var Cart = {};

( function ( $ ) {
    var editItem = '.js-cart-edit-item';
    var cartForm = '.js-selectProductSingle';
    var navCart = '.navbar-cart';
    var cartItemCount = $( '.js-item-count' );
    var cartItems = $( '.js-navbar-cart' );
    var cartItemsMobile = $( '.js-navbar-cart-mobile' );
    // var cartNavButton = $('.navbar-cart-button');
    var buttonText = '.js-button-text';
    // var singlePageScope = $( 'body.single' );
    var cartAjaxRequestEnable = true;
    var checkoutSection =  document.getElementById('js-checkout-content');

    Cart.ajaxCall = function ( type, data, url, button ) {
        // To avoid double send of ajax request
        if ( !cartAjaxRequestEnable ) {
            return;
        }

        $.ajax( {
            url: url,
            data: data,
            type: type,
            dataType: 'json',
            beforeSend: function () {
                cartAjaxRequestEnable = false;

                if ( button && button.length > 0 ) {
                    button.attr( 'disabled', 'disabled' );
                    button.addClass( 'is-loading' );
                }
            },
            success: function ( result ) {
                // Update cart item count
                cartItemCount.each( function () {
                    $( this ).text( result.totalItems );
                } );

                cartItems.html( result.basket );
                cartItemsMobile.find( '.navbar-cart' ).html( '<div class="cart">' + cartItems.find( '.cart' ).html() + '</div>' );
                Cart.toggleCart( 'open' );

                if (typeof(checkoutSection) != 'undefined' && checkoutSection != null && type == 'POST') {
                    var productStatusContainer = $('#js-product-status-popup').find('.product-status-container');
                    if(result.success) {
                        productStatusContainer.addClass('success');
                        productStatusContainer.removeClass('error');

                        $( document ).find('.js-h2').removeClass('d-none');
                        $( document ).find('.js-cart-item-holder').removeClass('d-none');
                        $( document ).find('.js-payment-holder').removeClass('d-none');
                        $( document ).find('.js-no-item-holder').addClass('d-none');

                        var resultBasket = '';
                        var cartContainer = $( document ).find('#js-selectedItems');
                        var cartHeader = '<div class="cart-item cart-item-header d-none d-lg-flex justify-content-between">'+cartContainer.find('.cart-item-header').html()+'</div>';

                        // replace js-cart-edit-item with js-edit-item class that is used for checkout
                        resultBasket = result.basket.replace(/js-cart-edit-item/gi, 'js-edit-item')
                        // append is_checkout=1 at end of add/minus/delete action
                        resultBasket = resultBasket.replace(/&esc_amount=-100"/gi, '&esc_amount=-100&is_checkout=1"');
                        resultBasket = resultBasket.replace(/&esc_amount=-1"/gi, '&esc_amount=-1&is_checkout=1"');
                        resultBasket = resultBasket.replace(/&esc_amount=1/gi, '&esc_amount=1&is_checkout=1');
                        resultBasket = resultBasket.replace(/class="cart"/gi, '');
                        resultBasket = resultBasket.replace(/class="cart-group"/gi, '');
                        resultBasket = resultBasket.replace(/class="cart-list"/gi, '');
                        resultBasket = resultBasket.replace(/class="navbar-button cart-btn"/gi, 'class="navbar-button cart-btn" style="display:none;"');
                        result.basket = cartHeader + resultBasket;
                        Checkout.updateHtml(result);

                        $('#js-product-status-popup').modal('show');
                        setTimeout(function() {
                            $('#js-product-status-popup').modal('hide');
                        }, 2000);
                    }
                    
                    if(result.error) {
                        productStatusContainer.addClass('error');
                        productStatusContainer.removeClass('success');

                        $('#js-product-status-popup').modal('show');
                        setTimeout(function() {
                            $('#js-product-status-popup').modal('hide');
                        }, 2000);
                    }
                }
            },
            complete: function () {
                setTimeout( function () {
                    Cart.toggleCart( 'close' );

                    if ( button && button.length > 0 ) {
                        button.removeAttr( 'disabled' );
                        button.removeClass( 'is-loading' );
                    }

                    cartAjaxRequestEnable = true;
                    $( editItem ).prop( 'disabled', false );
                }, 2000 );
            },
            error: function ( request ) {
                console.debug( request );
            },
        } );
    };

    Cart.toggleCart = function ( action ) {
        var cartContainer = $( navCart );
        var body = $( 'body' );

        if ( !cartContainer ) { return; }

        if ( action === 'open' ) {
            cartItems.addClass( 'is-active' );
            cartItemsMobile.find( '.is-touch' ).addClass( 'is-active' );

            setTimeout( () => {
                Cart.toggleCart( 'close' );
            }, 3000 );
        } else if ( action === 'close' ) {
            cartItems.removeClass( 'is-active' );
            cartItemsMobile.find( '.is-touch' ).removeClass( 'is-active' );
        }

    };

    Cart.add = function ( _this ) {
        var buttonEl = _this.find( 'button' );

        // if (_this.find('input[name="esc_product_item"]:checked').length > 0 || _this.find('select[name="esc_product_item"]').val()) {
        var data = _this.serialize();

        // if (typeof (fbq) == 'function' && _this.data('name')) {
        //     fbq('track', 'AddToCart', {
        //         'content_name': _this.data('name'),
        //         'content_ids': [_this.data('sku')],
        //         'content_type': 'product'
        //     });
        // }

        Cart.ajaxCall( 'POST', data, null, buttonEl );

        // } else {

        //     // Display error in button
        //     Cart.updateButtonText( 'error', buttonEl );

        //     var isMobile = stokpress.isMobile() || stokpressViewPort.documentWidth().width < 720;
        //     var navHeight = $('nav').height();
        //     var scrollToPos = 0;

        //     // Scroll to sizes
        //     if (isMobile) {
        //         scrollToPos = Math.abs(document.documentElement.clientHeight - buttonEl.offset().top - (buttonEl.height() + navHeight));
        //     }

        //     // Scroll to size error if current page is single page
        //     if (singlePageScope.length) {
        //         $('html, body').animate({
        //             scrollTop: scrollToPos,
        //         }, 1000);
        //     }
        // }
    };

    Cart.updateButtonText = function ( dataAttr, buttonEl ) {
        if ( !buttonEl ) { return; }

        var textVal = buttonEl.data( dataAttr );
        var buttonTextEl = buttonEl.find( buttonText );

        if ( buttonTextEl ) {
            buttonTextEl.text( textVal );
        }
    };

    Cart.init = function () {
        let timeout = null;

        // Add to bag
        $( document ).on( 'submit', cartForm, function ( e ) {
            e.preventDefault();

            Cart.add( $( this ) );
        } );

        // Has size selected
        $( document ).on( 'change', 'input[name="esc_product_item"], select[name="esc_product_item"]', function ( e ) {
            e.preventDefault();

            Cart.updateButtonText( 'text', $( cartForm ).find( 'button' ) );
        } );

        // Edit product quantity
        $( document ).on( 'click', editItem, ( e ) => {
            let target = $( e.target ),
                quantityField = target.siblings( '.js-qty' ),
                quantity = parseInt( quantityField.val() );

            if ( target.hasClass( 'js-add' ) ) {
                quantity++;
            } else if ( target.hasClass( 'js-subtract' ) && quantity > 1 ) {
                quantity--;
            } else if ( target.parent( 'button' ).hasClass( 'delete-btn' ) ) {
                Cart.ajaxCall( 'GET', null, target.parent( 'button' ).data( 'href' ), null );
                return;
            }

            quantityField.val( quantity );

            if ( timeout ) {
                clearTimeout( timeout );
            }

            timeout = setTimeout( () => {
                clearTimeout( timeout );

                let newValue = parseInt( quantityField.val() ),
                    oldValue = parseInt( quantityField.data( 'value' ) ),
                    difference = newValue - oldValue,
                    url = '';

                if ( difference > 0 ) {
                    url = quantityField.siblings( '.js-add' ).data( 'href' );
                } else if ( difference < 0 ) {
                    url = quantityField.siblings( '.js-subtract' ).data( 'href' );
                } else {
                    return;
                }

                url = stokpress.replaceUrlParam( url, 'esc_amount', difference );

                $( editItem ).prop( 'disabled', true );
                Cart.ajaxCall( 'GET', null, url, null );
            }, 500 );
        } );

        // Sychronize desktop cart to mobile cart
        cartItemsMobile.find( '.js-item-count' ).text( cartItems.find( '.cart-count' ).text() );
        cartItemsMobile.find( '.navbar-cart' ).html( '<div class="cart">' + cartItems.find( '.cart' ).html() + '</div>' );
    };

    Cart.init();

} )( jQuery );

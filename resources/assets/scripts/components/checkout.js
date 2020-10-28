/* eslint-disable no-unused-vars */

import { stokpress } from '../util/helper';
/* eslint-disable no-undef */

( function ( $ ) {
  var Checkout = {};

  var editProduct = '.js-edit-item';
  var cartContainer = $( document ).find( '#js-selectedItems' );
  var selectedItemsContainer = $( document ).find( '#js-selectedItems--selection' );
  var selectedTotalsContainer = $( document ).find( '#js-selectedTotals' );
  var voucherContainer = $( document ).find( '#js-voucher-field' );
  var paymentMethodContainer = $( document ).find( '#js-selectedPaymentMethod' );
  var newsletterContainer = $( document ).find( '#js-selectedNewsletter' );
  var giftContainer = $( document ).find( '#js-selectedGiftwrap' );
  var paymentFieldsContainer = $( document ).find( '#js-paymentFields' );
  var commentContainer = $( document ).find( '#js-selectedComment' );
  var shippingMethodContainer = $( document ).find( '#js-selectedShippingMethod' );
  var scope = $( document ).find( '#js-checkout-content' );
  var cartAjaxRequestEnable = true;

  Checkout.init = function () {

    $( document ).on( 'change', '#voucher-checkbox', function () {
      if ( this.checked ) {
        $( '.js-vouher-input' ).removeClass( 'd-none' );
      } else {
        $( '.js-vouher-input' ).addClass( 'd-none' );
      }
    } );

    // Quick fix for pnr lookup
    $( '#lookup_pn' ).off( 'click' ).on( 'click', function ( e ) {
      e.preventDefault();
      $.ajax( {
        data: { 'personal_number': $( '#personal_number' ).val() },
        type: 'POST',
        url: '/wp-json/centra/v1/lookup',
        dataType: 'JSON',
        success: function ( data ) {

          if ( data.address1 ) {

            $.each( data, function ( index, field ) {
              $( '#address_' + index + '' ).val( field );
            } );

          }

        },
      } );
    } );

    // Added some quick form validation
    $( '.template-checkout' ).on( 'submit', '#esc_purchase', function () {

      var hasError = false;

      var formFields = [
        'email',
        'phoneNumber',
        'firstName',
        'lastName',
        'address1',
        'city',
        'zipCode',
        'termsAndConditions',
      ];

      $.each( formFields, function ( index, field ) {

        var formField = $( '#address_' + field + ':visible' );

        formField.removeClass( 'is-invalid' );

        if ( typeof ( formField.val() ) !== 'undefined' ) {

          if ( !formField.val() ) {
            formField.addClass( 'is-invalid' );
            hasError = true;
          } else if ( field === 'email' ) {
            if ( !Checkout.validateEmail( formField.val() ) ) {
              formField.addClass( 'is-invalid' );
              hasError = true;
            }
          } else if ( field === 'termsAndConditions' ) {
            if ( !formField.is( ':checked' ) ) {
              formField.addClass( 'is-invalid' );
              hasError = true;
            }
          }
        }
      } );


      if ( hasError ) {
        return false;
      }

    } );

    $( '.template-checkout' ).on( 'focus', '#js-paymentFields input', function () {
      $( this ).removeClass( 'is-invalid' );
    } );

    // Add/Remove product
    if ( $( document ).find( editProduct ) ) {
      let timeout = null;

      $( document ).find( editProduct ).off( 'click' ).on( 'click', function ( e ) {
        e.preventDefault();

        let target = $( this ),
          quantityField = target.siblings( '.js-qty' ),
          quantity = parseInt( quantityField.val() );

        if ( target.hasClass( 'js-add' ) ) {
          quantity++;
        } else if ( target.hasClass( 'js-subtract' ) && quantity > 1 ) {
          quantity--;
        } else if ( target.hasClass( 'delete-btn' ) ) {
          Checkout.processItems( target.data( 'href' ) );
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

          $( editProduct ).prop( 'disabled', true );
          Checkout.processItems( url );
        }, 500 );
      } );
    }

    // Voucher
    var voucherField = $( document ).find( '#js-voucher-field #voucher' );
    if ( voucherField ) {
      voucherField.off( 'keydown' ).on( 'keydown', function ( e ) {
        if ( e.keyCode !== 13 ) { return; }

        e.preventDefault();
        Checkout.voucherProcess( $( this ).parent().next() );
      } );
    }

    var voucherButton = $( document ).find( '#js-voucher-field button' );
    if ( voucherButton ) {
      voucherButton.off( 'click' ).on( 'click', function ( e ) {
        e.preventDefault();
        Checkout.voucherProcess( $( this ) );
      } );
    }

    // Newsletter
    if ( newsletterContainer.find( ':checkbox' ) ) {
      newsletterContainer.find( ':checkbox' ).off( 'change' ).on( 'change', function ( e ) {
        e.preventDefault();
        Checkout.processNewsletter( 'click' );
      } );
    }

    // Gift
    if ( giftContainer.find( ':checkbox' ) ) {
      giftContainer.find( ':checkbox' ).off( 'change' ).on( 'change', function ( e ) {
        e.preventDefault();
        Checkout.processComment( 'click' );
      } );
    }

    // Comment
    if ( commentContainer.find( 'textarea' ) ) {
      commentContainer.find( 'textarea' ).off( 'blur' ).on( 'blur', function ( e ) {
        e.preventDefault();
        Checkout.processComment( 'click' );
      } );
    }

    // Payment Method
    var paymentOptions = $( document ).find( '#js-selectedPaymentMethod :radio' );
    if ( paymentOptions ) {
      paymentOptions.off( 'change' ).on( 'change', function ( e ) {
        e.preventDefault();
        Checkout.processPaymentMethod( paymentMethodContainer );
      } );
    }

    // Shipping Method
    var shippingOptions = $( document ).find( '#js-selectedShippingMethod :radio' );
    if ( shippingOptions ) {
      shippingOptions.off( 'change' ).on( 'change', function ( e ) {
        e.preventDefault();
        Checkout.processShippingMethod( shippingMethodContainer );
      } );
    }

    // Country
    var countryOptions = $( document ).find( '#js-selectedCountry .js-country-item' );
    if ( countryOptions ) {
      countryOptions.off( 'click' ).on( 'click', function ( e ) {
        e.preventDefault();
        Checkout.countryChangeProcess( this.dataset.code, '', false );
      } );
    }

    // State
    var stateOptions = $( document ).find( '#js-selectedState .js-state-item' );
    if ( stateOptions ) {
      stateOptions.off( 'click' ).on( 'click', function ( e ) {
        e.preventDefault();
        Checkout.countryChangeProcess( $( document ).find( '#js-selectedCountry .js-country-item.active' )[0].dataset.code, this.dataset.code, false );
      } );
    }

    // Add smooth scrolling to links with .js-hash-scroll class
    var htmlMargin = parseInt( $( 'html' ).css( 'margin-top' ) );
    var headerHeight = $( 'header.js-header' ).height();
    var scrollPosition = headerHeight + htmlMargin;
    var scrollEl = $( 'a.js-hash-scroll' );

    if ( scrollEl ) {
      scrollEl.off( 'click' ).on( 'click', function ( event ) {

        // Make sure this.hash has a value before overriding default behavior
        if ( this.hash !== '' ) {

          // Prevent default anchor click behavior
          event.preventDefault();

          // Store hash
          var hash = this.hash;

          // Using jQuery's animate() method to add smooth page scroll
          // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
          $( 'html, body' ).animate( {
            scrollTop: $( hash ).offset().top - scrollPosition,
          }, 100, function () {
            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
          } );

        } // End if
      } );
    }

    // OOCD acceptance
    $( '.oocd-consent input[type="checkbox"]' ).change( function () {
      Checkout.processNewsletter( 'click' );
    } );
  };

  Checkout.validateEmail = function ( email ) {
    //eslint-disable-next-line
    var re = /^(([^<>()\[\]\\.,;:\s@']+(\.[^<>()\[\]\\.,;:\s@']+)*)|('.+'))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test( email );
  };

  Checkout.updateHtml = function ( data ) {
    console.log( 'reinit payments' );

    if ( data.totalItems === 0 ) {

      window.location.href = location.pathname;

    } else {

      paymentMethodContainer.html( data.paymentOptions );
      shippingMethodContainer.html( data.shippingOptions );
      paymentFieldsContainer.html( data.payments );
      cartContainer.html( data.basket );
      selectedItemsContainer.html( data.items );
      selectedTotalsContainer.html( data.totals );
      voucherContainer.html( data.voucher );
      Checkout.init();

    }

  };

  Checkout.processItems = function ( url ) {
    // To avoid double send of ajax request
    if ( !cartAjaxRequestEnable ) {
      return;
    }

    // if ( !el ) { return; }

    // console.log( el, el.attr( 'href' ) );
    // var targetUrl = el.attr( 'data-href' );
    // if ( !targetUrl ) {
    //   targetUrl = el.attr( 'href' );
    // }

    // $( '.js-edit-item' ).prop( 'disabled', true );

    $.ajax( {
      type: 'GET',
      dataType: 'json',
      url: url,
      success: function ( data ) {

        if ( data.totalItems === 0 ) {
          window.location.href = location.pathname;
        } else {
          Checkout.updateHtml( data );
          console.log( data );
        }

        $( editProduct ).prop( 'disabled', false );
      },
      error: function ( request ) {
        console.debug( request );
      },
    } );
  };

  Checkout.processPaymentMethod = function ( wrapper ) {
    var paymentValue = wrapper.find( ':radio:checked' ).val();

    var sendData = $( '#esc_purchase' ).serialize();

    sendData += '&payment_method=' + paymentValue + '&ajax=1&is_checkout=1';

    console.log( 'processPaymentMethod' );

    $.ajax( {
      dataType: 'JSON',
      type: 'POST',
      data: sendData,
      success: function ( data ) {
        Checkout.updateHtml( data );
      },
      error: function ( error ) {
        console.log( error );
      },
    } );
  }

  Checkout.voucherProcess = function ( $button ) {
    var sendData = $( '#esc_purchase' ).serialize();
    var buttonName = $button.attr( 'name' );
    var buttonValue = $button.attr( 'value' );

    sendData += '&' + buttonName + '=' + buttonValue + '&ajax=1&is_checkout=1';

    //Update all HTML
    $.ajax( {
      data: sendData,
      type: 'POST',
      dataType: 'JSON',
      success: function ( data ) {
        Checkout.updateHtml( data );
      },
    } );
  };

  Checkout.countryChangeProcess = function ( countryCode, state, reloadPage ) {
    console.log( 'countryChangeProcess' );

    var sendData = 'esc_action=esc_change_country';

    if ( !state ) {
      state = '';
    }

    sendData += '&esc_country=' + countryCode + '&ajax=1';
    sendData += '&address[state]=' + state;

    //Update all HTML
    $.ajax( {
      data: sendData,
      type: 'POST',
      dataType: 'JSON',
      success: function ( data ) {
        if ( reloadPage ) {
          window.location.reload( true );
        } else {
          Checkout.updateHtml( data );
        }
      },
      error: function ( request ) {
        window.location.reload( true );
        console.debug( request );
      },
    } );
  };

  // Checkout.countryChangeProcess = function( $countryCode ) {

  //     console.log('countryChangeProcess');

  // 	var sendData = 'esc_action=esc_change_country';
  //     var form = $( '#esc_purchase' );
  //     var state = form.find( '#address_state' ).val();

  //     sendData += '&esc_country='+ $countryCode +'&ajax=1';
  //     sendData += '&address[state]=' +state;

  // 	//Update all HTML
  // 	$.ajax( {
  // 		data: sendData,
  // 		type: 'POST',
  // 		dataType: 'JSON',
  // 		success: function(data) {
  // 			Checkout.updateHtml( data );
  // 		},
  // 	} );
  // };

  Checkout.processShippingMethod = function ( wrapper ) {

    var shippingValue = wrapper.find( ':radio:checked' ).val();

    var sendData = $( '#esc_purchase' ).serialize();

    sendData += '&shipping_method=' + shippingValue + '&ajax=1';

    console.log( 'processShippingMethod' );

    $.ajax( {
      dataType: 'JSON',
      type: 'POST',
      data: sendData,
      success: function ( data ) {
        Checkout.updateHtml( data );
      },
      error: function ( error ) {
        console.log( error );
      },
    } );

  };

  Checkout.processComment = function ( action ) {

    console.log( 'send comment' );

    var value = giftContainer.find( ':checkbox:checked' ).length;
    var form = $( '#esc_purchase' );
    var sendData = form.serializeArray();
    var voucher = form.find( '#js-voucher-field button' ).val();

    $.each( sendData, function () {
      if ( this.name === 'voucher' ) {
        this.value = voucher;
      }
    } );

    sendData = $.param( sendData );

    if ( value === 0 ) {
      sendData += '&internalComment[giftwrap]=0';
    }

    sendData += '&submit_comment' + '=' + value + '&ajax=1';

    //Update all HTML
    $.ajax( {
      data: sendData,
      type: 'POST',
      dataType: 'JSON',
      success: function ( data ) {
        if ( action === 'click' ) {
          Checkout.updateHtml( data );
        }
      },
    } );
  };


  Checkout.processNewsletter = function ( action ) {
    console.log( 'newsletter' );

    var value = newsletterContainer.find( ':checkbox:checked' ).length;
    var form = $( '#esc_purchase' );
    var sendData = form.serializeArray();
    var voucher = form.find( '#js-voucher-field button' ).val();

    $.each( sendData, function () {
      if ( this.name === 'voucher' ) {
        this.value = voucher;
      }
    } );

    sendData = $.param( sendData );

    if ( value === 0 ) {
      sendData += '&address[newsletter]=0';
    }

    sendData += '&submit_newsletter' + '=' + value + '&ajax=1&is_checkout=1';

    //Update all HTML
    $.ajax( {
      data: sendData,
      type: 'POST',
      dataType: 'JSON',
      success: function ( data ) {
        if ( action === 'click' ) {
          Checkout.updateHtml( data );
        }
      },
    } );
  };

  if ( scope.length > 0 ) {
    $( document ).ready( function () {
      Checkout.init();
    } );
  }

  window.Checkout = Checkout;
} )( jQuery );

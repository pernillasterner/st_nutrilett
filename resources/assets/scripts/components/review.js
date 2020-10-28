/**
 * Created by STOK on 24/06/2019.
 */

var Reviews = {};

( function ( $ ) {
    var form = $( '#js-review-form' ),
        message = form.find( '#js-message' ),
        submitButton = form.find( 'button[type="submit"]' ),
        openTabTrigger = $( '.js-open-reviews' );

    Reviews.init = function () {
        form.submit( function ( e ) {
            e.preventDefault();

            $.ajax( {
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'process_review',
                    form: form.serializeArray(),
                },
                dataType: 'json',
                method: 'post',
                beforeSend: function () {
                    form.find( '.is-invalid' ).removeClass( 'is-invalid' );
                    message.text( '' );
                    message.hide();
                    submitButton.prop( 'disabled', true );
                },
                success: function ( result ) {
                    if ( result.success ) {
                        message.attr( 'class', 'alert alert-success' );

                        if ( typeof dataLayer !== 'undefined' ) {
                            var recommendedText = form.find( '#recommended' ).is( ':checked' ) ? 'recommended' : 'not recommended';

                            window.dataLayer.push( {
                                'recommended': recommendedText,
                                'event': 'review success',
                            } );
                        }

                        setTimeout( function () {
                            form[0].reset();
                            form.find( '.star-item' ).removeClass( 'is-active' );
                            form.find( 'button[data-dismiss="modal"]' ).click();
                            message.text( '' );
                            message.hide();
                        }, 3000 );
                    } else if ( result.data.hasOwnProperty( 'errorFields' ) && result.data.errorFields.length > 0 ) {
                        result.data.errorFields.forEach( function ( item ) {
                            var element = form.find( '[name="' + item + '"]' );

                            if ( item === 'rating' ) {
                                element = form.find( '.star-list' );
                            }

                            element.addClass( 'is-invalid' );
                        } );

                        message.attr( 'class', 'alert alert-danger' );
                    }

                    message.text( result.data.message );
                    message.show();
                    submitButton.prop( 'disabled', false );
                }
                ,
                error: function ( result ) {
                    console.log( result );
                },
            } );
        } );

        form.parents( '.modal' ).on( 'shown.bs.modal', function () {
            if ( typeof dataLayer !== 'undefined' ) {
                window.dataLayer.push( {
                    'event': 'review load',
                } );
            }
        } );
    };

    Reviews.initTab = function () {
        openTabTrigger.click( function ( e ) {
            e.preventDefault();

            var reviewsTab = $( '#js-reviews-tab' );

            if ( reviewsTab.length === 0 ) {
                return;
            }

            reviewsTab.click();

            $( 'html, body' ).animate( {
                scrollTop: reviewsTab.offset().top - $( '.navbar' ).height(),
            }, 1000 );
        } );
    };

    $( function () {
        if ( form.length !== 0 ) {
            Reviews.init();
        }

        if ( openTabTrigger.length !== 0 ) {
            Reviews.initTab();
        }
    } );
} )( jQuery );
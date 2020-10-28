var AdvancedEcommerceTracking = {};

( function ( $ ) {
    var interval = false;

    AdvancedEcommerceTracking.sentProductImpressions = [];

    AdvancedEcommerceTracking.init = function () {
        // Make sure dataLayer is available
        if ( typeof dataLayer === 'undefined' ) {
            interval = setInterval( AdvancedEcommerceTracking.init, 200 );
        }

        clearInterval( interval );

        AdvancedEcommerceTracking.runProductImpressions();
        AdvancedEcommerceTracking.runProductClicks();
    };

    AdvancedEcommerceTracking.runProductClicks = function () {
        var products = $( '.product-lists-item' );

        if ( products.length === 0 ) {
            return;
        }

        $( document ).on( 'click', '.product-lists-item', function () {
            var product = $( this );

            window.dataLayer.push( AdvancedEcommerceTracking.createProductClickData( product ) );
            console.log( window.dataLayer );
        } );
    };

    AdvancedEcommerceTracking.createProductClickData = function ( product ) {
        var data = product.find( '.js-tracking-data' ), list;

        if ( data.length === 0 ) {
            return;
        }

        data = JSON.parse( data.text() );
        list = AdvancedEcommerceTracking.getListName();

        return {
            'event': 'ee.productClick',
            'ecommerce': {
                'currencyCode': data.currency,
                'click': {
                    'actionField': { 'list': list },
                    'products': [{
                        'name': data.name,
                        'id': data.id,
                        'price': data.price,
                        'brand': data.brand,
                        'category': data.category,
                        'position': product.index() + 1,
                        'dimension3': data.dimension3,
                        'dimension4': data.dimension4,
                        'dimension5': data.dimension5,
                        'dimension6': data.dimension6,
                    }],
                },
            },
        }
    };

    AdvancedEcommerceTracking.getListName = function () {
        var body = $( 'body' ), list;

        if ( body.hasClass( 'template-product-listing page' ) ) {
            list = 'shop';
        }

        if ( body.hasClass( 'home' ) ) {
            list = 'homepage';
        }

        if ( body.hasClass( 'tax-silk_category' ) ) {
            for ( var i = 0; i < body[0].classList.length; i++ ) {
                if ( body[0].classList[i].indexOf( 'term-' ) !== -1 ) {
                    list = body[0].classList[i].replace( 'term-', '' );

                    break;
                }
            }
        }

        if ( body.hasClass( 'single-post' ) || body.hasClass( 'single-silk_products' ) ) {
            list = 'related products';
        }

        return list;
    };

    AdvancedEcommerceTracking.checkProductImpressions = function ( parent ) {
        var products = $( '.product-lists-item:visible' ),
            list = AdvancedEcommerceTracking.getListName(),
            impressions = [],
            currency;

        if ( parent ) {
            products = parent.find( '.product-lists-item:visible' );

            if ( parent.hasClass( 'js-ois-results' ) ) {
                list = 'search results';
            }
        }

        $.each( products, function () {
            var product = $( this ), data, productID;

            if ( !product.visible( true, true ) ) {
                return;
            }

            data = product.find( '.js-tracking-data' );

            if ( data.length === 0 ) {
                return;
            }

            data = JSON.parse( data.text() );
            productID = data.id;

            if ( AdvancedEcommerceTracking.sentProductImpressions.indexOf( data.id ) !== -1 ) {
                return;
            }

            impressions.push( {
                'name': data.name,
                'id': data.id,
                'price': data.price,
                'brand': data.brand,
                'category': data.category,
                'list': list,
                'position': product.index() + 1,
                'dimension3': data.dimension3,
                'dimension4': data.dimension4,
                'dimension5': data.dimension5,
                'dimension6': data.dimension6,
            } );

            AdvancedEcommerceTracking.sentProductImpressions.push( productID );

            currency = data.currency;
        } );

        if ( impressions.length === 0 ) {
            return;
        }

        window.dataLayer.push( {
            'ecommerce': {
                'currencyCode': currency,
                'impressions': impressions,
            },
            'event': 'ee.product impressions',
        } );

        console.log( window.dataLayer );
    };

    AdvancedEcommerceTracking.runProductImpressions = function () {
        var timeout;

        $( window ).on( 'scroll', function () {
            if ( timeout !== null ) {
                clearTimeout( timeout );
            }

            timeout = setTimeout( AdvancedEcommerceTracking.checkProductImpressions, 1000 );
        } );

        AdvancedEcommerceTracking.checkProductImpressions();

        // Detecting impressions on search results
        $.ajaxSetup( {
            dataFilter: function ( data, type ) {
                if ( type !== 'json' ) {
                    return data;
                }

                var parsedData = JSON.parse( data );

                if ( parsedData.hasOwnProperty( 'hits' ) ) {
                    var parent;

                    if ( parsedData.hasOwnProperty( 'current_type' ) ) {
                        // Detect results on search page only
                        parent = $( '.js-ois-search-page-results-container' );
                    } else {
                        // Detect results on search modal only
                        parent = $( '.js-ois-results' );
                    }

                    setTimeout( function () {
                        AdvancedEcommerceTracking.checkProductImpressions( parent );
                    }, 1000 );
                }

                return data;
            },
        } );

        // Detect products in flickity
        $( '.js-product-carousel' ).on( 'change.flickity', function ( event ) {
            AdvancedEcommerceTracking.checkProductImpressions( $( event.target ) );
        } );
    };

    $( AdvancedEcommerceTracking.init );

    window.AdvancedEcommerceTracking = AdvancedEcommerceTracking;
} )( jQuery );
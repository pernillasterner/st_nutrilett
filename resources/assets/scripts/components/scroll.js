
( function ( $ ) {
    var targets = $( '.js-scroll-to' );

    if ( targets.length === 0 ) {
        return;
    }

    function scrollTo( target, adjHeight ) {
        target = $( target );

        if ( typeof adjHeight === 'undefined' || adjHeight === null ) {
            adjHeight = 0;
        }

        if ( target.length === 0 ) {
            return;
        }

        var scrollTop = target.offset().top;

        // Get nav height and subtract it also
        var subnav = $( '.nav-bar' );
        if ( subnav.length > 0 ) {
            scrollTop -= parseInt( subnav.css( 'height' ) );
        }

        // Get wpadminbar height and subtract to top offset of target element
        var wpAdminBar = $( '#wpadminbar' );
        if ( wpAdminBar.length > 0 ) {
            scrollTop -= parseInt( wpAdminBar.css( 'height' ) );
        }

        if ( adjHeight > 0 ) {
            scrollTop -= parseInt( adjHeight );
        }

        // Call stop() to avoid shaking behavior in Chrome
        $( 'html, body' ).stop( true ).animate( {
            scrollTop: scrollTop,
        }, 1000 );
    }

    targets.click( function ( e ) {
        e.preventDefault();
        scrollTo( this.dataset.target );
    } );
} )( jQuery );
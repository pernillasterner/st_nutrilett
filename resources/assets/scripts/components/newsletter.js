import { stokpress } from '../util/helper';

( function ( $ ) {
    var target = $( '#js-newsletter-popup' ), cookieName = 'settings_newsletterDisplayed';

    $( function () {
        if ( target.length === 0 ) {
            return;
        }

        if ( !stokpress.getCookie( cookieName ) && !stokpress.isMobile() ) {
            target.modal( 'show' );
            stokpress.setCookie( cookieName, true, 365 );
        }
    } );
} )( jQuery );
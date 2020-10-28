// Create Element.remove() function if not exist // BECAUSE IE 11
if ( !( 'remove' in Element.prototype ) ) {
    Element.prototype.remove = function () {
        if ( this.parentNode ) {
            this.parentNode.removeChild( this );
        }
    };
}

// var stokpress = {};

export const stokpress = {
    init () {
        return true
    },

    strToBool ( str ) {
        console.log( typeof str );
        if ( typeof str == 'boolean' ) {
            return str;
        }
        switch ( str.toLowerCase().trim() ) {
            case 'true': case 'yes': case '1': return true;
            case 'false': case 'no': case '0': case null: return false;
            default: return Boolean( str );
        }
    },

    findAncestor ( el, cls ) {
        while ( ( el = el.parentElement ) && !el.classList.contains( cls ) );
        return el;
    },

    isMobile () {
        let result = false;
        ( function ( a ) {
            result = /Android|webOS|iPhone|iPad|BlackBerry|Windows Phone|Opera Mini|IEMobile|Mobile/i.test( a );
        } )( navigator.userAgent || navigator.vendor || window.opera );

        return result;
    },

    isInView ( el, view ) {
        var rect = el.getBoundingClientRect();
        var html = document.documentElement;

        if ( view == 'completely' ) {
            // to check if completely visible
            return (
                rect.top >= 0 &&
                rect.bottom <= ( window.innerHeight || html.clientHeight )
            );
        } else if ( view == 'partially' ) {
            // to check if partially visible
            return (
                rect.bottom >= 0 &&
                rect.top < ( window.innerHeight || html.clientHeight )
            );
        } else {
            // if partially visible or above current fold,
            return (
                rect.top < ( window.innerHeight || html.clientHeight )
            );
        }
    },

    getScript ( source, callback ) {
        var script = document.createElement( 'script' );
        var prior = document.getElementsByTagName( 'script' )[0];
        script.async = 1;

        script.onload = script.onreadystatechange = function ( _, isAbort ) {
            if ( isAbort || !script.readyState || /loaded|complete/.test( script.readyState ) ) {
                script.onload = script.onreadystatechange = null;
                script = undefined;

                if ( !isAbort ) {
                    if ( callback ) {
                        callback();
                    }
                }
            }
        };

        script.src = source;
        prior.parentNode.insertBefore( script, prior );
    },

    setCookie ( cname, cvalue, exdays ) {
        var d = new Date();
        d.setTime( d.getTime() + ( exdays * 24 * 60 * 60 * 1000 ) );
        var expires = 'expires=' + d.toUTCString();
        document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/';
    },

    getCookie ( cname ) {
        var name = cname + '=';
        var decodedCookie = decodeURIComponent( document.cookie );
        var ca = decodedCookie.split( ';' );
        for ( var i = 0; i < ca.length; i++ ) {
            var c = ca[i];
            while ( c.charAt( 0 ) == ' ' ) {
                c = c.substring( 1 );
            }
            if ( c.indexOf( name ) == 0 ) {
                return c.substring( name.length, c.length );
            }
        }
        return '';
    },

    replaceUrlParam ( url, paramName, paramValue ) {
        if ( paramValue == null ) {
            paramValue = '';
        }
        var pattern = new RegExp( '\\b(' + paramName + '=).*?(&|#|$)' );
        if ( url.search( pattern ) >= 0 ) {
            return url.replace( pattern, '$1' + paramValue + '$2' );
        }
        url = url.replace( /[?#]$/, '' );

        return url + ( url.indexOf( '?' ) > 0 ? '&' : '?' ) + paramName + '=' + paramValue;
    },
}

export const stokpressViewPort = {
    init () {
        return true
    },

    documentWidth () {
        let e = window, a = 'inner';

        if ( !( 'innerWidth' in window ) ) {
            a = 'client';
            e = document.documentElement || document.body;
        }

        return { width: e[a + 'Width'], height: e[a + 'Height'] };
    },
}

// this will remove has-breadcrumbs class if section has content above
if (document.getElementById('sectionIsIncluded')) {
    $('#section-1').removeClass('has-breadcrumbs');
}
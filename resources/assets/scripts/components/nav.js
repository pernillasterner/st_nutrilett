import { viewportWidth } from '../util/viewPort';
var disableBodyScroll = require( '../util/disableBodyScroll' );

var nav = {};

nav.activeHover = function () {
  var el, leftPos, newWidth,
    mainNav = $( '.navbar-start' ),
    speedNav = 200;

  if ( viewportWidth().width > 991 ) {
    mainNav.append( '<div class="line-hover"><div class="line-wrapper"><div class="line-move"></div></div></div>' );
  }

  var magicLine = $( '.line-move' );

  if ( magicLine.length ) {
    if ( $( '.nav > li' ).hasClass( 'active' ) ) {
      magicLine.css( {
        'left': $( '.nav > li.active' ).position().left + 13,
        'width': $( '.nav > li.active > a' ).width(),
      } ).data( 'origLeft', magicLine.position().left );
    } else {
      magicLine.css( {
        'left': -$( '.nav > li:first > a' ).width(),
        'width': $( '.nav > li:first > a' ).width(),
      } ).data( 'origLeft', magicLine.position().left );
    }
  }

  $( '.nav > li' ).hover( function () {
    el = $( this );
    leftPos = el.position().left;
    newWidth = el.children().width();
    magicLine.stop().animate( {
      left: leftPos + 13,
      width: newWidth,
    }, speedNav );
  }, function () {
    magicLine.stop().animate( {
      left: magicLine.data( 'origLeft' ),
      width: $( '.nav > li.active > a' ).width(),
    }, speedNav );
  } );
};

nav.activeHoverResize = function () {
  if ( !$( '.line-hover' ).length && viewportWidth().width > 991 ) {
    nav.activeHover();
  }

  if ( $( '.line-hover' ).length && viewportWidth().width < 992 ) {
    $( '.line-move' ).data( 'origLeft', 0 );
    $( '.line-hover' ).remove();
  }
};


nav.scrollNav = function () {
  var el = document.querySelector( '.nav-bar' );
  if ( document.body.scrollTop > 100 || document.documentElement.scrollTop > 100 ) {
    el.classList.add( 'is-fixed' );
  }
  else {
    el.classList.remove( 'is-fixed' );
  }
};

nav.burgerMenu = function () {
  var i;
  var navToggle = document.querySelectorAll( '.js-nav-toggle' );
  var overlay = $( '.js-ois-overlay' );
  const elHtml = document.querySelector( 'html' );
  const parentBlock = document.querySelector( '.nav-header' );

  for ( i = 0; i < navToggle.length; i++ ) {
    navToggle[i].addEventListener( 'click', function () {

      elHtml.classList.toggle( 'is-fixed' );

      parentBlock.classList.toggle( 'is-open' );

      if ( parentBlock.classList.contains( 'is-open' ) ) {
        disableBodyScroll( true, '.nav' );
      }
      else {
        disableBodyScroll( false, '.nav' );
      }

      // Close mobile search results
      setTimeout( () => {
        if ( overlay.hasClass( 'is-open' ) && overlay.data( 'searched' ) === 'false' ) {
          jQuery( '.js-ois-trigger' )[0].click()
        } else {
          overlay.data( 'searched', 'false' );
        }
      }, 100 );
    } );
  }
};

nav.searchOpen = function () {
  var i;
  var searchToggle = document.querySelectorAll( '.js-search-open' );
  var searchBar = document.querySelector( '.js-search-bar' );
  var searchBtn = document.querySelector( '.search-btn' );
  var searchClose = document.querySelector( '.search-close' );
  var searchInput = document.querySelector( '.search-input' );
  var prodFilter = document.querySelector( '.product-filter' );
  var elHtml = document.querySelector( 'html' );
  var prodFilt = document.querySelector( '.product-filter-wrapper' );

  for ( i = 0; i < searchToggle.length; i++ ) {
    searchToggle[i].addEventListener( 'click', function ( e ) {
      e.preventDefault();

      if ( prodFilt != null ) {
        if ( prodFilt.classList.contains( 'is-filter-open' ) ) {
          document.querySelector( '.js-close-filter' ).click();
        }
      }

      this.classList.toggle( 'is-active' );
      searchBar.classList.toggle( 'is-open' );
      elHtml.classList.toggle( 'is-fixed' );

      if ( prodFilt != null ) {
        prodFilter.classList.toggle( 'd-none' );
      }

      if ( searchBar.classList.contains( 'is-open' ) ) {
        disableBodyScroll( true, '.search-fixed' );
      }
      else {
        disableBodyScroll( false, '.search-fixed' );
      }
    } );
  }

  searchClose.addEventListener( 'click', function ( e ) {
    e.preventDefault();
    this.classList.remove( 'is-open' );
    searchBtn.classList.add( 'is-open' );
    searchInput.value = '';
  } );

  searchInput.addEventListener( 'keyup', function () {
    if ( this.value ) {
      searchBtn.classList.remove( 'is-open' );
      searchClose.classList.add( 'is-open' );
    }
    else {
      searchBtn.classList.add( 'is-open' );
      searchClose.classList.remove( 'is-open' );
    }
  } );
};


$( document ).ready( function () {
  nav.activeHover();
  nav.scrollNav();
  nav.burgerMenu();
  nav.searchOpen();
} );

$( window ).resize( function () {
  nav.activeHoverResize();
} );

window.onscroll = function () { nav.scrollNav() };
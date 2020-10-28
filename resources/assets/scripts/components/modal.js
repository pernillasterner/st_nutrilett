import { viewportWidth } from '../util/viewPort';
let modal = {};

modal.init = () => {
  modal.action( '#js-newsletter-popup' );
  modal.action( '#js-product-status-popup' );
}

modal.action = ( modal ) => {
  $( modal ).on( 'shown.bs.modal', function () {
    $( 'body' ).css( 'padding-right', '0' );
    $( '.nav-bar' ).css( 'padding-right', '0' );
    $( this ).css( 'padding-right', '0' );
  } )
}

modal.resize = ( modal ) => {
  if ( viewportWidth().width < 1220 ) {
    $( modal ).modal( 'hide' );
  }
}

$( document ).ready( function () {
  modal.init();
} );

$( window ).resize( function () {
  modal.resize( '#js-newsletter-popup' );
} );

modal.resize( '#js-newsletter-popup' );

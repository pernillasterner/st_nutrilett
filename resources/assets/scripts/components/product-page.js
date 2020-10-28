import 'flickity/dist/flickity.pkgd';
// eslint-disable-next-line no-unused-vars
// import resizeJS from 'css-element-queries/src/ResizeSensor';
import StickySidebar from 'sticky-sidebar/dist/sticky-sidebar';
import { iosFlickityFix } from '../util/iosFlickityFix';

let product = {};
let container = $( 'section.section-product-page' );
let carouselStatus = $( '.js-carousel-status' );
let productSlider = $( '.js-product-slider' );
let flktyData;
let productSidebar = $( '#js-product-sidebar' );
let stickySidebar;
let spacing;
let price = container.find( '#js-price' );
let priceMobile = container.find( '#js-price-mobile' );
let productId = container.find( 'input[name="esc_post"]' );
let productItem = container.find( 'input[name="esc_product_item"]' );

product.flickityActivate = () => {
  if ( !productSlider.length ) {
    return false;
  }

  productSlider.flickity( {
    contain: true,
    prevNextButtons: true,
    pageDots: false,
    // lazyLoad: true,
  } );

  flktyData = productSlider.data( 'flickity' );
  product.updateStatus( flktyData );

  productSlider.on( 'select.flickity', function ( event, index ) {
    let slideNumber = index + 1;
    carouselStatus.html( slideNumber + ' / ' + flktyData.slides.length );

    let selectedProductSlideMobile = $( '.mobile-product-item.is-selected' );
    if ( selectedProductSlideMobile ) {
      productSlider.find( '.bundle' ).appendTo( selectedProductSlideMobile.find( '.feature' ) );
    }
  } );
}

product.starHover = function () {
  $( '.js-rating-radio .star-item' ).hover( function () {
    var itemCount = $( this ).index();
    $( '.js-rating-radio .star-item' ).removeClass( 'icon-fill' );
    product.starCounter( itemCount );
  } );
};

product.starHoverOut = function () {
  $( '.js-rating-radio' ).on( 'mouseleave', function () {
    $( '.js-rating-radio .star-item' ).removeClass( 'icon-fill' );
    var itemCount = $( '.js-rating-radio input:checked' ).index();
    product.starCounter( itemCount );
  } );
}

product.starClick = function () {
  $( '.js-rating-radio .star-item' ).on( 'click', function () {
    var itemCounter = $( this ).index();
    product.starCounter( itemCounter, true );
    console.log( $( 'input[name="rating"]:checked' ).val() );
  } );
};

product.starCounter = function ( liCount, radioChecked ) {
  if ( radioChecked ) {
    var childElem = liCount + 1;
    $( '.radio-stars input:nth-child(' + childElem + ')' ).prop( 'checked', true );
  } else {
    for ( var i = 0; i <= liCount; i++ ) {
      var childEl = i + 1;
      $( '.js-rating-radio .star-item:nth-child(' + childEl + ')' ).delay( 500 ).addClass( 'icon-fill' );
    }
  }
};

product.toggleReview = () => {
  $( '.js-toggle-review-form' ).on( 'click', function ( e ) {
    e.preventDefault();
    $( '.review-form' ).fadeToggle( 'slow' );
    $( '#js-review-form' ).trigger( 'reset' );
  } );
}

product.updateStatus = ( data ) => {
  let slideNumber = data.selectedIndex + 1;
  carouselStatus.html( slideNumber + ' / ' + data.slides.length );
};

product.sticky = () => {
  var navHeight = $( '.nav-header' ).outerHeight();
  var filterHeight = $( '.product-filter' ).outerHeight();
  if ( $( 'body' ).hasClass( 'admin-bar' ) ) {
    spacing = 32 + navHeight + filterHeight;
  } else {
    spacing = navHeight + filterHeight;
  }

  if ( productSidebar.length > 0 ) {
    stickySidebar = new StickySidebar( '#js-product-sidebar', {
      containerSelector: '.js-container-product',
      innerWrapperSelector: '.product-sidebar',
      topSpacing: spacing,
      minWidth: 991,
      resizeSensor: true,
    } );
  }
};

product.updateSpecialProductPrice = () => {
  let selectedBundle = container.find( '.js-selected-bundle:checked' ),
    saleFields = container.find( '.sale' ),
    discount = selectedBundle.data( 'discount' );

  if ( selectedBundle.length === 0 ) {
    return;
  }

  if ( container.data( 'productType' ) === 'Special' ) {
    productId.val( selectedBundle.val() );
    productItem.val( selectedBundle.data( 'productItem' ) );
  }

  if ( discount ) {
    saleFields.html( discount + '%' );
    saleFields.show();
    price.html( '<div class="old-price h4 mb-0">' + selectedBundle.data( 'priceBeforeDiscount' ) + '</div><div class="h1 d-inline-block">' + selectedBundle.data( 'price' ) + '</div>' );
    priceMobile.html( '<div class="old-price">' + selectedBundle.data( 'priceBeforeDiscount' ) + '</div><div class="main-price">' + selectedBundle.data( 'price' ) + '</div>' );
  } else {
    saleFields.hide();
    price.html( selectedBundle.data( 'price' ) );
    priceMobile.html( selectedBundle.data( 'price' ) );
  }
};

product.init = () => {
  if ( $( 'body.single-silk_products' ).length === 0 ) {
    return;
  }

  if ( container.data( 'productType' ) === 'Special' ) {
    product.updateSpecialProductPrice();
  } else if ( container.data( 'productType' ) === 'Single' ) {
    container.find( 'input[name="esc_amount"][type="hidden"]' ).remove();
  }

  // Synchronize selected bundles
  $( document ).on( 'change', ( 'section.section-product-page .js-selected-bundle-mobile' ), () => {
    let selectedBundle = container.find( '.js-selected-bundle-mobile:checked' );

    container.find( '.js-selected-bundle[value="' + selectedBundle.val() + '"]' ).click();
  } );

  // Update price when bundle is selected
  container.find( '.js-selected-bundle' ).change( () => {
    product.updateSpecialProductPrice();
  } );

  container.find( '.js-submit-mobile' ).click( () => {
    container.find( '#js-selectProduct' ).submit();
  } );
};

product.updateSticky = () => {
  $( '#product-accordion' ).on( 'shown.bs.collapse', function ( e ) {
    stickySidebar.updateSticky();
    let navHeight = $( '.nav-bar' ).height();
    let spacing;
    if ( $( 'body' ).hasClass( 'admin-bar' ) ) {
      spacing = navHeight + 32;
    } else {
      spacing = navHeight;
    }
    var $card = $( e.target ).closest( '.card' );
    $( 'html,body' ).animate( {
      scrollTop: $card.offset().top - spacing,
    }, 500 );
  } );

  $( '#product-accordion' ).on( 'hidden.bs.collapse', function () {
    stickySidebar.updateSticky();
  } );
};

document.addEventListener( 'DOMContentLoaded', function () {
  product.init();
  product.flickityActivate();
  iosFlickityFix();
  product.sticky();
  product.updateSticky();
  product.starHover();
  product.starClick();
  product.starHoverOut();
  product.toggleReview();
} );

window.addEventListener( 'resize', function () {
  if ( productSidebar.length > 0 ) {
    stickySidebar.updateSticky();
  }
} );

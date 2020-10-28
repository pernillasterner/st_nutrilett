import 'flickity/dist/flickity.pkgd';
import { iosFlickityFix } from '../util/iosFlickityFix';

let products = {},
  tags = [],
  productsToFilter,
  currentSort;

products.flickityActivate = () => {
  if ( !$( '.js-product-carousel' ).length ) {
    return false;
  }

  $( '.js-product-carousel' ).flickity( {
    cellAlign: 'left',
    contain: true,
    prevNextButtons: false,
    pageDots: false,
    // lazyLoad: 100,
  } );
}

products.showMore = () => {
  const productListContainer = document.querySelectorAll( '.js-product-mobile' );

  for ( let i = 0; i < productListContainer.length; i++ ) {
    const productLists = productListContainer[i].querySelector( '.product-lists' );
    const productItems = productListContainer[i].querySelectorAll( '.product-lists-item' );
    const displayMobile = productLists.getAttribute( 'data-item-mobile' );
    const btnShow = productListContainer[i].querySelector( '.js-show-items' );
    const btnWrap = productListContainer[i].querySelector( '.load-more' );

    products.showHide( productItems, displayMobile, 'hide' );

    btnShow.addEventListener( 'click', function ( e ) {
      e.preventDefault();
      products.showHide( productItems, displayMobile, 'show' );

      btnWrap.remove();
    } );

  }
}

products.showHide = ( items, count, status ) => {
  for ( let i = 3; i < items.length; i++ ) {
    if ( status == 'hide' && i >= count ) {
      items[i].classList.add( 'hide-mobile' );
    }
    else {
      items[i].classList.remove( 'hide-mobile' );
    }
  }
}

products.updatePrice = ( selectedBundle ) => {
  let parent = selectedBundle.parents( '.prod-item' ),
    saleFields = parent.find( '.sale' ),
    discount = selectedBundle.data( 'discount' ),
    price = parent.find( '.price' ),
    productId = parent.find( 'input[name="esc_post"]' ),
    productItem = parent.find( 'input[name="esc_product_item"]' );

  if ( selectedBundle.length === 0 ) {
    return;
  }

  if ( parent.data( 'type' ) === 'Special' ) {
    productId.val( selectedBundle.val() );
    productItem.val( selectedBundle.data( 'productItem' ) );
  }

  if ( discount ) {
    saleFields.html( discount + '%' );
    saleFields.show();
    price.html( '<span class="old-price">' + selectedBundle.data( 'priceBeforeDiscount' ) + '</span>' + selectedBundle.data( 'price' ) );
  } else {
    saleFields.hide();
    price.html( selectedBundle.data( 'price' ) );
  }
}

products.initTags = () => {
  productsToFilter = $( '.js-product-listing-page-items .product-lists-item' );

  // Populate product tags
  productsToFilter.each( function () {
    let element = $( this );

    if ( element.data( 'tags' ) ) {
      tags = tags.concat( element.data( 'tags' ).split( '|' ) );
    }
  } );

  // tags = Array.from( new Set( tags ) ); Note: does not work in IE11
  var tagsUnique = tags.filter( function ( item, index ) {
    return tags.indexOf( item ) >= index;
  } );
  tags = tagsUnique;

  if ( tags.length === 0 ) {
    return;
  }

  let column1 = $( '#js-filter-column1' ), column2 = $( '#js-filter-column2' );

  // Display tags in two columns
  tags.forEach( ( value, index ) => {
    let html = `<div class="filter-attribute-wrap-item">
    <a href="">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input js-filter-product-category" value="${value}" id="js-filter-product-category-${value}">
        <label class="custom-control-label" for="js-filter-product-category-${value}">${value}</label>
      </div>
    </a>
  </div>`;

    if ( index % 2 === 0 ) {
      column1.append( html );
    } else {
      column2.append( html );
    }
  } );
}

products.initUpdateFilter = () => {
  $( '.template-product-listing .js-filter-update,.tax-silk_category .js-filter-update' ).click( () => {
    // Product tags filtering    
    let selectedTags = $.map( $( '.js-filter-product-category:checked' ), ( item ) => {
      return item.value;
    } );

    // Reset containers
    $( '#js-products-container' ).parents( 'section' ).removeClass( 'd-none' );
    $( '#js-bundles-container' ).parents( 'section' ).removeClass( 'd-none' ).removeClass( 'has-breadcrumbs' );

    // Filtering
    if ( selectedTags.length === 0 ) {
      productsToFilter.show();
    } else {
      productsToFilter.hide();
      productsToFilter.filter( ( index, element ) => {
        element = $( element );
        if ( !element.data( 'tags' ) ) {
          return false;
        }

        // selectedTags.includes( value ) Note: includes does not work in IE11
        let common = element.data( 'tags' ).split( '|' ).filter( value => ( selectedTags.indexOf( value ) > -1 ) );
        return common.length > 0;
      } ).show().removeClass( 'hide-mobile' );
    }

    // will remove load-more when trigger filter
    $( '.load-more' ).remove();

    // Sorting
    if ( currentSort ) {
      $( '#js-products-container > div' ).sort( products.sort ).appendTo( '#js-products-container' );
      $( '#js-bundles-container > div' ).sort( products.sort ).appendTo( '#js-bundles-container' );
    }

    // Container adjustments
    let visibleProducts = $( '#js-products-container > div:visible' ).length;
    let visibleBundles = $( '#js-bundles-container > div:visible' ).length;

    if ( visibleProducts === 0 ) {
      $( '#js-products-container' ).parents( 'section' ).addClass( 'd-none' );
      $( '#js-bundles-container' ).parents( 'section' ).addClass( 'has-breadcrumbs' );
    }

    if ( visibleBundles === 0 ) {
      $( '#js-bundles-container' ).parents( 'section' ).addClass( 'd-none' );
    }

    // Close filter    
    $( '.template-product-listing .js-close-filter,.tax-silk_category .js-close-filter' ).click();

    if ( window.hasOwnProperty( 'AdvancedEcommerceTracking' ) ) {
      window.AdvancedEcommerceTracking.checkProductImpressions();
    }
  } );

  // Clear filter
  $( '.template-product-listing .js-clear-filter,.tax-silk_category .js-clear-filter' ).click( () => {
    $( '.js-filter-product-category' ).prop( 'checked', false );
    $( '.js-sort' ).removeClass( 'active' ).removeClass( 'sort-asc' ).removeClass( 'sort-desc' );
  } );
}

products.sort = ( a, b ) => {
  let result;

  if ( currentSort.orderby === 'title' ) {
    result = ( $( b ).data( 'name' ) ) < ( $( a ).data( 'name' ) ) ? 1 : -1;
  } else if ( currentSort.orderby === 'menu_order' ) {
    result = ( $( b ).data( 'index' ) ) < ( $( a ).data( 'index' ) ) ? 1 : -1;
  } else if ( currentSort.orderby === 'price' ) {
    result = ( $( b ).data( 'price' ) ) < ( $( a ).data( 'price' ) ) ? 1 : -1;
  }

  if ( currentSort.order === 'desc' ) {
    result = result === 1 ? -1 : 1;
  }

  return result;
}

products.initSorting = () => {
  // Category sorting
  $( '.template-product-listing .js-sort,.tax-silk_category .js-sort' ).click( function ( e ) {
    e.preventDefault();
    $( '.template-product-listing .js-sort,.tax-silk_category .js-sort' ).attr( 'class', 'filter-attribute-wrap-item js-sort sort-asc' );
    $( this ).addClass( 'active' );

    let order = $( this ).data( 'order' ), orderby = $( this ).data( 'orderby' );

    if ( currentSort && currentSort.orderby === orderby && currentSort.order === order ) {
      order = order === 'asc' ? 'desc' : 'asc';
    }

    $( this ).removeClass( 'sort-asc' ).removeClass( 'sort-desc' ).addClass( 'sort-' + order );

    currentSort = {
      'order': order,
      'orderby': orderby,
    };
  } );
}

products.init = () => {
  products.flickityActivate();
  iosFlickityFix();
  products.showMore();

  // Update price when bundle is selected
  $( '.js-selected-bundle' ).change( ( e ) => {
    products.updatePrice( $( e.target ) )
  } );

  $( '.prod-item .js-selected-bundle:checked' ).each( function () {
    products.updatePrice( $( this ) )
  } );

  products.initTags();
  products.initSorting();
  products.initUpdateFilter();
};


document.addEventListener( 'DOMContentLoaded', function () {
  products.init();
} );

window.initProducts = products.init;
import 'masonry-layout/dist/masonry.pkgd';
import 'flickity/dist/flickity.pkgd';
import { iosFlickityFix } from '../util/iosFlickityFix';
import { viewportWidth } from '../util/viewPort';

const articles = {};

var flckActive = false,
  masonActive = false,
  loadMoreButton = false;

var masonryOptions = {
  itemSelector: '.card-item',
  horizontalOrder: true,
};
// initialize Masonry
var $grid = $('.js-articles-masonry').masonry( masonryOptions );

articles.flckInit = () => {
  $( '.js-articles-masonry' ).flickity( {
    cellAlign: 'left',
    contain: true,
    prevNextButtons: false,
    pageDots: false,
  } );
}

articles.masonActivate = () => {
  if ( !$( '.js-articles-masonry' ).length ) {
    return false;
  }

  if ( $( '.js-articles-masonry' ).hasClass( 'flickity-mobile' ) ) {
    if ( viewportWidth().width > 767 ) {
      $grid.masonry('reloadItems').masonry('layout');

      flckActive = false;
      masonActive = true;
    }
    else {
      articles.flckInit();

      flckActive = true;
      masonActive = false;
    }
  }
  else {
    $grid.masonry('reloadItems').masonry('layout');
  }
}

articles.masonFlkMobile = () => {
  if ( !$( '.flickity-mobile' ).length ) {
    return false;
  }

  if ( viewportWidth().width > 767 ) {
    // desktop
    if ( flckActive == true && masonActive == false ) {
      $( '.js-articles-masonry' ).flickity( 'destroy' );
      $grid.masonry('reloadItems').masonry('layout');

      flckActive = false;
      masonActive = true;
    }
  }
  else {
    // mobile
    if ( flckActive == false && masonActive == true ) {
      $( '.js-articles-masonry' ).masonry( 'destroy' );
      articles.flckInit();

      flckActive = true;
      masonActive = false;
    }
  }

}

articles.flckActivate = () => {
  if ( !$( '.js-articles-flickity' ).length ) {
    return false;
  }

  // $( '.lazy' ).load( function () {
    // $( '.js-articles-flickity' ).flickity( {
    //   cellAlign: 'left',
    //   contain: true,
    //   prevNextButtons: false,
    //   pageDots: false,
      // lazyLoad: 100,
    // } );
  // } );

  window.addEventListener( 'load', function() {
    $( '.js-articles-flickity' ).flickity( {
      cellAlign: 'left',
      contain: true,
      prevNextButtons: false,
      pageDots: false,
    } );
  });
}

articles.init = () => {
  // $( '.lazy' ).load( function () {
    $( '.js-articles-masonry' ).imagesLoaded( function () {
      articles.masonActivate();
    } );
  // } );

  // Article Ajax Load More Start Here
  loadMoreButton = $( '.article-loadmore' );

  loadMoreButton.on( 'click', function () {
    var currentPage = $( this ).data( 'currentpage' );
    var nextPage = currentPage + 1;
    articleLoad( nextPage );
    $( this ).data( 'currentpage', nextPage );
  } );

  // Category filtering
  $( '.category .js-filter-category' ).change( function () {
    let categoryIds = [];

    $( '.category .js-filter-category' ).each( function () {
      if ( $( this ).is( ':checked' ) ) {
        categoryIds.push( $( this ).val() );
      }
    } );

    loadMoreButton.data( 'currentterm_id', categoryIds.join( ',' ) );
  } );

  // Category sorting
  $( '.category .js-sort' ).click( function ( e ) {
    e.preventDefault();
    $( '.category .js-sort' ).attr( 'class', 'filter-attribute-wrap-item js-sort sort-asc' );
    $( this ).addClass( 'active' );

    let order = $( this ).data( 'order' ), orderby = $( this ).data( 'orderby' );

    if ( loadMoreButton.data( 'orderby' ) === orderby && loadMoreButton.data( 'order' ) === order ) {
      order = order === 'asc' ? 'desc' : 'asc';
    }

    $( this ).removeClass( 'sort-asc' ).removeClass( 'sort-desc' ).addClass( 'sort-' + order );
    loadMoreButton.data( 'order', order );
    loadMoreButton.data( 'orderby', orderby );
  } );

  // Category filter update
  $( '.category .js-filter-update' ).click( function () {
    articleLoad( 1 );
    loadMoreButton.data( 'currentpage', 1 );
    $( '.category .js-close-filter' ).click();
  } );

  articles.flckActivate();
  iosFlickityFix();
}

document.addEventListener( 'DOMContentLoaded', function () {
  articles.init();
} );

window.onresize = function () {
  articles.masonFlkMobile();
  iosFlickityFix();
};

function articleLoad ( nextPage ) {
  var ajaxUrl = loadMoreButton.data( 'ajaxurl' );
  var order = loadMoreButton.data( 'order' );
  var orderBy = loadMoreButton.data( 'orderby' );
  var postsPerPage = loadMoreButton.data( 'postsperpage' );
  var currentTermId = loadMoreButton.data( 'currentterm_id' );
  // /wp-json/wp/v2/posts?per_page=10&page=1&categories=4,5&order=desc&order_by=post_date
  ajaxUrl += '?page=' + nextPage;
  ajaxUrl += '&per_page=' + postsPerPage;
  ajaxUrl += '&categories=' + currentTermId;
  ajaxUrl += '&order=' + order;
  ajaxUrl += '&orderby=' + orderBy;
  // console.log(ajaxUrl);
  $.ajax( {
    url: ajaxUrl,
    type: 'GET',
    beforeSend: function () {
      loadMoreButton.addClass( 'd-none' );
      $( '.article-spinner' ).removeClass( 'd-none' );
    },
    error: function ( data, textStatus ) {
      console.log( data );
      console.log( textStatus );
    },
    success: function ( data, textStatus, jqXHR ) {
      if ( data ) {

        // Need to clear list if Filter is trigger
        if ( nextPage == 1 ) {
          $( '.card-lists' ).html( '' );
        }

        if ( $( data ).length > 0 ) {
          $( data ).each( function ( key, val ) {
            $( '.card-lists' ).append( val.article_item );
          } );
        }

        var totalCount = parseInt( jqXHR.getResponseHeader( 'X-WP-Total' ), 10 );
        // if ($('.js-total-count')) {
        // 	$('.js-total-count').text( totalCount );
        // }

        if ( totalCount === 0 ) {
          loadMoreButton.addClass( 'd-none' );
        }

        var totalPage = parseInt( jqXHR.getResponseHeader( 'X-WP-TotalPages' ), 10 );
        if ( loadMoreButton.data( 'currentpage' ) == totalPage || data.length == 0 )
          loadMoreButton.addClass( 'd-none' ); // if last page, remove the button
      } else {
        loadMoreButton.addClass( 'd-none' ); // if no data, remove the button as well
      }
    },
    complete: function () {
      if ( window.lazyLoadInstance ) {
        window.lazyLoadInstance.update();
      }

      $( '.js-articles-masonry' ).imagesLoaded( function () {          
        loadMoreButton.removeClass( 'd-none' );
        $( '.article-spinner' ).addClass( 'd-none' );

        $grid.masonry('reloadItems').masonry('layout');
        $('.card-item').css('opacity', 1);
      } );
    },
  } );
}

window.initArticles = articles.masonInit;
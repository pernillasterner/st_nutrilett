// import external dependencies
import 'jquery';

// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import LazyLoad from 'vanilla-lazyload';

// Require Util
require( './util/bgImage.js' );
require( './util/crossPlatform.js' );

// Require Components
require( './components/nav.js' );
require( './components/modal.js' );
require( './components/product-filter.js' );
require( './components/scroll.js' );
require( './components/faq.js' );
require( './components/product-lists.js' );
require( './components/articles.js' );
require( './components/product-page.js' );
require( './components/file-upload.js' );
require( './components/address-sidebar.js' );
require( './components/newsletter.js' );
require( './components/contact.js' );
require( './components/cart' );
require( './components/checkout.js' );
require( './components/review.js' );
require( './vendor/jquery.visible.js' );
require( './components/advanced-ecommerce-tracking.js' );

/** Populate Router instance with DOM routes */
const routes = new Router( {
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
} );

// Load Events
// jQuery(document).ready(() => routes.loadEvents());

// Load Events
jQuery( document ).ready( () => {
  routes.loadEvents();
  console.log( 'init' );

  let lazyLoadInstance = new LazyLoad( {
    threshold: 0,
    elements_selector: '.lazy',
  } );

  if ( lazyLoadInstance ) {
    lazyLoadInstance.update();
  }

  window.lazyLoadInstance = lazyLoadInstance;
} );
